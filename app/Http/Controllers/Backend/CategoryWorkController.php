<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryWorkController extends Controller
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
        if (is_null($this->user) || !$this->user->can('category.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any category work !');
        }

        $data['page_title'] = 'Category Work';
        $data['categorys'] = CategoryWork::orderBy('created_at','desc')->get();
        return view('backend.pages.master-data.category.index', $data);
    }

 
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('category.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any category work !');
        }

        try {
            $data = new CategoryWork();
            $data->category = $request->category;
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
        if (is_null($this->user) || !$this->user->can('category.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any category work !');
        }

        try {
            $data = CategoryWork::find($id);
            $data->category = $request->category;
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
        if (is_null($this->user) || !$this->user->can('category.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any category work !');
        }

        try {
            $data = CategoryWork::find($id);
            $data->delete();

            session()->flash('success', 'Data has been deleted !!');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed deleted !!');
            return redirect()->back();
        }
    }
}
