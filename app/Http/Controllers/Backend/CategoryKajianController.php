<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryKajian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryKajianController extends Controller
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
        if (is_null($this->user) || !$this->user->can('category.kajian.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any kajian !');
        }

        $data['page_title'] = 'Category Document';
        $data['title_btn_create'] = 'Add Kajian';
        $data['categorys'] = CategoryKajian::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.category-kajian.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('category.kajian.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any kajian !');
        }

        try {
            $data = new CategoryKajian();
            $data->category = $request->category;
            $data->status = $request->status;
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
        if (is_null($this->user) || !$this->user->can('category.kajian.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any kajian !');
        }

        try {
            $data = CategoryKajian::find($id);
            $data->category = $request->category;
            $data->status = $request->status;
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
        if (is_null($this->user) || !$this->user->can('category.kajian.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any kajian !');
        }

        try {
            $data = CategoryKajian::find($id);
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
