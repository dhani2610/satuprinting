<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['page_title'] = 'Setting General';
        $data['title_btn_create'] = 'Setting General';
        $data['setting'] = Setting::first();
        return view('backend.pages.master-data.setting.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $cek = Setting::first();
            if ($cek == null) {
                $data = new Setting();
            }else{
                $data = Setting::find($cek->id);
            }
            $data->nama_website = $request->nama_website;
            $data->link_wa = $request->link_wa;
            $data->meta_description = $request->meta_description;
            $data->meta_keyword = $request->meta_keyword;
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/logo/');
                $image->move($destinationPath, $name);
                $data->logo = $name;
            }
            if ($request->hasFile('banner_popup')) {
                $image = $request->file('banner_popup');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/banner_popup/');
                $image->move($destinationPath, $name);
                $data->banner_popup = $name;
            }
            $data->save();

            session()->flash('success', 'Data has been updated');
            return redirect()->back();

        } catch (\Throwable $th) {
            dd($th->getMessage());
            session()->flash('failed', 'Data has failed updated');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
