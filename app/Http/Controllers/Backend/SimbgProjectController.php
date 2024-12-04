<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CategoryKajian;
use App\Models\CategorySimbg;
use App\Models\Customer;
use App\Models\Simbg;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\SurveyProject;
use App\Models\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimbgProjectController extends Controller
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
        $data['title_btn_create'] = 'Add SIMBG';
        $data['proj'] = Project::find($id);
        $data['team'] = Admin::where('type',null)->where('deleted_at',null)->where('status',1)->orderBy('created_at', 'desc')->get();
        $data['teamProject'] = TeamProject::where('id_project',$id)->get()->pluck('id_team');
        $data['list_team'] = Admin::whereIn('id',$data['teamProject'])->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['simbgs'] = Simbg::where('deleted_at',null)->where('id_project',$id)->orderBy('created_at','desc')->get();
        $data['category_simbg'] = CategorySimbg::where('deleted_at',null)->where('status',1)->orderBy('created_at','asc')->get();

        return view('backend.pages.transaction.project.simbg.index', $data);
    }

    public function store(Request $request,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $proj = Project::find($id);
            $cust = Admin::where('id',$proj->id_customer)->first();

            $lastsimbg = Simbg::where('id_project',$id)->orderBy('id', 'desc')->first();
            if ($lastsimbg) {
                $parts = explode('-', $lastsimbg->no_simbg);
                $lastsimbgNumber = intval($parts[2]); // Mengambil bagian nomor dan mengonversi ke integer
                $newsimbgNumber = $lastsimbgNumber + 1;
            } else {
                $newsimbgNumber = 1;
            }
            $newsimbgNumberFormatted = 'SIMBG-'. $cust->kode .'-'. str_pad($newsimbgNumber, 3, '0', STR_PAD_LEFT);

            $data = new Simbg();
            $data->no_simbg = $newsimbgNumberFormatted;
            $data->id_project = $id;
            $data->id_category = $request->id_category;
            $dokumenval = $request->file('document');
    
            if ($dokumenval != null) {
                $documentPath = public_path('documents/simbg/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $data->document = $documentName;
            }
            $data->status = $request->status;
            $data->note = $request->note;
            $data->created_by = Auth::guard('admin')->user()->id;
            $data->save();

            $cat = CategorySimbg::find($data->id_category);

            // create activity 
            $activity = new ProjectActivity();
            $activity->id_project = $data->id_project;
            $activity->action_by = $this->user->id;
            $activity->type = 'SIMBG';
            $content = $cat->category . ' ' . ($data->status == 1 ? 'Berhasil' : 'Dalam Proses');
            $activity->content = $content;
            $activity->date = date('Y-m-d');
            $activity->save();
            

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id_project,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $data = Simbg::find($id);
            $data->id_category = $request->id_category;
            $dokumenval = $request->file('document');
    
            if ($dokumenval != null) {
                $documentPath = public_path('documents/simbg/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $data->document = $documentName;
            }
            $data->status = $request->status;
            $data->note = $request->note;
            $data->save();

            $cat = CategorySimbg::find($data->id_category);

            // create activity 
            $activity = new ProjectActivity();
            $activity->id_project = $data->id_project;
            $activity->action_by = $this->user->id;
            $activity->type = 'SIMBG';
            $content = $cat->category . ' ' . ($data->status == 1 ? 'Berhasil' : 'Dalam Proses');
            $activity->content = $content;
            $activity->date = date('Y-m-d');
            $activity->save();

            session()->flash('success', 'Data has been edited !!');
            return redirect()->back();

        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed edited !!');
            return redirect()->back();
        }
    }

    public function destroy(Request $request,$id_project,$id)
    {
        if (is_null($this->user) || !$this->user->can('project.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to deleted any project !');
        }
        try {

            $data = Simbg::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted.');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed deleted.');
            return redirect()->back();
        }
    }
}
