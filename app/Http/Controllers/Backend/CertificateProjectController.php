<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\PurchaseOrder;
use App\Models\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateProjectController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index($id){
        if (is_null($this->user) || !$this->user->can('project.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project !');
        }

        $data['page_title'] = 'Project';
        $data['proj'] = Project::find($id);
        $data['team'] = Admin::where('type',null)->where('deleted_at',null)->where('status',1)->orderBy('created_at', 'desc')->get();
        $data['teamProject'] = TeamProject::where('id_project',$id)->get()->pluck('id_team');
        $data['list_team'] = Admin::whereIn('id',$data['teamProject'])->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['purchaseOrder'] = PurchaseOrder::orderBy('created_at','desc')->get();
        $data['certificate'] = Certificate::where('id_project',$id)->first();
        return view('backend.pages.transaction.project.certificate.index', $data);
    }


    public function store(Request $request, $id) {
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }
    
        try {
            $cek = Certificate::where('id_project',$id)->first();
            if ($cek == null) {
                $data = new Certificate();
            }else{
                $data = Certificate::find($cek->id);
            }
            $data->id_project = $id;
            $data->created_by = $this->user->id;
            $dokumenval = $request->file('lampiran');
    
            if ($dokumenval != null) {
                $documentPath = public_path('documents/certificate/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $data->certificate = $documentName;
            }
    
            $data->save();

             // create activity 
             $activity = new ProjectActivity();
             $activity->id_project = $id;
             $activity->action_by = $this->user->id;
             $activity->type = 'Certificate';
             $activity->content = 'Sertifikat berhasil di upload';
             $activity->file = asset('/documents/certificate/'.$data->certificate);
             $activity->date = date('Y-m-d');
             $activity->save();
    
            return response()->json(['success' => true, 'file' => asset('/documents/certificate/'.$data->file)], 200);
        } catch (\Throwable $th) {
            // return response()->json(['success' => false, 'message' => 'Data has failed created'], 500);
            return response()->json(['success' => false, 'message' => 'Data has failed created'], 500);
        }
    }
}
