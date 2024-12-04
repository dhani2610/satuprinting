<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
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
        if (is_null($this->user) || !$this->user->can('quotation.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any divisi !');
        }

        $data['page_title'] = 'Quotation';
        $data['title_btn_create'] = 'Add Quotation';

        $data['customer'] = Admin::where('type','customer')->orderBy('name','asc')->get();
        $data['services'] = Services::orderBy('created_at','desc')->get();
        $data['quotation'] = Quotation::where('deleted_at',null)->orderBy('created_at','desc')->get();

        $customer = $request->input('customer');
        $team = $request->input('team');
        $status = $request->input('status');

        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;
        $id_divisi = $this->user->id_divisi;
        
        $data['quotation'] = DB::table('quotations')
        ->join('admins', 'admins.id', '=', 'quotations.created_by')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('quotations.*','admins.name as name_user','divisis.divisi as divisi')->whereNull('quotations.deleted_at')->orderBy('quotations.date','desc')->where(function($query) use ($status,$id_user,$userRole,$team,$customer) {

            if ($customer != null) {
                $query->where('quotations.customer_id', $customer);
            }
            if ($status != null) {
                $query->where('quotations.status', $status);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                if ($team != null) {
                    $query->where('quotations.created_by', $team);
                }else{
                    $query->where('quotations.created_by', $id_user);
                }
            }

        })->get();
        // dd($data['quotation']);
        $data['quotationDetailCount'] = QuotationDetail::whereIn('id_quo',$data['quotation']->pluck('id'))->get()->count();
        $data['quotationAmount'] = $data['quotation']->sum('total');
        $data['customerCount'] = $data['quotation']->pluck('customer_id')->unique()->count();

        $data['teams'] = Admin::where('type',null)->whereNull('deleted_at')->where(function($query) use ($id_user,$userRole) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id', $id_user);
            }

        })->get();

        $data['teamCust'] = Admin::whereNull('type')->where('deleted_at',null)->orderBy('created_at','desc')->get();


        return view('backend.pages.transaction.quotation.index', $data);
    }

    public function getCustomerDetails(Request $request)
    {
        $customer = Admin::where('type','customer')->where('id',$request->customer_id)->first();
        return response()->json($customer);
    }

    public function getNoQuo(){
            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastquo = Quotation::orderBy('id', 'desc')->first();
            if ($lastquo) {
                $parts = explode('/', $lastquo->no_quo);
                $lastquoNumber = intval($parts[0]); // Mengambil bagian nomor dan mengonversi ke integer
                $newquoNumber = $lastquoNumber + 1;
            } else {
                $newquoNumber = 1;
            }

            $romanMonths = [
                1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
                7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
            ];
    
            $currentMonth = date('n'); // Mendapatkan bulan saat ini dalam bentuk angka
            $romanMonth = $romanMonths[$currentMonth]; // Mengambil bulan dalam angka Romawi

            $newquoNumberFormatted = str_pad($newquoNumber, 3, '0', STR_PAD_LEFT).'/SMPY/PH/'.$romanMonth.'/'.date('Y');
            // dd($newActivityNumberFormatted);

            return $newquoNumberFormatted;
    }
    public function store(Request $request)
    {
        try {
            // dd($request->all(),$this->getNoQuo());

            $services = $request->services;
            $prices = $request->prices;
            $qty = $request->qty;
            $total_prices = $request->total_prices;
            if (empty($services)) {
                session()->flash('failed', 'Item Quotation required.');
                return redirect()->back();
            }


            $new = new Quotation();
            $new->customer_id = $request->customer_id;
            $new->no_quo = $this->getNoQuo();
            $new->date = $request->date;
            $new->catatan = $request->catatan;
            $new->type = $request->type;
            $new->created_by = Auth::guard('admin')->user()->id;
            $new->total = $this->toInt($request->total);
             // upload document 
             $dokumenval = $request->lampiran;
             if ($dokumenval != null) {
                $documentPath = public_path('documents/quo/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $new->lampiran = $documentName;
             }

            
            if ($new->save()) {
                foreach ($services as $key => $item) {
                    $newDetailQuo = new QuotationDetail();
                    $newDetailQuo->id_quo = $new->id;
                    $newDetailQuo->id_item = $item;
                    $newDetailQuo->price = $this->toInt($prices[$key]);
                    $newDetailQuo->qty = $this->toInt($qty[$key]);
                    $newDetailQuo->total_prices = $this->toInt($total_prices[$key]);
                    $newDetailQuo->save();
                }

            }

            session()->flash('success', 'Data has been created.');
            return redirect()->back();
        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed created.');
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

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $services = $request->services;
            $prices = $request->prices;
            $qty = $request->qty;
            $total_prices = $request->total_prices;
            if (empty($services)) {
                session()->flash('failed', 'Item Quotation required.');
                return redirect()->back();
            }


            $data = Quotation::find($id);
            $data->customer_id = $request->customer_id;
            $data->date = $request->date;
            $data->catatan = $request->catatan;
            $data->type = $request->type;
            $data->status = $request->status;
            if ($request->catatan_cancel != null) {
                $data->catatan_cancel = $request->catatan_cancel;
            }
            $data->total = $this->toInt($request->total);
             // upload document 
             $dokumenval = $request->lampiran;


             if ($dokumenval != null) {
                $documentPath = public_path('documents/quo/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $data->lampiran = $documentName;
             }

            
            if ($data->save()) {
                $detail = QuotationDetail::where('id_quo',$data->id)->get();
                // HAPUS DATA 
                foreach ($detail as $key => $d) {
                    $delete = QuotationDetail::where('id',$d->id)->first();
                    $delete->delete();
                }

                // INSERT BARU 
                foreach ($services as $key => $item) {
                    $dataDetailQuo = new QuotationDetail();
                    $dataDetailQuo->id_quo = $data->id;
                    $dataDetailQuo->id_item = $item;
                    $dataDetailQuo->price = $this->toInt($prices[$key]);
                    $dataDetailQuo->qty = $this->toInt($qty[$key]);
                    $dataDetailQuo->total_prices = $this->toInt($total_prices[$key]);
                    $dataDetailQuo->save();
                }

            }

            session()->flash('success', 'Data has been updated.');
            return redirect()->back();
        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed updated.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Quotation::find($id);
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
