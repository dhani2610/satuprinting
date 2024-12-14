<?php

namespace App\Http\Controllers;

use App\Models\CategoryDocument;
use App\Models\CategoryKajian;
use App\Models\Services;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function homepage(){
        $data['category'] = CategoryDocument::whereNull('deleted_at')->where('status',1)->orderBy('created_at','asc')->get();
        $data['slider'] = Slider::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['product'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->limit(5)->get();
        $data['allProducts'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        return view('pwa.home.index',$data);
    }
    public function detail($id){
        $data['product'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->limit(5)->whereNotIn('id',[$id])->get();
        $data['prod'] = Services::find($id);
        $data['page_title'] = $data['prod']->service;
        return view('pwa.home.detail',$data);
    }

    public function home(){
        $data['category'] = CategoryDocument::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['slider'] = Slider::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['product'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->limit(5)->get();
        $data['allProducts'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['allProductsDisc'] = Services::whereNull('deleted_at')->where('status',1)->where('is_diskon',1)->orderBy('created_at','desc')->get();
        return view('landing.home.index',$data);
    }

    public function detailProd($id){
        $data['slider'] = Slider::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['product'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->limit(5)->whereNotIn('id',[$id])->get();
        $data['prod'] = Services::find($id);
        $data['page_title'] = $data['prod']->service;
        return view('landing.home.detail',$data);
    }

    
    public function category(Request $request){
        $data['category'] = CategoryDocument::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['slider'] = Slider::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        $data['product'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->limit(5)->get();
        if ($request->category != null && $request->category != 'all') {
            $data['allProducts'] = Services::where('id_category',$request->category)->whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        }else{
            $data['allProducts'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        }
        return view('landing.home.category',$data);
    }
}
