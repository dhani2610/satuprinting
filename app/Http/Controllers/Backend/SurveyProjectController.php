<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\SurveyProject;
use App\Models\TeamProject;
use App\Models\TeamSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyProjectController extends Controller
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
        $data['title_btn_create'] = 'Add Survey';
        $data['proj'] = Project::find($id);
        $data['team'] = Admin::where('type',null)->where('deleted_at',null)->where('status',1)->orderBy('created_at', 'desc')->get();
        $data['teamProject'] = TeamProject::where('id_project',$id)->get()->pluck('id_team');
        $data['list_team'] = Admin::whereIn('id',$data['teamProject'])->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['surveys'] = SurveyProject::where('deleted_at',null)->where('id_project',$id)->orderBy('created_at','desc')->get();

        return view('backend.pages.transaction.project.survey.index', $data);
    }

    public function store(Request $request,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $proj = Project::find($id);
            $cust = Admin::where('id',$proj->id_customer)->first();

            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastSurvey = SurveyProject::where('id_project',$id)->orderBy('id', 'desc')->first();
            if ($lastSurvey) {
                $parts = explode('-', $lastSurvey->no_survey);
                $lastSurveyNumber = intval($parts[2]); // Mengambil bagian nomor dan mengonversi ke integer
                $newSurveyNumber = $lastSurveyNumber + 1;
            } else {
                $newSurveyNumber = 1;
            }
            $newSurveyNumberFormatted = 'SVY-'. $cust->kode .'-'. str_pad($newSurveyNumber, 3, '0', STR_PAD_LEFT);
            // dd($newSurveyNumberFormatted);

            $data = new SurveyProject();
            $data->no_survey = $newSurveyNumberFormatted;
            $data->id_project = $id;
            $data->note = $request->note;
            $data->created_by = Auth::guard('admin')->user()->id;
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/photo-survey/');
                $image->move($destinationPath, $name);
                $data->photo = $name;
            }
            $data->save();

            $team = $request->id_team;
            if (count($team) > 0) {
                foreach ($team as $id_team) {
                    $dataTeam = new TeamSurvey();
                    $dataTeam->id_team = $id_team;

                    $dataTeam->id_survey = $data->id;
                    $dataTeam->save();
                }
            }

             // create activity 
            $activity = new ProjectActivity();
            $activity->id_project = $data->id_project;
            $activity->action_by = $this->user->id;
            $activity->type = 'Survey';
            $activity->content = 'Sudah dilakukan survey lapangan';
            $activity->date = date('Y-m-d');
            $activity->save();

            session()->flash('success', 'Data has been created !!');
            return redirect()->back();

        } catch (\Throwable $th) {
            // dd($th->getMessage());
            session()->flash('failed', 'Data has failed created !!');
            return redirect()->back();
        }
    }
    public function update(Request $request,$id_project,$id){
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $data = SurveyProject::find($id);
            $data->id_project = $id_project;
            $data->note = $request->note;
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/photo-survey/');
                $image->move($destinationPath, $name);
                $data->photo = $name;
            }
            $data->save();

            $team = $request->id_team;
            if (count($team) > 0) {
                $cekTeam = TeamSurvey::where('id_survey',$data->id)->get();
                if (!empty($cekTeam)) {
                    foreach ($cekTeam as $td) {
                        $delete = TeamSurvey::find($td->id);
                        $delete->delete();
                    }
                }

                // INSERT 
                foreach ($team as $id_team) {
                    $dataTeam = new TeamSurvey();
                    $dataTeam->id_team = $id_team;
                    $dataTeam->id_survey = $data->id;
                    $dataTeam->save();
                }
            }

            // // create activity 
            // $activity = new ProjectActivity();
            // $activity->id_project = $data->id_project;
            // $activity->action_by = $this->user->id;
            // $activity->type = 'Survey';
            // $activity->content = 'Sudah dilakukan survey lapangan';
            // $activity->date = date('Y-m-d');
            // $activity->save();
            
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

            $data = SurveyProject::find($id);
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
