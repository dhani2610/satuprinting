<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
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
        if (is_null($this->user) || !$this->user->can('city.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any city !');
        }

        $data['page_title'] = 'City';
        $data['title_btn_create'] = 'Add City';
        $data['citys'] = City::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $data['states'] = State::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.city.index', $data);
    }

    public function getCity(Request $request){
        $id_state = $request->all();
        $city = City::where('id_state',$id_state)->where('deleted_at',null)->orderBy('created_at','desc')->get();
        return response()->json([
            'msg' => 'berhasil',
            'city' => $city
        ]);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('city.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any city !');
        }

        try {
            $data = new City();
            $data->id_state = $request->id_state;
            $data->city = $request->city;
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
        if (is_null($this->user) || !$this->user->can('city.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any city !');
        }

        try {
            $data = City::find($id);
            $data->id_state = $request->id_state;
            $data->city = $request->city;
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
        if (is_null($this->user) || !$this->user->can('city.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any city !');
        }

        try {
            $data = city::find($id);
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
