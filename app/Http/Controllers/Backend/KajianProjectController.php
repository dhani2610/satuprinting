<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CategoryKajian;
use App\Models\Customer;
use App\Models\Kajian;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\SurveyProject;
use App\Models\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KajianProjectController extends Controller
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
        $data['title_btn_create'] = 'Add Kajian';
        $data['proj'] = Project::find($id);
        $data['team'] = Admin::where('type',null)->where('deleted_at',null)->where('status',1)->orderBy('created_at', 'desc')->get();
        $data['teamProject'] = TeamProject::where('id_project',$id)->get()->pluck('id_team');
        $data['list_team'] = Admin::whereIn('id',$data['teamProject'])->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['kajians'] = Kajian::where('deleted_at',null)->where('id_project',$id)->orderBy('created_at','desc')->get();
        $data['category_kajian'] = CategoryKajian::where('deleted_at',null)->where('status',1)->orderBy('created_at','desc')->get();

        return view('backend.pages.transaction.project.kajian.index', $data);
    }

    public function store(Request $request,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $proj = Project::find($id);
            $cust = Admin::where('id',$proj->id_customer)->first();

            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastKajian = Kajian::where('id_project',$id)->orderBy('id', 'desc')->first();
            if ($lastKajian) {
                $parts = explode('-', $lastKajian->no_kajian);
                $lastKajianNumber = intval($parts[2]); // Mengambil bagian nomor dan mengonversi ke integer
                $newKajianNumber = $lastKajianNumber + 1;
            } else {
                $newKajianNumber = 1;
            }
            $newKajianNumberFormatted = 'KJ-'. $cust->kode .'-'. str_pad($newKajianNumber, 3, '0', STR_PAD_LEFT);
            // dd($newKajianNumberFormatted,$parts,$newKajianNumber);

            $data = new Kajian();
            $data->no_kajian = $newKajianNumberFormatted;
            $data->id_project = $id;
            $data->id_category = $request->id_category;
            $data->link_drive = $request->link_drive;
            $data->status = $request->status;
            $data->note = $request->note;
            $data->catatan = $request->catatan;
            $data->created_by = Auth::guard('admin')->user()->id;
            $data->save();

            $cat = CategoryKajian::find($data->id_category);
            // create activity 
            $activity = new ProjectActivity();
            $activity->id_project = $data->id_project;
            $activity->action_by = $this->user->id;
            $activity->type = 'Kajian';
            $content = $cat->category . ' ' . ($data->status == 1 ? 'Berhasil' : 'Dalam Proses');
            $activity->content = $content;
            $activity->date = date('Y-m-d');
            $activity->save();
            
            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
        // dd($request->all(),$th->getMessage());

            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id_project,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $data = Kajian::find($id);
            $data->id_category = $request->id_category;
            $data->link_drive = $request->link_drive;
            $data->status = $request->status;
            $data->note = $request->note;
            $data->catatan = $request->catatan;
            $data->save();

            $cat = CategoryKajian::find($data->id_category);

            // create activity 
            $activity = new ProjectActivity();
            $activity->id_project = $data->id_project;
            $activity->action_by = $this->user->id;
            $activity->type = 'Kajian';
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

            $data = Kajian::find($id);
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
