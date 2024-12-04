<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CategoryDocument;
use App\Models\CategorySimbg;
use App\Models\CategoryWork;
use App\Models\Certificate;
use App\Models\Documentation;
use App\Models\DocumentProject;
use App\Models\Kajian;
use App\Models\Project;
use App\Models\ProjectActivity;
use App\Models\PurchaseOrder;
use App\Models\Simbg;
use App\Models\SurveyProject;
use App\Models\TeamProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('project.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project !');
        }

        $data['page_title'] = 'Project';
        $getProjectUser = TeamProject::where('id_team',Auth::guard('admin')->user()->id)->get()->pluck('id_project');
        $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        $id_user = $this->user->id;
        $customer = $request->id_customer;
        $marketing = $request->id_marketing;
        // Date start date
        $date_start = $this->formatDateDb($request->start_date);

        // Date deadline date
        $deadline = $this->formatDateDb($request->deadline);

        // Date created date
        $createdAt = $this->formatDateDbWithTime($request->created_at);
        // dd($date_start);
        $data['project'] = Project::where('deleted_at', null)->orderBy('created_at', 'desc')->where(function($query) use 
        ($getProjectUser,$userRole,$date_start,$deadline,$createdAt,$customer,$marketing)
        {
            if (!in_array($userRole, ['superadmin', 'Superadmin'])) {
                $query->whereIn('id', $getProjectUser);
            }

            if (!empty($customer)) {
                $query->where('id_customer',$customer);
            }
            if (!empty($marketing)) {
                $query->where('id_marketing',$marketing);
            }
            if (!empty($date_start['start_date']) && !empty($date_start['end_date'])) {
                $query->whereBetween('start_date', [$date_start['start_date'],$date_start['end_date']]);
            }
            if (!empty($deadline['start_date']) && !empty($deadline['end_date'])) {
                $query->whereBetween('deadline', [$deadline['start_date'],$deadline['end_date']]);
            }
            if (!empty($createdAt['start_date']) && !empty($createdAt['end_date'])) {
                $query->whereBetween('created_at', [$createdAt['start_date'],$createdAt['end_date']]);
            }
        })->get();
        $data['title_btn_create'] = 'Add New Project';

        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['purchaseOrder'] = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $data['customers_project'] = Admin::whereIn('id', $data['project']->pluck('id_customer'))->where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['marketing_project'] = Admin::whereIn('id', $data['project']->pluck('id_marketing'))->get();
        $data['date_project'] = Project::orderBy('created_at', 'desc')->get()->pluck('created_at')->unique();
        $data['start_date_project'] = Project::orderBy('created_at', 'desc')->get()->pluck('start_date')->unique();
        $data['deadline_project'] = Project::orderBy('created_at', 'desc')->get()->pluck('deadline')->unique();
        return view('backend.pages.transaction.project.index', $data);
    }

    function formatDateDbWithTime($dateRange){
        if (is_null($dateRange)) {
            $start_date = null;
            $end_date = null;
        } else {
            list($start_date, $end_date) = explode(' - ', $dateRange);
    
            $start_date = Carbon::createFromFormat('m/d/Y', trim($start_date))->format('Y-m-d').' 00:00:00';
            $end_date = Carbon::createFromFormat('m/d/Y', trim($end_date))->format('Y-m-d').' 23:59:59';
        }

        $date = [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        return $date;
    }

    function formatDateDb($dateRange){
        if (is_null($dateRange)) {
            $start_date = null;
            $end_date = null;
        } else {
            list($start_date, $end_date) = explode(' - ', $dateRange);
    
            $start_date = Carbon::createFromFormat('m/d/Y', trim($start_date))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', trim($end_date))->format('Y-m-d');
        }

        $date = [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        return $date;
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }
        // dd($request->all());

        try {
            // Menghitung jumlah aktivitas yang ada untuk menentukan nomor aktivitas berikutnya
            $lastProject = Project::orderBy('id', 'desc')->first();
            if ($lastProject) {
                $parts = explode('-', $lastProject->no_project);
                $lastProjectNumber = intval($parts[1]); // Mengambil bagian nomor dan mengonversi ke integer
                $newProjectNumber = $lastProjectNumber + 1;
            } else {
                $newProjectNumber = 1;
            }
            $newProjectNumberFormatted = 'PRJ-' . str_pad($newProjectNumber, 3, '0', STR_PAD_LEFT);

            $data = new Project();
            $data->no_project = $newProjectNumberFormatted;
            $data->name_project = $request->name_project;
            $data->id_customer = $request->id_customer;
            $data->id_po = $request->id_po;
            $data->start_date = $request->start_date;
            $data->deadline = $request->deadline;
            $data->note = $request->note;
            $data->id_marketing = Auth::guard('admin')->user()->id;
            if ($data->save()) {
                $dataTeam = new TeamProject();
                $dataTeam->id_project = $data->id;
                $dataTeam->id_team = Auth::guard('admin')->user()->id;
                $dataTeam->save();
            }

            session()->flash('success', 'Data has been created');
            return redirect()->back();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            session()->flash('failed', 'Data has failed created');
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('project.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any project !');
        }
        try {
            $data = Project::find($id);
            $data->name_project = $request->name_project;
            $data->id_customer = $request->id_customer;
            $data->id_po = $request->id_po;
            $data->start_date = $request->start_date;
            $data->deadline = $request->deadline;
            $data->note = $request->note;
            $data->save();

            session()->flash('success', 'Data has been updated');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed updated');
            return redirect()->back();
        }
    }
    public function destroy(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('project.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any project !');
        }

        try {
            $data = Project::find($id);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();

            session()->flash('success', 'Data has been deleted');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed deleted');
            return redirect()->back();
        }
    }


    // tahapan 
    public function activity($id)
    {
        if (is_null($this->user) || !$this->user->can('project.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project !');
        }

        $data['page_title'] = 'Project';
        $data['proj'] = Project::find($id);
        $data['team'] = Admin::where('type', null)->where('deleted_at', null)->where('status', 1)->orderBy('created_at', 'desc')->get();
        $data['teamProject'] = TeamProject::where('id_project', $id)->get()->pluck('id_team');
        $data['list_team'] = Admin::whereIn('id', $data['teamProject'])->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['purchaseOrder'] = PurchaseOrder::orderBy('created_at', 'desc')->get();

        // GET ACTIVITY 
        $data['documentations'] = Documentation::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->get();
        $data['documentations_last'] = Documentation::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->first();

        // CERTIFICATE 
        $data['certificate'] = Certificate::where('id_project', $id)->first();

        // SIMBG 
        $data['simbgs'] = Simbg::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->get();
        $data['simbgs_last'] = Simbg::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->first();

        // KAJIAN 
        $data['kajians'] = Kajian::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->get();
        $data['kajians_last'] = Kajian::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->first();

        // SURVEY 
        $data['surveys'] = SurveyProject::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->get();
        $data['surveys_last'] = SurveyProject::where('deleted_at', null)->where('id_project', $id)->orderBy('created_at', 'desc')->first();

        // DOCUMENT 
        $data['document'] = DocumentProject::where('id_project', $id)->orderBy('created_at', 'desc')->get();
        $data['document_last'] = DocumentProject::where('id_project', $id)->orderBy('created_at', 'desc')->first();

        return view('backend.pages.transaction.project.activity.index', $data);
    }

    public function storeTeam(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $data = new TeamProject();
            $data->id_project = $id;
            $data->id_team = $request->id_team;
            $data->save();

            session()->flash('success', 'Data has been created');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('failed', 'Data has failed created');
            return redirect()->back();
        }
    }

    public function document($id)
    {
        if (is_null($this->user) || !$this->user->can('project.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any project !');
        }

        $data['page_title'] = 'Project';
        $data['proj'] = Project::find($id);
        $data['team'] = Admin::where('type', null)->where('deleted_at', null)->where('status', 1)->orderBy('created_at', 'desc')->get();
        $data['teamProject'] = TeamProject::where('id_project', $id)->get()->pluck('id_team');
        $data['list_team'] = Admin::whereIn('id', $data['teamProject'])->get();
        $data['customers'] = Admin::where('type', 'customer')->orderBy('created_at', 'desc')->get();
        $data['purchaseOrder'] = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $data['categoryDocument'] = CategoryDocument::orderBy('created_at', 'desc')->get();
        return view('backend.pages.transaction.project.document.index', $data);
    }


    public function storeDocProject(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('project.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any project !');
        }

        try {
            $cek = DocumentProject::where('id_category', $request->category_id)->where('id_project', $id)->first();
            if ($cek == null) {
                $data = new DocumentProject();
            } else {
                $data = DocumentProject::find($cek->id);
            }
            $data->id_project = $id;
            $data->id_category = $request->category_id;
            $data->created_by = $this->user->id;
            $dokumenval = $request->file('lampiran');

            if ($dokumenval != null) {
                $documentPath = public_path('documents/project/');
                $documentName = $dokumenval->getClientOriginalName();
                $i = 1;
                while (file_exists($documentPath . $documentName)) {
                    $documentName = pathinfo($dokumenval->getClientOriginalName(), PATHINFO_FILENAME) . "($i)." . $dokumenval->getClientOriginalExtension();
                    $i++;
                }
                $dokumenval->move($documentPath, $documentName);
                $data->file = $documentName;
            }

            $data->save();

            $docCat = CategoryDocument::find($data->id_category);

            // create activity 
            $activity = new ProjectActivity();
            $activity->id_project = $id;
            $activity->action_by = $this->user->id;
            $activity->type = 'Document';
            $activity->content = $docCat->category . ' Sudah berhasil';
            $activity->file = asset('/documents/project/' . $data->file);
            $activity->date = date('Y-m-d');
            $activity->save();

            return response()->json(['success' => true, 'file' => asset('/documents/project/' . $data->file)], 200);
        } catch (\Throwable $th) {
            // return response()->json(['success' => false, 'message' => 'Data has failed created'], 500);
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function getActivityDashboard()
    {
        $activities = ProjectActivity::
            orderBy('created_at', 'desc')
            ->limit(2)->get(); // Atur jumlah item per halaman di sini

        $user = Admin::get();

        return response()->json([
            'msg' => 'berhasil',
            'data' => $activities,
            'count_data' => count($activities),
            'user' => $user
        ]);
    }
    public function getActivity($projectId)
    {
        $activities = ProjectActivity::where('id_project', $projectId)
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Atur jumlah item per halaman di sini

        $user = Admin::get();

        return response()->json([
            'msg' => 'berhasil',
            'data' => $activities->items(),
            'count_data' => $activities->total(),
            'user' => $user
        ]);
    }
}
