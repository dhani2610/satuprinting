<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryDocument;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryDocumentController extends Controller
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
        if (is_null($this->user) || !$this->user->can('category.document.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any services !');
        }

        $data['page_title'] = 'Category';
        $data['title_btn_create'] = 'Add Category';
        $data['categorys'] = CategoryDocument::where('deleted_at',null)->orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.category-document.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('category.document.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any services !');
        }

        try {
            $data = new CategoryDocument();
            $data->category = $request->category;
            $data->status = $request->status;
            $data->description = $request->description;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/category/');
                $image->move($destinationPath, $name);
                $data->image = $name;
            }
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
        if (is_null($this->user) || !$this->user->can('category.document.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any services !');
        }

        try {
            $data = CategoryDocument::find($id);
            $data->category = $request->category;
            $data->status = $request->status;
            $data->description = $request->description;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/category/');
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
        if (is_null($this->user) || !$this->user->can('category.document.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any services !');
        }

        try {
            $data = CategoryDocument::find($id);
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
