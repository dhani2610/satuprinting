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
       // Ambil data dari database
        $categories = CategoryDocument::whereNull('deleted_at')
        ->where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        // Urutan kategori yang diinginkan
        $order = [
            "Cetak Indoor",
            "Cetak Outdoor",
            "Cetak Digital A3+",
            "Cetak Offset",
            "Merchandise",
            "Display Banner",
            "Cutting Sticker",
            "Signage",
            "Advertising",
            "Event Both",
            "Pasang Stiker"
        ];

        // Ubah collection menjadi array untuk bisa diurutkan
        $categoriesArray = $categories->toArray();

        // Urutkan berdasarkan urutan kategori yang diinginkan
        usort($categoriesArray, function ($a, $b) use ($order) {
            return array_search($a['category'], $order) - array_search($b['category'], $order);
        });
        $data['category'] = $categoriesArray;
        // return response()->json($categoriesArray);

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
            // dd('msk');
            $data['allProducts'] = Services::where('id_category',$request->category)->whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        }else{
            $data['allProducts'] = Services::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        }
        return view('landing.home.category',$data);
    }

    public function generate() {
        $data['category'] = CategoryDocument::whereNull('deleted_at')->where('status',1)->orderBy('created_at','desc')->get();
        // return response()->json($data['category']);
        // Categories and Services Data
        $categories = [
            2 => 'Cetak Digital A3+',
            5 => 'Cetak Indoor',
            3 => 'Cetak Outdoor'
        ];
    
        $services = [
            // Category 1: CETAK A3+
            1 => [
                ['service' => 'Art paper 100 gr (1 Side)', 'price' => 5000],
                ['service' => 'Art paper 120 gr (1 Side)', 'price' => 5000],
                ['service' => 'Art paper 150 gr (1 Side)', 'price' => 5000],
                ['service' => 'Art Karton 150 gr (1 Side)', 'price' => 5500],
                ['service' => 'Art Karton 190 gr (1 Side)', 'price' => 5500],
                ['service' => 'Art Karton 210 gr (1 Side)', 'price' => 5500],
                ['service' => 'Art Karton 230 gr (1 Side)', 'price' => 5500],
                ['service' => 'HVS 80 gr (1 Side)', 'price' => 3000],
                ['service' => 'HVS 100 gr (1 Side)', 'price' => 3000],
                ['service' => 'Brosur Art Paper A4 (1 Side) 1 rim', 'price' => 275000],
                ['service' => 'Brosur Art Paper A5 (1 Side) 1 rim', 'price' => 150000],
                ['service' => 'Brosur Art Karton A4 (1 Side) 1 rim', 'price' => 300000],
                ['service' => 'Brosur Art Karton A5 1 rim', 'price' => 175000],
            ],
            // Category 2: PRINT INDOOR
            2 => [
                ['service' => 'Albatros', 'price' => 100000],
                ['service' => 'Stiker Ritrama', 'price' => 100000],
                ['service' => 'Stiker Duratac', 'price' => 100000],
                ['service' => 'Stiker Quantac', 'price' => 100000],
                ['service' => 'Stiker Superstick', 'price' => 100000],
                ['service' => 'Duratrans', 'price' => 100000],
                ['service' => 'Photo Paper', 'price' => 100000],
                ['service' => 'Kanvas', 'price' => 100000],
                ['service' => 'Cloth Banner', 'price' => 100000],
                ['service' => 'Sticker Sanblast', 'price' => 100000],
                ['service' => 'Laminating', 'price' => 10000],
            ],
            // Category 3: PRINT OUTDOOR
            3 => [
                ['service' => 'Flexy Banner 260 gr', 'price' => 20000],
                ['service' => 'Flexy Banner 340 gr', 'price' => 25000],
                ['service' => 'Flexy Korea 440 gr', 'price' => 42000],
                ['service' => 'Backlite Korea', 'price' => 50000],
            ]
        ];
    
        // Fill empty categories (4 to 10) with random services
        $randomServices = ['Layanan A', 'Layanan B', 'Layanan C', 'Layanan D', 'Layanan E'];
        $randomPhotos = ['asdjsajdasnjnsajn.webp', '1727591493.jpeg', '1727591122.jpeg'];
        
        
        for ($i = 4; $i <= 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $services[$i][] = [
                    'service' => $randomServices[array_rand($randomServices)],
                    'price' => rand(1000, 100000),
                    'photo' => $randomPhotos[array_rand($randomPhotos)],
                ];
            }
        }

        foreach ($services as $categoryId => $categoryServices) {
            for ($i = 0; $i < 6; $i++) {
                $services[$categoryId][] = [
                    'service' => $randomServices[array_rand($randomServices)],
                    'price' => rand(1000, 100000),
                    'photo' => $randomPhotos[array_rand($randomPhotos)],
                ];
            }
        }
        
    
        // Combine services into a final array for creation
        $finalServices = [];
        foreach ($services as $categoryId => $categoryServices) {
            foreach ($categoryServices as $service) {
                $finalServices[] = [
                    'service' => $service['service'],
                    'description' => $categories[$categoryId] ?? 'Unknown Category',
                    'id_category' => $categoryId,
                    'price' => $service['price'],
                    'image' => $randomPhotos[array_rand($randomPhotos)],
                    'is_dison' => rand(0, 1), // Random availability (1 or 0)
                ];
            }
        }
    
        // return response()->json($finalServices);

        // Save the services to the database
        foreach ($finalServices as $data) {
            Services::create([
                'service' => $data['service'],
                'description' => $data['description'],
                'id_category' => $data['id_category'],
                'price' => $data['price'],
                'image' => $data['image'],
                'is_diskon' => $data['is_dison'],
            ]);
        }
        
        // Return response with the created services
        return response()->json($finalServices);
    }
    
}
