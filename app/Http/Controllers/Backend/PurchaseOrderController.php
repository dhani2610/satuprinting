<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
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
        if (is_null($this->user) || !$this->user->can('purchase.order.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any purchase order !');
        }

        $data['page_title'] = 'Purchase Order';
        $data['title_btn_create'] = 'Add Purchase Order';
        $data['customer'] = Admin::where('type','customer')->orderBy('name','asc')->get();
        $data['services'] = Services::orderBy('created_at','desc')->get();
        $data['purchaseOrder'] = PurchaseOrder::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $data['quotation'] = Quotation::where('deleted_at',null)->orderBy('created_at','desc')->get();

        $customer = $request->input('customer');
        $team = $request->input('team');
        $status = $request->input('status');

        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;
        $id_divisi = $this->user->id_divisi;

        $dateRange = $request->input('date');

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
        
        $data['purchase_order'] = DB::table('purchase_orders')
        ->join('admins', 'admins.id', '=', 'purchase_orders.created_by')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('purchase_orders.*','admins.name as name_user','divisis.divisi as divisi')->whereNull('purchase_orders.deleted_at')->orderBy('purchase_orders.date','desc')->where(function($query) use ($status,$id_user,$userRole,$team,$customer,$start_date, $end_date) {

            if ($customer != null) {
                $query->where('purchase_orders.customer_id', $customer);
            }
            if ($status != null) {
                $query->where('purchase_orders.status', $status);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                if ($team != null) {
                    $query->where('purchase_orders.created_by', $team);
                }else{
                    $query->where('purchase_orders.created_by', $id_user);
                }
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('purchase_orders.date', [$start_date, $end_date]);
            }

        })->get();

        $data['purchaseOrderQuotation'] = $data['purchase_order']->pluck('id_quo')->unique()->count();
        $data['purchaseOrderAmount'] = $data['purchase_order']->sum('grand_total');
        $data['customerCount'] = $data['purchase_order']->pluck('customer_id')->unique()->count();
        // $data['customerCount'] = Admin::whereIn('id',$data['purchaseOrder']->pluck('customer_id'))->where('type','customer')->orderBy('name','asc')->get()->count();

        $data['teams'] = Admin::where('type',null)->whereNull('deleted_at')->where(function($query) use ($id_user,$userRole) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id', $id_user);
            }

        })->get();

        $data['teamCust'] = Admin::whereNull('type')->where('deleted_at',null)->orderBy('created_at','desc')->get();

        
        return view('backend.pages.transaction.po.index', $data);
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

    public function store(Request $request)
    {
        // dd($request->all());

        try {
            $services = $request->services;
            $prices = $request->prices;
            $qty = $request->qty;
            $total_prices = $request->total_prices;
            if (empty($services)) {
                session()->flash('failed', 'Item Purchase Order required.');
                return redirect()->back();
            }


            $new = new PurchaseOrder();
            $new->customer_id = $request->customer_id;
            $new->id_quo = $request->id_quo;
            $new->no_po = $request->no_po;
            $new->deadline = $request->deadline;
            $new->date = $request->date;
            $new->catatan = $request->catatan;
            $new->created_by = Auth::guard('admin')->user()->id;
            $new->total = $this->toInt($request->total);
            $new->ppn = $request->ppn;
            $new->total_ppn = $this->toInt($request->total_ppn);
            $new->grand_total = $this->toInt($request->grand_total);
            $new->lampiran = $request->lampiran;
            $new->pph = $request->pph;
            $new->total_pph = $this->toInt($request->total_pph);
             // upload document 
             $dokumenval = $request->file_po;


             if ($dokumenval != null) {
                $documentPath = public_path('documents/po/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $new->file_po = $documentName;
             }

            
            if ($new->save()) {
                foreach ($services as $key => $item) {
                    $newDetailPO = new PurchaseOrderDetail();
                    $newDetailPO->id_po = $new->id;
                    $newDetailPO->id_item = $item;
                    $newDetailPO->price = $this->toInt($prices[$key]);
                    $newDetailPO->qty = $this->toInt($qty[$key]);
                    $newDetailPO->total_prices = $this->toInt($total_prices[$key]);
                    $newDetailPO->save();
                }

            }

            session()->flash('success', 'Data has been created.');
            return redirect()->back();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            session()->flash('failed', 'Data has failed created.');
            return redirect()->back();
        }
    }

    public function getQuotation(Request $request){
        try {
            $quotation = Quotation::where('id',$request->quo_id)->first();
            $quotationDetail = QuotationDetail::where('id_quo',$request->quo_id)->get();

            return response()->json([
                'msg' => 'berhasil',
                'quotation' => $quotation,
                'quotationDetail' => $quotationDetail,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'quotation' => [],
                'quotationDetail' => [],
            ]);
        }
    }
    public function getPO(Request $request){
        try {
            $po = PurchaseOrder::where('id',$request->id_po)->first();
            $poDetail = PurchaseOrderDetail::where('id_po',$request->id_po)->get();

            return response()->json([
                'msg' => 'berhasil',
                'po' => $po,
                'poDetail' => $poDetail,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'po' => [],
                'poDetail' => [],
            ]);
        }
    }
    public function getProject(Request $request){
        try {
            $proj = Project::where('id',$request->projId)->first();

            return response()->json([
                'msg' => 'berhasil',
                'proj' => $proj,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'gagal',
                'proj' => [],
            ]);
        }
    }

    public function update(Request $request, $id){
        try {
            $services = $request->services;
            $prices = $request->prices;
            $qty = $request->qty;
            $total_prices = $request->total_prices;
            if (empty($services)) {
                session()->flash('failed', 'Item Purchase Order required.');
                return redirect()->back();
            }


            $data = PurchaseOrder::find($id);
            $data->customer_id = $request->customer_id;
            $data->id_quo = $request->id_quo;
            $data->no_po = $request->no_po;
            $data->date = $request->date;
            $data->catatan = $request->catatan;
            $data->deadline = $request->deadline;
            $data->total = $this->toInt($request->total);
            $data->ppn = $request->ppn;
            $data->total_ppn = $this->toInt($request->total_ppn);
            $data->grand_total = $this->toInt($request->grand_total);
            $data->lampiran = $request->lampiran;
            $data->status = $request->status;
            $data->pph = $request->pph;
            $data->total_pph = $request->total_pph;
            if ($request->catatan_cancel != null) {
                $data->catatan_cancel = $request->catatan_cancel;
            }
             // upload document 
             $dokumenval = $request->file_po;


             if ($dokumenval != null) {
                $documentPath = public_path('documents/po/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $data->file_po = $documentName;
             }

            
            if ($data->save()) {

                $detail = PurchaseOrderDetail::where('id_po',$data->id)->get();
                // HAPUS DATA 
                foreach ($detail as $key => $d) {
                    $delete = PurchaseOrderDetail::where('id',$d->id)->first();
                    $delete->delete();
                }

                // INSERT DATA 
                foreach ($services as $key => $item) {
                    $newDetailPO = new PurchaseOrderDetail();
                    $newDetailPO->id_po = $data->id;
                    $newDetailPO->id_item = $item;
                    $newDetailPO->price = $this->toInt($prices[$key]);
                    $newDetailPO->qty = $this->toInt($qty[$key]);
                    $newDetailPO->total_prices = $this->toInt($total_prices[$key]);
                    $newDetailPO->save();
                }

            }

            session()->flash('success', 'Data has been updated.');
            return redirect()->back();
        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed updated.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $data = PurchaseOrder::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->delete();

            session()->flash('success', 'Data has been deleted.');
            return redirect()->back();
        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed deleted.');
            return redirect()->back();
        }
    }
}
