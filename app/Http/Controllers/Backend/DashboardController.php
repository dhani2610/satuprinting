<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\Event;
use App\Models\GuestEvent;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
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
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $data['page_title'] = 'Dashboard';

        $data['cekAttendance'] = Attendance::where('id_user',Auth::guard('admin')->user()->id)->where('date',date('Y-m-d'))->first();

        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;

        // CARD 
        // Customer
        $filter = $request->filter;
        // dd($filter);
        $data['customer_count'] = Admin::where('deleted_at',null)->where('type','customer')->orderBy('created_at','desc')->where(function($query) use ($request,$filter) {
            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('created_at', date('m'));
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('created_at', date('m'));
                $query->whereYear('created_at', date('Y'));
            }
        })->get()->count();

        // Quotation 
        $data['quotation_count'] = DB::table('quotations')
        ->join('admins', 'admins.id', '=', 'quotations.created_by')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('quotations.*','admins.name as name_user','divisis.divisi as divisi')->whereNull('quotations.deleted_at')->orderBy('quotations.date','desc')->where(function($query) use ($filter,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('quotations.created_by', $id_user);
            }
            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('quotations.date', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('quotations.date', date('m'));
                        $query->whereYear('quotations.date', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('quotations.date', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('quotations.date', date('m'));
                $query->whereYear('quotations.date', date('Y'));
            }
        })->get()->count();

        // PO 
        $data['purchase_order_count'] = DB::table('purchase_orders')
        ->join('admins', 'admins.id', '=', 'purchase_orders.created_by')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('purchase_orders.*','admins.name as name_user','divisis.divisi as divisi')->whereNull('purchase_orders.deleted_at')->orderBy('purchase_orders.date','desc')->where(function($query) use ($filter,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                    $query->where('purchase_orders.created_by', $id_user);
            }
            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('purchase_orders.date', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('purchase_orders.date', date('m'));
                        $query->whereYear('purchase_orders.date', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('purchase_orders.date', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('purchase_orders.date', date('m'));
                $query->whereYear('purchase_orders.date', date('Y'));
            }
        })->get()->count();

        // Project 
        $data['project_count'] = Project::where('deleted_at',null)->orderBy('created_at','desc')->where(function($query) use ($filter,$userRole,$id_user) {
            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('created_at', date('m'));
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('created_at', date('m'));
                $query->whereYear('created_at', date('Y'));
            }
        })->get()->count();

        // INVOICE 
        $data['invoices_count'] = Invoice::where('deleted_at',null)->orderBy('created_at','desc')
        ->where(function($query) use ($filter,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('created_by', $id_user);
            }
            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('created_at', date('m'));
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('created_at', date('m'));
                $query->whereYear('created_at', date('Y'));
            }
        })->get()->count();

        // ADMIN 
        $data['team_count'] = Admin::whereNull('deleted_at')
        ->whereNull('type')
        ->where(function($query) use ($filter,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id', $id_user);
            }

            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('created_at', date('m'));
                        $query->whereYear('created_at', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('created_at', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('created_at', date('m'));
                $query->whereYear('created_at', date('Y'));
            }
        })
        ->get()->count();

        // Attendance 
        $data['late_attendance'] = DB::table('attendances')
        ->join('admins', 'admins.id', '=', 'attendances.id_user')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->where('attendances.status', 2)
        ->select('attendances.*','admins.name as name_user','divisis.divisi as divisi')->orderBy('attendances.created_at','desc')->where(function($query) use ($filter,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('attendances.id_user', $id_user);
            }
            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('attendances.created_at', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('attendances.created_at', date('m'));
                        $query->whereYear('attendances.created_at', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('attendances.created_at', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('attendances.created_at', date('m'));
                $query->whereYear('attendances.created_at', date('Y'));
            }
        })->get()->count();

        // Assignment
        $data['assignment_count'] = Assignment::where('deleted_at',null)->orderBy('created_at', 'desc')->where(function($query) use ($filter,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id_user', $id_user);
            }

            if ($filter != null) {
                if ($filter != 'all') {
                    if ($filter == 'year-now') {
                        $query->whereYear('tanggal', date('Y'));
                    }elseif ($filter == 'this-month') {
                        $query->whereMonth('tanggal', date('m'));
                        $query->whereYear('tanggal', date('Y'));
                    }elseif ($filter == 'today') {
                        $query->whereDate('tanggal', date('Y-m-d'));
                    }
                }
            }else{
                $query->whereMonth('tanggal', date('m'));
                $query->whereYear('tanggal', date('Y'));
            }
        })->get()->count();

        // TABLE ACTIVITY 
        $data['activity'] = DB::table('activities')->
        join('admins', 'admins.id', '=', 'activities.id_user')->
        where('activities.deleted_at',null)->orderBy('activities.created_at', 'desc')->where(function($query) use ($id_user,$userRole) {
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('activities.id_user', $id_user);
            }
        })->limit(3)->get();

        // GET EVENT 
        if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
            $guest = GuestEvent::where('id_user',Auth::guard('admin')->user()->id)->get()->pluck('id_event');
            $data['event'] = Event::whereNull('deleted_at')->whereIn('id',$guest)->orderBy('created_at','desc')->limit(5)->whereDate('start_date',date('Y-m-d'))->get();
        }else{
            $guest = GuestEvent::get()->pluck('id_event');
            $data['event'] = Event::whereNull('deleted_at')->whereIn('id',$guest)->orderBy('created_at','desc')->limit(5)->whereDate('start_date',date('Y-m-d'))->get();
        }

        $data['late_attendance_list'] = DB::table('attendances')
        ->join('admins', 'admins.id', '=', 'attendances.id_user')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->where('attendances.status', 2)
        ->select('attendances.*','admins.name as name_user','divisis.divisi as divisi')->orderBy('attendances.created_at','desc')->where(function($query) use ($request,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('attendances.id_user', $id_user);
            }
        })->limit(5)->get();

        // Assignment
        $data['assignment_list'] = DB::table('assignments')
        ->join('admins', 'admins.id', '=', 'assignments.id_user')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('assignments.*','admins.name as name_user','divisis.divisi as divisi')->orderBy('assignments.created_at','desc')->where(function($query) use ($request,$userRole,$id_user) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('assignments.id_user', $id_user);
            }
        })->limit(5)->get();
        // dd(getIdProjectByStatus('On Progres'));

        $getProjectUser = TeamProject::where('id_team',Auth::guard('admin')->user()->id)->get()->pluck('id_project');
        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;
        $data['project_list'] = Project::whereIn('id',getIdProjectByStatus('On Progres'))->where('deleted_at',null)->orderBy('created_at','desc')->where(function($query) use ($getProjectUser,$userRole) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->whereIn('id', $getProjectUser);
            }
        })->limit(2)->get();


        $tahunReq = $request->tahun;

        if ($tahunReq != null) {
           $tahun = $tahunReq;
        }else{
            $tahun = date('Y');
        }

        $data['pendapatan'] = Invoice::whereYear('created_date',$tahun)->where('deleted_at',null)->get()->sum('grand_total');

        $data['charts_pendapatan'] = [];
        $bulan = range(1,12);
        foreach ($bulan as $key => $value) {
            $cekPendapatan = Invoice::whereYear('created_date',$tahun)->whereMonth('created_date',$value)->where('deleted_at',null)->get()->sum('grand_total');
            array_push($data['charts_pendapatan'], $cekPendapatan);
        }

        $data['tahun'] = $tahun;

        return view('backend.pages.dashboard.index', $data);
    }


    public function client(){
        if (is_null($this->user) || !$this->user->can('client.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any client !');
        }

        $data['page_title'] = 'Client';
        $data['project'] = Project::where('deleted_at',null)->where('id_customer',$this->user->id)->orderBy('created_at','desc')->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['purchaseOrder'] = PurchaseOrder::orderBy('created_at','desc')->get();
      
        $data['quotation_count'] = Quotation::where('customer_id',$this->user->id)->where('deleted_at',null)->get()->count();
        $data['po_count'] = PurchaseOrder::where('customer_id',$this->user->id)->where('deleted_at',null)->get()->count();
        $data['proj_count'] = Project::where('id_customer',$this->user->id)->where('deleted_at',null)->get()->count();
        $cust_in_po = PurchaseOrder::where('customer_id',$this->user->id)->where('deleted_at',null)->get()->pluck('id');
        $data['invoice_count'] = Invoice::whereIn('id_po',$cust_in_po)->where('deleted_at',null)->get()->count();

        return view('backend.client.index', $data);
    }

    public function tracking($no_proj){
        $data['page_title'] = 'Tracking';
        $data['proj'] = Project::where('no_project',$no_proj)->first();

        $data['activity'] = ProjectActivity::where('id_project', $data['proj']->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.client.tracking', $data);
    }
}
