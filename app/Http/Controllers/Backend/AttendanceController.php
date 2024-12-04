<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Attendance;
use App\Models\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AttendanceController extends Controller
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
        if (is_null($this->user) || !$this->user->can('attendance.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data['page_title'] = 'Attendance';

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
        $id_divisi = $this->user->id_divisi;

        $data['attendance'] = DB::table('attendances')
        ->join('admins', 'admins.id', '=', 'attendances.id_user')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('attendances.*','admins.name as name_user','divisis.divisi as divisi')->orderBy('attendances.created_at','desc')->where(function($query) use ($divisi,$id_user,$userRole,$team , $start_date, $end_date) {

            if ($team != null) {
                $query->where('attendances.id_user', $team);
            }
            
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('attendances.id_user', $id_user);
            }

            if ($divisi != null) {
                $query->where('admins.id_divisi', $divisi);
            }
            
            if ($start_date != null && $end_date != null) {
                $query->whereBetween('attendances.date', [$start_date, $end_date]);
            }
        })->get();
        $data['divisi_count'] = $data['attendance']->pluck('divisi')->unique();
        $data['team_count'] = $data['attendance']->pluck('id_user')->unique();
        $data['late_count'] = $data['attendance']->where('status',2)->count();
        

        // FILTER 
        $data['divisi'] = Divisi::where(function($query) use ($id_user,$userRole,$id_divisi) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id', $id_divisi);
            }

        })->get();
        $data['teams'] = Admin::where('type',null)->whereNull('deleted_at')->where(function($query) use ($id_user,$userRole) {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->where('id', $id_user);
            }

        })->get();
        // dd($data);

        return view('backend.pages.attendance.index', $data);
    }

    public function getJamMasuk(){
        return '08:00:00';
    }
    public function getNoAttend(){
         // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
         $lastattend = Attendance::whereMonth('date',date('m'))->whereYear('date',date('Y'))->orderBy('id', 'desc')->first();
         if ($lastattend) {
             $parts = explode('-', $lastattend->no_attend);
             $lastattendNumber = intval($parts[3]); // Mengambil bagian nomor dan mengonversi ke integer
             $newattendNumber = $lastattendNumber + 1;
         } else {
             $newattendNumber = 1;
         }
         $newattendNumberFormatted = 'ATD-' . date('Y-m').'-' .str_pad($newattendNumber, 3, '0', STR_PAD_LEFT);
         // dd($newActivityNumberFormatted);

         return $newattendNumberFormatted;
    }

    public function store(Request $request)
    {

        $type = $request->input('type');
        $base64data = $request->input('image');
        // Menghapus header data base64
        $base64data = preg_replace('#^data:image/\w+;base64,#i', '', $base64data);

        // Decode base64 menjadi binary data
        $image = base64_decode($base64data);

        // Pastikan decoding berhasil
        if ($image === false) {
            return redirect()->back()->with('error', 'Failed to decode base64 image.');
        }
        // dd($request->all(),$image);


        $imageName = $type.'-'.Auth::guard('admin')->user()->id.'-'.time() . '.jpg'; // Nama file bisa disesuaikan dengan kebutuhan
        $destinationPath = public_path('assets/img/absensi/');
        file_put_contents($destinationPath . $imageName, $image);

        $cekAttendance = Attendance::where('id_user',Auth::guard('admin')->user()->id)->where('date',date('Y-m-d'))->first();
        if ($cekAttendance != null) {
            $attendance = Attendance::find($cekAttendance->id);
            $attendance->foto_out = $imageName; // Simpan nama file foto ke dalam kolom 'foto' di tabel Attendance
            $attendance->time_out = date('H:i:s');
        }else{
            $attendance = new Attendance();
            $attendance->no_attend = $this->getNoAttend();
            $attendance->id_user = Auth::guard('admin')->user()->id;
            $attendance->date = date('Y-m-d');
            $attendance->foto_in = $imageName; // Simpan nama file foto ke dalam kolom 'foto' di tabel Attendance
            $attendance->time_in = date('H:i:s');
            $attendance->status = date('H:i:s') > $this->getJamMasuk() ? 2 : 1; 
        }
        $attendance->note = !empty($request->note) ? $request->note : null; 
        $attendance->save();
        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    public function rekapByUser($id){
        if (is_null($this->user) || !$this->user->can('attendance.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data['page_title'] = 'Attendance Rekap';
        $data['attendance'] = Attendance::where('id_user',$id)->get();

        return view('backend.pages.attendance.rekapByUser', $data);
    }
}
