<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisiController extends Controller
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
        if (is_null($this->user) || !$this->user->can('divisi.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any divisi !');
        }

        $data['page_title'] = 'Divisi';
        $data['divisis'] = Divisi::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.divisi.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('divisi.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any divisi !');
        }

        try {
            $data = new Divisi();
            $data->divisi = $request->divisi;
            $data->description = $request->description;
            $data->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('divisi.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any divisi !');
        }

        try {
            $data = Divisi::find($id);
            $data->divisi = $request->divisi;
            $data->description = $request->description;
            $data->save();

            session()->flash('success', 'Data has been edited !!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed edited !!');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('divisi.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any divisi !');
        }

        try {
            $data = Divisi::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted !!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed deleted !!');
            return redirect()->back();
        }
    }
}
