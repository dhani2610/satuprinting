<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    /**
     * show login form for admin guard
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }


    /**
     * login admin
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        // Validate Login Data
        // dd($request->all());
        $request->validate([
            'email' => 'required|max:50',
            'password' => 'required',
        ]);

        // Attempt to login
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Redirect to dashboard
            session()->flash('success', 'Successully Logged in !');
            if (Auth::guard('admin')->user()->status == 2) {
                Auth::guard('admin')->logout();
                session()->flash('error', 'Your account is inactive.');
                return redirect()->route('admin.login');
            }
            if (Auth::guard('admin')->user()->roles[0]->name == 'Customer') {
                return redirect()->route('client');
            }else{
                return redirect()->route('admin.dashboard');
            }
        } else {
            // Search using username
            // dd(Auth::guard('admin')->user()->roles[0]->name);

            if (Auth::guard('admin')->attempt(['username' => $request->email, 'password' => $request->password], $request->remember)) {

                if (Auth::guard('admin')->user()->status == 2) {
                    Auth::guard('admin')->logout();
                    session()->flash('error', 'Your account is inactive.');
                    return redirect()->route('admin.login');
                }
                
                session()->flash('success', 'Successully Logged in !');
                if (Auth::guard('admin')->user()->roles[0]->name == 'Customer') {
                    return redirect()->route('client');
                }else{
                    return redirect()->route('admin.dashboard');
                }
            }
            // error
            session()->flash('error', 'Invalid email and password');
            return back();
        }
    }

    /**
     * logout admin guard
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
