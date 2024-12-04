<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\customer;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
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
        if (is_null($this->user) || !$this->user->can('customer.view')) {
            abort(403, 'Sorry! You are Unauthorized to view any customer !');
        }

        $data['page_title'] = 'Customer';
        $data['title_btn_create'] = 'Add Customer';
        $dateRange = $request->input('date');
        $state = $request->input('state');
        $city = $request->input('city');
        $status = $request->input('status');

        if (is_null($dateRange)) {
            // Jika date null, set default tanggal dari awal bulan sampai akhir bulan ini
            $start_date = null;
            $end_date = null;
        } else {
            // Pisahkan date range menjadi start_date dan end_date
            list($start_date, $end_date) = explode(' - ', $dateRange);
    
            // Ubah format tanggal dari m/d/Y menjadi Y-m-d
            $start_date = Carbon::createFromFormat('m/d/Y', trim($start_date))->format('Y-m-d').' 00:00:00';
            $end_date = Carbon::createFromFormat('m/d/Y', trim($end_date))->format('Y-m-d').' 23:59:59';
        }

        $data['customers'] = Admin::where('deleted_at',null)->where('type','customer')->orderBy('created_at','desc')->where(function($query) use ($state,$city, $status, $start_date, $end_date) {
            if ($state != null) {
                $query->where('id_state', $state);
            }
            if ($city != null) {
                $query->where('id_city', $city);
            }

            if ($status != null) {
                $query->where('status', $status);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })->get();
        $data['customers_new'] = Admin::where('deleted_at',null)->where('type','customer')->whereDate('created_at',date('Y-m-d'))->orderBy('created_at','desc')->get();
        $data['customers_active'] = Admin::where('deleted_at',null)->where('type','customer')->where('status',1)->orderBy('created_at','desc')->where(function($query) use ($state,$city, $status, $start_date, $end_date) {
            if ($state != null) {
                $query->where('id_state', $state);
            }
            if ($city != null) {
                $query->where('id_city', $city);
            }

            // if ($status != null) {
            //     $query->where('status', $status);
            // }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })->get();
        $data['customers_inactive'] = Admin::where('deleted_at',null)->where('type','customer')->where('status',2)->orderBy('created_at','desc')->where(function($query) use ($state,$city, $status, $start_date, $end_date) {
            if ($state != null) {
                $query->where('id_state', $state);
            }
            if ($city != null) {
                $query->where('id_city', $city);
            }

            // if ($status != null) {
            //     $query->where('status', $status);
            // }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })->get();
        $data['roles']  = Role::where('deleted_at',null)->where('name','Customer')->first();
        if ($data['roles'] == null) {
            session()->flash('error', 'You must create a role with the name Customer to create a customer!');
            return redirect()->route('admin.roles.index');
        }

        $data['citys'] = City::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $data['states'] = State::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $data['team'] = Admin::whereNull('type')->where('deleted_at',null)->orderBy('created_at','desc')->get();

        return view('backend.pages.master-data.customer.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('customer.create')) {
            abort(403, 'Sorry! You are Unauthorized to create any customer !');
        }
        // dd($request->all());
        try {
            $data = new Admin();
            $data->username = $request->username;
            $data->name = $request->name;
            $data->type = 'customer';
            $data->no_tlp = $request->no_tlp;
            $data->kode = $request->kode;
            $data->pic = $request->pic;
            $data->email = $request->email;
            $data->status = $request->status;
            $data->id_state = $request->id_state;
            $data->id_city = $request->id_city;
            $data->address = $request->address;
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/customer/');
                $image->move($destinationPath, $name);
                $data->foto = $name;
            }
            $data->password = Hash::make($request->password);


            // marketing 
            $data->marketing_ho = $request->marketing_ho;
            $data->marketing_branch = $request->marketing_branch;
            $data->marketing_pic_branch = $request->marketing_pic_branch;
            $data->marketing_perwakilan = $request->marketing_perwakilan;
            $data->marketer = $request->marketer ?? null;
            $data->pin_marketing = $request->pin_marketing;

            $data->save();

            $data->assignRole('Customer');

            session()->flash('success', 'Data has been created!');
            return redirect()->back();

        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            // session()->flash('error', 'Data has failed created!');
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('customer.edit')) {
            abort(403, 'Sorry! You are Unauthorized to edit any customer !');
        }

        try {
            $data = Admin::find($id);
            $data->username = $request->username;
            $data->name = $request->name;
            $data->type = 'customer';
            $data->no_tlp = $request->no_tlp;
            $data->kode = $request->kode;
            $data->pic = $request->pic;
            $data->email = $request->email;
            $data->status = $request->status;
            $data->id_state = $request->id_state;
            $data->id_city = $request->id_city;
            $data->address = $request->address;
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/customer/');
                $image->move($destinationPath, $name);
                $data->foto = $name;
            }
            if ($request->password != null) {
                $data->password = Hash::make($request->password);
            }

            // marketing 
            $data->marketing_ho = $request->marketing_ho;
            $data->marketing_branch = $request->marketing_branch;
            $data->marketing_pic_branch = $request->marketing_pic_branch;
            $data->marketing_perwakilan = $request->marketing_perwakilan;
            $data->marketer = $request->marketer ?? null;
            $data->pin_marketing = $request->pin_marketing;
            
            $data->save();
            $data->assignRole('Customer');

            session()->flash('success', 'Data has been edited!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('customer.delete')) {
            abort(403, 'Sorry! You are Unauthorized to delete any customer !');
        }

        try {
            $data = Admin::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }
}
