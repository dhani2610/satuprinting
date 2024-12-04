<?php

use App\Models\CategoryDocument;
use App\Models\CategoryKajian;
use App\Models\CategorySimbg;
use App\Models\Certificate;
use App\Models\Documentation;
use App\Models\DocumentProject;
use App\Models\Kajian;
use App\Models\Project;
use App\Models\Simbg;
use App\Models\SurveyProject;

if (!function_exists('calculateDocumentPercentage')) {
    function calculateDocumentPercentage($projectId) {
        $documentCat = CategoryDocument::where('deleted_at', null)->where('status', 1)->get();
        $documentRumus = DocumentProject::where('id_project', $projectId)->get();
        $countDoc = 0;
        if ($documentRumus->count() > 0) {
            foreach ($documentCat as $dcr) {
                $documentExist = DocumentProject::where('id_project', $projectId)->where('id_category',$dcr->id)->first();
                if ($documentExist != null) {
                    $countDoc += 1;
                }
            }
        }
        $totalDocumentCategories = $documentCat->count();
        if ($totalDocumentCategories > 0) {
            return ($countDoc / $totalDocumentCategories) * 20;
        } else {
            return 0;
        }
    }
}

if (!function_exists('calculateSurveyPercentage')) {
    function calculateSurveyPercentage($projectId) {
        $survey = SurveyProject::where('id_project', $projectId)->where('deleted_at', null)->get();
        if (count($survey) > 0) {
            return 10;
        } else {
            return 0;
        }
    }
}


if (!function_exists('calculateKajianPercentage')) {
    function calculateKajianPercentage($projectId) {
        $Cat = CategoryKajian::where('deleted_at', null)->where('status', 1)->get();
        $Rumus = Kajian::where('id_project', $projectId)->get();
        $count = 0;
        if ($Rumus->count() > 0) {
            foreach ($Cat as $dcr) {
                $dataExist = Kajian::where('deleted_at',null)->where('status',2)->where('id_project', $projectId)->where('id_category',$dcr->id)->first();
                if ($dataExist != null) {
                    $count += 1;
                }
            }
        }
        $totalCategories = $Cat->count();
        if ($totalCategories > 0) {
            $percentage = ($count / $totalCategories) * 20;
            return $percentage;
        } else {
            return 0;
        }
    }
}

if (!function_exists('calculateSimbgPercentage')) {
    function calculateSimbgPercentage($projectId) {
        $Cat = CategorySimbg::where('deleted_at', null)->where('status', 1)->get();
        $Rumus = Simbg::where('id_project', $projectId)->get();
        $count = 0;
        if ($Rumus->count() > 0) {
            foreach ($Cat as $dcr) {
                $dataExist = Simbg::where('deleted_at',null)->where('status',2)->where('id_project', $projectId)->where('id_category',$dcr->id)->first();
                if ($dataExist != null) {
                    $count += 1;
                }
            }
        }
        $totalCategories = $Cat->count();
        if ($totalCategories > 0) {
            $percentage = ($count / $totalCategories) * 30;
            return $percentage;
        } else {
            return 0;
        }
    }
}

if (!function_exists('calculateCertificatePercentage')) {
    function calculateCertificatePercentage($projectId) {
        $data = Certificate::where('id_project', $projectId)->get();
        if (count($data) > 0) {
            return 10;
        } else {
            return 0;
        }
    }
}

if (!function_exists('calculateDocumentationPercentage')) {
    function calculateDocumentationPercentage($projectId) {
        $data = Documentation::where('id_project', $projectId)->get();
        if (count($data) > 0) {
            return 10;
        } else {
            return 0;
        }
    }
}

if (!function_exists('getProgresPercentageProject')) {
    function getProgresPercentageProject($projectId) {
        $persentaseTahapDoc = calculateDocumentPercentage($projectId);
        $persentaseTahapSurvey = calculateSurveyPercentage($projectId);
        $persentaseTahapKajian = calculateKajianPercentage($projectId);
        $persentaseTahapSimbg = calculateSimbgPercentage($projectId);
        $persentaseTahapCertificate = calculateCertificatePercentage($projectId);
        $persentaseTahapDocumentation = calculateDocumentationPercentage($projectId);

        $persentaseProject = round($persentaseTahapDoc + $persentaseTahapSurvey + $persentaseTahapKajian + $persentaseTahapSimbg + $persentaseTahapCertificate + $persentaseTahapDocumentation);
        return $persentaseProject;
    }
}

if (!function_exists('getOnProgressProject')) {
    function getTotalStatusProject($status) {
        $project = Project::orderBy('created_at','desc')->get();

        $totalOverDue = 0;
        $totalOnProgres = 0;
        $totalDone = 0;
        foreach ($project as $key => $proj) {
            if (getProgresPercentageProject($proj->id) < 100){
                if (date('Y-m-d') > $proj->deadline){
                        $totalOverDue += 1;
                }else{
                    $totalOnProgres += 1;
                }
            }else{
                $totalDone += 1;
            }
        }

        if ($status == 'Done') {
            return $totalDone;
        }elseif ($status == 'Overdue') {
            return $totalOverDue;
        }elseif($status == 'On Progres'){
            return $totalOnProgres;
        }
    }
}

if (!function_exists('getIdProjectByStatus')) {
    function getIdProjectByStatus($status) {
        $project = Project::orderBy('created_at','desc')->get();

        $OverDue = [];
        $OnProgres = [];
        $Done = [];
        foreach ($project as $key => $proj) {
            if (getProgresPercentageProject($proj->id) < 100){
                if (date('Y-m-d') > $proj->deadline){
                    $OverDue[] = $proj->id;
                }else{
                    $OnProgres[] = $proj->id;
                }
            }else{
                $Done[] = $proj->id;
            }
        }

        if ($status == 'Done') {
            return $Done;
        }elseif ($status == 'Overdue') {
            return $OverDue;
        }elseif($status == 'On Progres'){
            return $OnProgres;
        }
    }
}
