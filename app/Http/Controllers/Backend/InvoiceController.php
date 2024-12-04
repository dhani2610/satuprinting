<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;


class InvoiceController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('invoice.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any divisi !');
        }

        $data['page_title'] = 'Invoice';
        // $data['invoices'] = Invoice::where('deleted_at',null)->orderBy('created_at','desc')->get();

        $customer = $request->input('customer');
        $team = $request->input('team');
        $project = $request->input('project');
        $status = $request->input('status');
        $dateRange = $request->input('date');

        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;
        $id_divisi = $this->user->id_divisi;

        if (is_null($dateRange)) {
            // Jika date null, set default tanggal dari awal bulan sampai akhir bulan ini
            $start_date = null;
            $end_date = null;
        } else {
            // Pisahkan date range menjadi start_date dan end_date
            list($start_date, $end_date) = explode(' - ', $dateRange);
    
            // Ubah format tanggal dari m/d/Y menjadi Y-m-d
            $start_date = Carbon::createFromFormat('m/d/Y', trim($start_date))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', trim($end_date))->format('Y-m-d');
        }
        
        $data['invoices'] = DB::table('invoices')
        ->join('purchase_orders', 'purchase_orders.id', '=', 'invoices.id_po')
        ->join('projects', 'projects.id', '=', 'invoices.id_project')
        ->select('invoices.*')->whereNull('invoices.deleted_at')->orderBy('invoices.created_date','desc')->where(function($query) use ($id_user,$userRole,$team,$customer,$start_date, $end_date,$project,$status) {
            if ($customer != null) {
                $query->where('purchase_orders.customer_id', $customer);
            }
            if ($project != null) {
                $query->where('projects.id', $project);
            }
            if ($status != null) {
                $query->whereIn('invoices.id', idStatusInvoice($status));
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                if ($team != null) {
                    $query->where('invoices.created_by', $team);
                }else{
                    $query->where('invoices.created_by', $id_user);
                }
            }
            if ($start_date != null && $end_date != null) {
                $query->whereBetween('invoices.created_date', [$start_date, $end_date]);
            }

        })->get();
        $data['totalRemaining'] = totalRemainingProject($data['invoices']->pluck('id'));

        $data['cust_inv'] = PurchaseOrder::whereIn('id',$data['invoices']->pluck('id_po'))->get()->pluck('customer_id')->unique();
        $data['project'] = Project::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $data['total_bill'] = $data['invoices']->sum('grand_total');
        $data['purchaseOrder'] = PurchaseOrder::orderBy('created_at','desc')->get();
        $data['services'] = Services::orderBy('created_at','desc')->get();


        // filter 
        $data['customer'] = Admin::where('type','customer')->orderBy('name','asc')->get();

        // dd($data['services']);
        return view('backend.pages.transaction.invoice.index', $data);
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('invoice.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any invoice !');
        }

        try {
            $cleanedTotal = $this->toInt($request->total);
            $cleanedTotalPPn = $this->toInt($request->total_ppn);
            $cleanedGrandTotal = $this->toInt($request->grand_total);
            $cleanedBill = $this->toInt($request->bill);
            // dd($cleanedBill,$request->all());

            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastinv = Invoice::orderBy('id', 'desc')->where('deleted_at',null)->first();
            if ($lastinv) {
                $parts = explode('-', $lastinv->no_inv);
                $lastinvNumber = intval($parts[1]); // Mengambil bagian nomor dan mengonversi ke integer
                $newinvNumber = $lastinvNumber + 1;
            } else {
                $newinvNumber = 1;
            }
            $newinvNumberFormatted = 'INV-' . str_pad($newinvNumber, 3, '0', STR_PAD_LEFT);

            $data = new Invoice();
            $data->no_inv = $newinvNumberFormatted;
            $data->id_project = $request->id_project;
            $data->id_po = $request->id_po;
            $data->created_date = $request->created_date;
            $data->deadline = $request->deadline_date; // Pastikan untuk menangani nilai null jika perlu
            // $data->total = $cleanedTotal;
            $data->ppn = $request->ppn;
            $data->total_ppn = $cleanedTotalPPn;
            $data->grand_total = $cleanedGrandTotal;
            $data->bill = $cleanedBill;
            $data->category = $request->category;
            $data->description = $request->description;
            $data->catatan = $request->catatan;
            $data->created_by = $this->user->id;
            $data->pph = $request->pph;
            $data->total_pph = $this->toInt($request->total_pph);
            $data->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            // dd($th->getMessage(),$request->all());
            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }
    public function update(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('invoice.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any invoice !');
        }

        try {
            $cleanedTotal = $this->toInt($request->total);
            $cleanedTotalPPn = $this->toInt($request->total_ppn);
            $cleanedGrandTotal = $this->toInt($request->grand_total);
            if ($request->category == 1) {
                $cleanedBill = $this->toInt($request->bill);
            }
            $id = $request->inv_id;
            $data = Invoice::find($id);
            $data->id_project = $request->id_project;
            $data->id_po = $request->id_po;
            $data->created_date = $request->created_date;
            $data->deadline = $request->deadline_date; 
            $data->ppn = $request->ppn;
            $data->total_ppn = $cleanedTotalPPn;
            $data->grand_total = $cleanedGrandTotal;
            $data->catatan = $request->catatan;
            $data->pph = $request->pph;
            $data->total_pph = $this->toInt($request->total_pph);

            $data->category = $request->category;
            if ($request->category == 1) {
                $data->bill = $cleanedBill;
                $data->description = $request->description;
            }

            $data->save();

            session()->flash('success', 'Data has been edited !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            // dd($th->getMessage(),$request->all());
            session()->flash('failed', 'Data has failed edited !!');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('invoice.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any invoice !');
        }

        try {
            $data = Invoice::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            // dd($th->getMessage(),$request->all());
            session()->flash('failed', 'Data has failed deleted !!');
            return redirect()->back();
        }
    }
    

    public function toInt($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return intval($removedThousandSeparator);
    }


    public function getInvoice(Request $request){
        try {
            $inv = Invoice::where('id',$request->invId)->first();

            return response()->json([
                'msg' => 'berhasil',
                'inv' => $inv,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'inv' => [],
            ]);
        }
    }
    public function getPaymentInvoice(Request $request){
        try {
            $inv = InvoicePayment::where('id_inv',$request->invId)->get();

            return response()->json([
                'msg' => 'berhasil',
                'inv' => $inv,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'inv' => [],
            ]);
        }
    }

    public function pdf($id)
    {
        $data['page_title'] = 'Print Invoice';
        $data['inv'] = Invoice::find($id);
        return view('backend.pages.transaction.invoice.pdf',$data);
    }


    public function storePayment(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('invoice.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any invoice !');
        }

        try {
            $cleanedTotal = $this->toInt($request->total);

            $inv = Invoice::where('id',$request->id_inv)->first();
            $proj = Project::where('id',$inv->id_project)->first();
            $cust = Admin::where('id',$proj->id_customer)->first();

            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastpeyment = InvoicePayment::where('id_inv',$request->id_inv)->orderBy('id', 'desc')->where('deleted_at',null)->first();
            if ($lastpeyment) {
                $parts = explode('-', $lastpeyment->no_payment);
                $lastpeymentNumber = intval($parts[2]); // Mengambil bagian nomor dan mengonversi ke integer
                $newpeymentNumber = $lastpeymentNumber + 1;
            } else {
                $newpeymentNumber = 1;
            }
            $newpeymentNumberFormatted = 'PY-'. $cust->kode .'-'. str_pad($newpeymentNumber, 3, '0', STR_PAD_LEFT);

            $data = new InvoicePayment();
            $data->id_inv = $request->id_inv;
            $data->no_payment = $newpeymentNumberFormatted;
            $data->id_transaksi = $request->id_transaksi;
            $data->payment_date = $request->payment_date;
            if ($request->hasFile('receipt')) {
                $image = $request->file('receipt');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/receipt/');
                $image->move($destinationPath, $name);
                $data->receipt = $name;
            }
            $data->total = $cleanedTotal;
            $data->created_by = $this->user->id;
            $data->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }

    

    public function updatePayment(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('invoice.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any invoice !');
        }

        try {
            $cleanedTotal = $this->toInt($request->total);

            $data = InvoicePayment::find($request->id_payment);
            $data->id_transaksi = $request->id_transaksi;
            $data->payment_date = $request->payment_date;
            if ($request->hasFile('receipt')) {
                $image = $request->file('receipt');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/receipt/');
                $image->move($destinationPath, $name);
                $data->receipt = $name;
            }
            $data->total = $cleanedTotal;
            $data->save();

            session()->flash('success', 'Data has been updated !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed updated !!');
            return redirect()->back();
        }
    }

    public function destroyPayment($id)
    {
        if (is_null($this->user) || !$this->user->can('invoice.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any invoice !');
        }

        try {
            $data = InvoicePayment::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            // dd($th->getMessage(),$request->all());
            session()->flash('failed', 'Data has failed deleted !!');
            return redirect()->back();
        }
    }

    

    public function listPaymentInvoice(Request $request){
        try {
            $inv = InvoicePayment::where('id_inv',$request->invId)->where('deleted_at',null)->get();
            $getPaymentInfo = getPaymentInvoice($request->invId);

            $arr_pay = []; 
            foreach ($inv as $key => $in) {
                $dt['id'] = $in->id;
                $dt['no_payment'] = $in->no_payment;
                $dt['total'] = number_format($in->total);
                $dt['created_pay'] = $in->payment_date;
                $createdby = Admin::where('id',$in->created_by)->first();
                $dt['created_by'] = $createdby->name;
                $dt['created_date'] = $in->created_at;
                array_push($arr_pay,$dt);
            }

            return response()->json([
                'msg' => 'berhasil',
                'inv' => $arr_pay,
                'payment_info' => $getPaymentInfo,
                'total' => count($inv)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'error'=>$th->getMessage(),
                'inv' => [],
                'total' => 0
            ]);
        }
    } 
    public function PaymentInvoiceById(Request $request){
        try {
            $inv = InvoicePayment::find($request->invId);

            return response()->json([
                'msg' => 'berhasil',
                'inv' => $inv,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'error'=>$th->getMessage(),
                'inv' => [],
            ]);
        }
    } 





}
