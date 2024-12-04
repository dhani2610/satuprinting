<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {

        if (is_null($this->user) || !$this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any profile !');
        }

        $data['page_title'] = 'My Profile';
        $data['user'] = Admin::find($this->user->id);

        $id_user = $this->user->id;
        $data['attendance'] = DB::table('attendances')
        ->join('admins', 'admins.id', '=', 'attendances.id_user')
        ->join('divisis', 'divisis.id', '=', 'admins.id_divisi')
        ->select('attendances.*','admins.name as name_user','divisis.divisi as divisi')->orderBy('attendances.created_at','desc')->where(function($query) use ($id_user) {
            $query->where('attendances.id_user', $id_user);
        })->get();

        return view('backend.pages.profile.index', $data);
    }
    public function assignment()
    {

        if (is_null($this->user) || !$this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any profile !');
        }

        $data['page_title'] = 'My Profile';
        $data['user'] = Admin::find($this->user->id);

        $id_user = $this->user->id;
        $data['assignment'] = Assignment::where('deleted_at', null)->orderBy('created_at', 'desc')->where(function ($query) use ($id_user) {
            $query->where('id_user', $id_user);
        })->get();

        return view('backend.pages.profile.assignment', $data);
    }
    public function changePassword()
    {

        if (is_null($this->user) || !$this->user->can('profile.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any profile !');
        }

        $data['page_title'] = 'My Profile';
        $data['user'] = Admin::find($this->user->id);

        return view('backend.pages.profile.change-password', $data);
    }

    public function changePasswordProses(Request $request)
    {
        // Validate the request
        $request->validate([
            'newPassword' => 'required|string|min:8|regex:/[A-Z]/|regex:/[@$!%*?&]/',
            'confirmPassword' => 'required|string|same:newPassword',
        ]);

        // Check if the user has the right to view profiles
        if (is_null($this->user) || !$this->user->can('profile.view')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Update the user's password
            $user = $this->user;
            $user->password = bcrypt($request->input('newPassword'));
            $user->save();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Failed to update password.']);
        }
    }
}
