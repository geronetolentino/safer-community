<?php

namespace App\Http\Controllers\Resident;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Response;
use Carbon\Carbon;

use App\Models\Checklist;
use App\Models\ChecklistDailyItem;
use App\Models\ChecklistDailyTotal;
use App\Models\Hospital;
use App\Models\HospitalPatient;

class HomeController extends Controller
{
    public function index()
    {   

        $poi = Auth::user()->uid;
        $historyCheckList = ChecklistDailyTotal::findByPoi($poi)->orderBy('date_submitted', 'desc')->get();
        $todayCheckList = ChecklistDailyTotal::findByPoi($poi)->today()->first();
        $latestCheckList = ChecklistDailyTotal::findByPoi($poi)->orderBy('date_submitted', 'DESC')->first();
        $checklists = Checklist::get();
        $hospitals = Hospital::get();
        $patient = HospitalPatient::findByPoi(Auth::user()->uid)->status('ADMITTED')->first();

        $data = [
            'pageName' => 'Dashboard',
            'navName' => 'Dashboard',
            'hospitals' => $hospitals,
            'checklists' => $checklists,
            'todayCheckList' => $todayCheckList,
            'historyCheckList' => $historyCheckList,
            'latestCheckList' => $latestCheckList,
            'patient' => $patient,
        ];

        return view('user-resident.home')->with($data);
    }

    // DAILY HEALTH CHECKLIST
    public function dailyChecklistStore(Request $request)
    {

        $group_id = strtoupper(Str::random(15));
        $today = ChecklistDailyTotal::findByPoi(Auth::user()->uid)->today()->first();

        $serious_symptoms = 0;
        $less_common_symptoms = 0;

        if ($today) {

            $group_id = $today->group_id;

            ChecklistDailyItem::group($group_id)->delete();

            foreach ($request->checklist as $checklist) {

                $checklistItems = Checklist::find($checklist);

                if ($checklistItems->symptom_category == 'Serious Symptoms') {
                    $serious_symptoms++;
                } elseif ($checklistItems->symptom_category == 'Less Common Symptoms') {
                    $less_common_symptoms++;
                }

                ChecklistDailyItem::create([
                    'checklist_id' => $checklist,
                    'group_id' => $group_id
                ]);
            }

            $checklistTotal = ChecklistDailyTotal::today()->group($group_id)->first();
            $checklistTotal->serious_symptoms = $serious_symptoms;
            $checklistTotal->less_common_symptoms = $less_common_symptoms;
            $checklistTotal->poi_condition = $this->poiCondition([$serious_symptoms, $less_common_symptoms]);
            $checklistTotal->save();

            $response = [
                'status' => 'danger',
                'message' => 'You re-submit a new health checklist for today.'
            ];

        } else {

            $checklistTotal = new ChecklistDailyTotal;
            $checklistTotal->poi_id = Auth::user()->uid;
            $checklistTotal->serious_symptoms = $serious_symptoms;
            $checklistTotal->less_common_symptoms = $less_common_symptoms;
            $checklistTotal->poi_condition = null;
            $checklistTotal->date_submitted = Carbon::today();
            $checklistTotal->group_id = $group_id;
            $checklistTotal->save();

            foreach ($request->checklist as $checklist) {

                $checklistItems = Checklist::find($checklist);

                if ($checklistItems->symptom_category == 'Serious Symptoms') {
                    $serious_symptoms++;
                } elseif ($checklistItems->symptom_category == 'Less Common Symptoms') {
                    $less_common_symptoms++;
                }

                ChecklistDailyItem::create([
                    'checklist_id' => $checklist,
                    'group_id' => $group_id
                ]);
            }

            $checklistTotal->serious_symptoms = $serious_symptoms;
            $checklistTotal->less_common_symptoms = $less_common_symptoms;
            $checklistTotal->poi_condition = $this->poiCondition([$serious_symptoms, $less_common_symptoms]);
            $checklistTotal->save();

            $response = [
                'status' => 'danger',
                'message' => 'Thank you for submitting your health checklist for today.'
            ];

        }

        return Response::json($response);
    }

    private function poiCondition($data)
    {
        $serious_symptoms = $data[0];
        $less_common_symptoms = $data[1];

        if ($serious_symptoms >= 2) {
            $condition = 'Severe Condition';
        }
        elseif ($less_common_symptoms == 0 && $serious_symptoms == 0) {
            $condition = 'Good Condition';
        }
        elseif ($less_common_symptoms >=4 && $serious_symptoms >= 1) {
            $condition = 'Severe Condition';
        }
        elseif ($less_common_symptoms >=1 && $serious_symptoms >= 1) {
            $condition = 'Mild Condition';
        }
        elseif ($less_common_symptoms >=1 && $serious_symptoms <= 0) {
            $condition = 'Mild Condition';
        }
        elseif ($less_common_symptoms <=4 && $serious_symptoms <= 0) {
            $condition = 'Mild Condition';
        }

        return $condition;
    }
    // DAILY HEALTH CHECKLIST

    public function healthCareInstitution(Request $request)
    {
        if ($request->action == 'set') {

            $patient = HospitalPatient::create([
                'hospital_id' => $request->hci_id,
                'poi_id' => Auth::user()->uid,
                'admit_date' => Carbon::today(),
                'discharge_date' => null,
                'discharge_request' => FALSE,
                'patient_status' => 'ADMITTED',
                'hci_locked' => TRUE,
            ]);

            $message = 'Your data validator has been set. You can now submit your daily health checklist.';

        } else {

            $patient = HospitalPatient::findByPoi(Auth::user()->uid)
            ->hci($request->hci_id)
            ->first();

            $patient->discharge_request = TRUE;
            $patient->save();

            $message = 'Your request has been submitted.';

        }  

        return Response::json(['status'=>'success','message'=>$message]);
    }
   
}