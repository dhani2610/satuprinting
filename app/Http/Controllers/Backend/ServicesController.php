<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryDocument;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
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
        if (is_null($this->user) || !$this->user->can('services.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any services !');
        }

        $data['page_title'] = 'Product';
        $data['title_btn_create'] = 'Add Product';
        $data['services'] = Services::where('deleted_at',null)->orderBy('created_at','desc')->get();
        $data['category'] = CategoryDocument::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.services.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('services.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any services !');
        }

        try {
            $data = new Services();
            $data->service = $request->service;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->content = $request->content;
            $data->id_category = $request->id_category;
            $data->price = $request->price;
            $data->is_diskon = $request->is_diskon;
            $data->shopee = $request->shopee;
            $data->tokopedia = $request->tokopedia;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/product/');
                $image->move($destinationPath, $name);
                $data->image = $name;
            }
            $data->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('services.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any services !');
        }

        try {
            $data = Services::find($id);
            $data->service = $request->service;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->content = $request->content;
            $data->id_category = $request->id_category;
            $data->price = $request->price;
            $data->is_diskon = $request->is_diskon;
            $data->shopee = $request->shopee;
            $data->tokopedia = $request->tokopedia;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/product/');
                $image->move($destinationPath, $name);
                $data->image = $name;
            }
            
            $data->save();
            // dd($request->all(),$data);

            session()->flash('success', 'Data has been edited !!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('services.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any services !');
        }

        try {
            $data = Services::find($id);
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
