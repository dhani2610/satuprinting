<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = 'Slider';
        $data['title_btn_create'] = 'Create Slider';
        $data['sliders'] = Slider::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.slider.index', $data);
    }
    public function store(Request $request)
    {
        try {
            $data = new Slider();
            $data->title = $request->category;
            $data->status = $request->status;
            $data->description = $request->description;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/slider/');
                $image->move($destinationPath, $name);
                $data->image = $name;
            }
            $data->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            dd($th->getMessage());
            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $data = Slider::find($id);
            $data->title = $request->category;
            $data->status = $request->status;
            $data->description = $request->description;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/slider/');
                $image->move($destinationPath, $name);
                $data->image = $name;
            }
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

        try {
            $data = Slider::find($id);
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
