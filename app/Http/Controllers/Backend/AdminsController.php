<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('team.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data['page_title'] = 'Team';
        $data['title_btn_create'] = 'Add New User';
        $dateRange = $request->input('date');
        $status = $request->input('status');
        $divisi = $request->input('divisi');

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
    
        // Query dengan kondisi where menggunakan query builder
        $data['admins'] = Admin::whereNull('deleted_at')
        ->whereNull('type')
        ->where(function($query) use ($divisi, $status, $start_date, $end_date) {
            if ($divisi != null) {
                $query->where('id_divisi', $divisi);
            }

            if ($status != null) {
                $query->where('status', $status);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })
        ->get();
        // dd($start_date,$end_date,$data['admins']);



        $data['division'] = Admin::where('deleted_at',null)->where('id_divisi','!=',null)->where(function($query) use ($divisi, $status, $start_date, $end_date) {
            if ($divisi != null) {
                $query->where('id_divisi', $divisi);
            }

            if ($status != null) {
                $query->where('status', $status);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })
        ->get()->pluck('id_divisi')->unique();
        $data['active_user'] = Admin::where('deleted_at',null)->where('type',null)->where('status',1)->where(function($query) use ($divisi, $status, $start_date, $end_date) {
            if ($divisi != null) {
                $query->where('id_divisi', $divisi);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })
        ->get();
        $data['inactive_user'] = Admin::where('deleted_at',null)->where('type',null)->where('status',2)->where(function($query) use ($divisi, $status, $start_date, $end_date) {
            if ($divisi != null) {
                $query->where('id_divisi', $divisi);
            }

            if ($start_date != null && $end_date != null) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        })
        ->get();
        $data['divisi'] = Divisi::where('deleted_at',null)->get();
        $data['roles']  = Role::where('deleted_at',null)->get();
        return view('backend.pages.admins.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $roles  = Role::all();
        return view('backend.pages.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRoleName($id){
        $divisi = Divisi::find($id);
        $role = Role::find($divisi->id_role);
        return $role->name;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if (is_null($this->user) || !$this->user->can('team.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        // Create New Admin
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->whatsapp = $request->whatsapp;
        $admin->id_divisi = $request->id_divisi;
        $admin->status = $request->status;
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/team/');
            $image->move($destinationPath, $name);
            $admin->foto = $name;
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        if ($request->id_divisi) {
            $role = $this->getRoleName($request->id_divisi);
            $admin->assignRole($role);
        }

        session()->flash('success', 'Team has been created !!');
        return redirect()->route('admin.admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if (is_null($this->user) || !$this->user->can('team.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        $admin = Admin::find($id);
        $roles  = Role::all();
        return view('backend.pages.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (is_null($this->user) || !$this->user->can('team.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        // if ($id === 1) {
        //     session()->flash('error', 'Sorry !! You are not authorized to update this Admin as this is the Super Admin. Please create new one if you need to test !');
        //     return back();
        // }

        // Create New Admin
        $admin = Admin::find($id);

        // // Validation Data
        // $request->validate([
        //     'name' => 'required|max:50',
        //     'email' => 'required|max:100|email|unique:admins,email,' . $id,
        //     'password' => 'nullable|min:6|confirmed',
        // ]);


        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->whatsapp = $request->whatsapp;
        $admin->id_divisi = $request->id_divisi;
        $admin->status = $request->status;
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/team/');
            $image->move($destinationPath, $name);
            $admin->foto = $name;
        }
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        $admin->roles()->detach();
        if ($request->id_divisi) {
            $role = $this->getRoleName($request->id_divisi);
            $admin->assignRole($role);
        }

        session()->flash('success', 'Team has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (is_null($this->user) || !$this->user->can('admin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any admin !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 1) {
            session()->flash('error', 'Sorry !! You are not authorized to delete this Admin as this is the Super Admin. Please create new one if you need to test !');
            return back();
        }

        $admin = Admin::find($id);
        if (!is_null($admin)) {
            $admin->deleted_at = date('Y-m-d H:i:s');
            $admin->save();
        }

        session()->flash('success', 'Team has been deleted !!');
        return back();
    }
}
