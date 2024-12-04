<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Divisi;
use App\Models\Project;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
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
        if (is_null($this->user) || !$this->user->can('activity.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any activity !');
        }

        $data['page_title'] = 'Activity';
        $data['title_btn_create'] = 'Add Activity';
        $customer = $request->input('customer');
        $team = $request->input('team');
        $divisi = $request->input('divisi');
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
        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;

        $data['activity'] = DB::table('activities')->
        join('admins', 'admins.id', '=', 'activities.id_user')->
        where('activities.deleted_at',null)->orderBy('activities.created_at', 'desc')->where(function($query) use ($id_user,$userRole,$customer,$team , $start_date, $end_date,$divisi) {
            if ($customer != null) {
                $query->where('activities.id_customer', $customer);
            }

            if ($team != null) {
                $query->where('activities.id_user', $team);
            }
            if ($divisi != null) {
                $query->where('admins.id_divisi', $divisi);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('activities.id_user', $id_user);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('activities.tanggal', [$start_date, $end_date]);
            }
        })->select('activities.*','activities.id as id')->get();
        // dd($data['activity']);
        $data['customer_count'] = DB::table('activities')->
            join('admins', 'admins.id', '=', 'activities.id_user')->where('activities.deleted_at',null)->orderBy('activities.created_at', 'desc')->where(function($query) use ($divisi,$id_user,$userRole,$customer,$team , $start_date, $end_date) {
            if ($customer != null) {
                $query->where('activities.id_customer', $customer);
            }

            if ($team != null) {
                $query->where('activities.id_user', $team);
            }
            if ($divisi != null) {
                $query->where('admins.id_divisi', $divisi);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('activities.id_user', $id_user);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('activities.tanggal', [$start_date, $end_date]);
            }
        })->get()->pluck('id_customer')->unique();

        $data['users'] = DB::table('activities')->
        join('admins', 'admins.id', '=', 'activities.id_user')->where('activities.deleted_at',null)->orderBy('activities.created_at', 'desc')->where(function($query) use ($divisi,$id_user,$userRole,$customer,$team , $start_date, $end_date) {
            if ($customer != null) {
                $query->where('activities.id_customer', $customer);
            }

            if ($team != null) {
                $query->where('activities.id_user', $team);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('activities.id_user', $id_user);
            }

            if ($divisi != null) {
                $query->where('admins.id_divisi', $divisi);
            }
            
            if ($start_date != null && $end_date != null) {
                $query->whereBetween('activities.tanggal', [$start_date, $end_date]);
            }
        })->get()->pluck('id_user')->unique();
        // dd($data['users']);

        $data['divisi_count'] = Admin::whereIn('id', $data['users'])->get()->unique('id_divisi');
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();

        // Filter 
        $data['teams'] = Admin::where('type',null)->get();
        $data['divisi'] = Divisi::get();

        return view('backend.pages.activity.index', $data);
    }
    public function getProjectByCustomer($id)
    {
        $po = PurchaseOrder::where('customer_id', $id)->get()->pluck('id');
        $project = Project::whereIn('id_po', $po)->get();
        return response()->json([
            'data' => $project
        ]);
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('activity.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any activity !');
        }

        try {
            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastActivity = Activity::orderBy('id', 'desc')->first();
            if ($lastActivity) {
                $parts = explode('-', $lastActivity->no_activity);
                $lastActivityNumber = intval($parts[1]); // Mengambil bagian nomor dan mengonversi ke integer
                $newActivityNumber = $lastActivityNumber + 1;
            } else {
                $newActivityNumber = 1;
            }
            $newActivityNumberFormatted = 'ACT-' . str_pad($newActivityNumber, 3, '0', STR_PAD_LEFT);
            // dd($newActivityNumberFormatted);


            $data = new Activity();
            $data->id_user = Auth::guard('admin')->user()->id;
            $data->category = $request->category;
            if ($request->category == 'Internal') {
                $data->activity_category = $request->activity_category;
            }else{
                $data->id_customer = $request->id_customer;
                $data->id_project = $request->id_project;
            }
            $data->note = $request->note;
            $data->tanggal = date('Y-m-d');
            $data->no_activity = $newActivityNumberFormatted; // Menyimpan nomor aktivitas baru
            $data->save();

            session()->flash('success', 'Data has been created.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed created.');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('activity.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any activity !');
        }
        try {
            $data = Activity::find($id);
            $data->note = $request->note;
            $data->category = $request->category;
            if ($request->category == 'Internal') {
                $data->activity_category = $request->activity_category;
            }else{
                $data->id_customer = $request->id_customer;
                $data->id_project = $request->id_project;
            }
            $data->save();
            // dd($data);

            session()->flash('success', 'Data has been edited.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed edited.');
            return redirect()->back();
        }
    }
    public function destroy(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('activity.deleted')) {
            abort(403, 'Sorry !! You are Unauthorized to deleted any activity !');
        }
        try {

            $data = Activity::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed deleted.');
            return redirect()->back();
        }
    }

}
