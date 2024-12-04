<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
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
        if (is_null($this->user) || !$this->user->can('state.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any state !');
        }

        $data['page_title'] = 'State';
        $data['states'] = State::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.state.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('state.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any state !');
        }

        try {
            $data = new State();
            $data->state = $request->state;
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
        if (is_null($this->user) || !$this->user->can('state.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any state !');
        }

        try {
            $data = State::find($id);
            $data->state = $request->state;
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
        if (is_null($this->user) || !$this->user->can('state.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any state !');
        }

        try {
            $data = State::find($id);
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
