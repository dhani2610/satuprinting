<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Assignment;
use App\Models\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
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
        if (is_null($this->user) || !$this->user->can('assignment.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data['page_title'] = 'Assignment';
        $data['title_btn_create'] = 'Add Assignment';
        // Auth::guard('admin')->user()->getRoleNames()[0]

        $dateRange = $request->input('date');
        $customer = $request->input('customer');
        $team = $request->input('team');
        $status = $request->input('status');

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
        // dd($userRole);

        // dd($request->all(),$start_date,$end_date);
        $data['assignment'] = Assignment::where('deleted_at',null)->orderBy('created_at', 'desc')->where(function($query) use ($id_user,$userRole,$customer,$team ,$status, $start_date, $end_date) {
            if ($customer != null) {
                $query->where('id_customer', $customer);
            }

            if ($team != null) {
                $query->where('id_user', $team);
            }
            if ($status != null) {
                $query->where('status', $status);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id_user', $id_user);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('tanggal', [$start_date, $end_date]);
            }
        })->get();
        $data['customer_count'] = Assignment::where('deleted_at',null)->orderBy('created_at', 'desc')->where(function($query) use ($id_user,$userRole,$customer,$team ,$status, $start_date, $end_date) {
            if ($customer != null) {
                $query->where('id_customer', $customer);
            }

            if ($team != null) {
                $query->where('id_user', $team);
            }
            if ($status != null) {
                $query->where('status', $status);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id_user', $id_user);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('tanggal', [$start_date, $end_date]);
            }
        })->get()->pluck('id_customer')->unique();
        $data['users'] = Assignment::where('deleted_at',null)->orderBy('created_at', 'desc')->where(function($query) use ($id_user,$userRole,$customer,$team ,$status, $start_date, $end_date) {
            if ($customer != null) {
                $query->where('id_customer', $customer);
            }

            if ($team != null) {
                $query->where('id_user', $team);
            }
            if ($status != null) {
                $query->where('status', $status);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id_user', $id_user);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('tanggal', [$start_date, $end_date]);
            }
        })->get()->pluck('id_user')->unique();
        $data['divisi_count'] = Admin::whereIn('id', $data['users'])->get()->unique('id_divisi');
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['assignment_waiting'] = Assignment::where('deleted_at',null)->where('status',1)->orderBy('created_at', 'desc')->where(function($query) use ($id_user,$userRole,$customer,$team ,$status, $start_date, $end_date) {
            if ($customer != null) {
                $query->where('id_customer', $customer);
            }

            if ($team != null) {
                $query->where('id_user', $team);
            }
            if ($status != null) {
                $query->where('status', $status);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id_user', $id_user);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('tanggal', [$start_date, $end_date]);
            }
        })->get();

        $data['teams'] = Admin::where('type',null)->get();
        $data['divisi'] = Divisi::get();

        return view('backend.pages.assignment.index', $data);
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('assignment.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any assignment !');
        }

        try {
            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastAssignment = Assignment::orderBy('id', 'desc')->first();
            if ($lastAssignment) {
                $parts = explode('-', $lastAssignment->no_assignment);
                $lastAssignmentNumber = intval($parts[1]); // Mengambil bagian nomor dan mengonversi ke integer
                $newAssignmentNumber = $lastAssignmentNumber + 1;
            } else {
                $newAssignmentNumber = 1;
            }
            $newAssignmentNumberFormatted = 'ASS-' . str_pad($newAssignmentNumber, 3, '0', STR_PAD_LEFT);

            $data = new Assignment();
            $data->id_user = Auth::guard('admin')->user()->id;
            $data->category = $request->category;
            if ($request->category == 'Internal') {
                $data->activity_category = $request->activity_category;
            }else{
                $data->id_customer = $request->id_customer;
                $data->id_project = $request->id_project;
            }
            $data->tujuan = $request->tujuan;
            $data->time_start = $request->time_start;
            $data->time_end = $request->time_end;
            $data->note = $request->note;
            // $data->status = $request->status;
            $data->tanggal = $request->date;
            $data->no_assignment = $newAssignmentNumberFormatted; // Menyimpan nomor assignment baru
            $data->save();

            session()->flash('success', 'Data has been created.');
            return redirect()->back();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            session()->flash('failed', 'Data has failed created.');
            return redirect()->back();
        }
    }

    public function update(Request $request,$id)
    {
        if (is_null($this->user) || !$this->user->can('assignment.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any assignment !');
        }

        try {
            $data = Assignment::find($id);
            $data->tujuan = $request->tujuan;
            $data->time_start = $request->time_start;
            $data->time_end = $request->time_end;
            $data->category = $request->category;
            if ($request->category == 'Internal') {
                $data->activity_category = $request->activity_category;
            }else{
                $data->id_customer = $request->id_customer;
                $data->id_project = $request->id_project;
            }
            $data->note = $request->note;
            $data->tanggal = $request->date;
            $data->status = $request->status;
            $data->save();

            session()->flash('success', 'Data has been updated.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed updated.');
            return redirect()->back();
        }
    }
    public function destroy(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('assignment.deleted')) {
            abort(403, 'Sorry !! You are Unauthorized to deleted any assignment !');
        }
        try {

            $data = Assignment::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed deleted.');
            return redirect()->back();
        }
    }

    public function print(Request $request,$id)
    {
        $data['page_title'] = 'Print Assignment';
        $data['asg'] = Assignment::find($id);
        return view('backend.pages.assignment.print', $data);
    }
}
