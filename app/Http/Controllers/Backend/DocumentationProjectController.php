<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CategoryKajian;
use App\Models\CategorySimbg;
use App\Models\Customer;
use App\Models\Documentation;
use App\Models\Simbg;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\SurveyProject;
use App\Models\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentationProjectController extends Controller
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
        $data['documentations'] = Documentation::where('deleted_at',null)->where('id_project',$id)->orderBy('created_at','desc')->get();

        return view('backend.pages.transaction.project.documentation.index', $data);
    }

    public function store(Request $request,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $data = new Documentation();
            $data->id_project = $id;
            $data->title = $request->title;
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/documentation/');
                $image->move($destinationPath, $name);
                $data->foto = $name;
            }
            $data->created_by = Auth::guard('admin')->user()->id;
            $data->save();

             // create activity 
             $activity = new ProjectActivity();
             $activity->id_project = $id;
             $activity->action_by = $this->user->id;
             $activity->type = 'Documentation';
             $activity->content = 'Dokumentasi berhasil di upload';
             $activity->file = asset('/assets/img/documentation/'.$data->foto);
             $activity->date = date('Y-m-d');
             $activity->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {

            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $data = Documentation::find($id);
            $data->id_project = $id;
            $data->title = $request->title;
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/documentation/');
                $image->move($destinationPath, $name);
                $data->foto = $name;
            }
            $data->save();

           // create activity 
           $activity = new ProjectActivity();
           $activity->id_project = $id;
           $activity->action_by = $this->user->id;
           $activity->type = 'Documentation';
           $activity->content = 'Dokumentasi berhasil di upload';
           $activity->file = asset('/assets/img/documentation/'.$data->foto);
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

            $data = Documentation::find($id);
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
