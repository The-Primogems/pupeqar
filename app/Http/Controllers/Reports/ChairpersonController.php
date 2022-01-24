<?php

namespace App\Http\Controllers\Reports;

use App\Models\Dean;
use App\Models\User;
use App\Models\Report;
use App\Models\DenyReason;
use App\Models\SectorHead;
use App\Models\Chairperson;
use Illuminate\Http\Request;
use App\Models\FacultyResearcher;
use App\Models\FacultyExtensionist;
use App\Models\Maintenance\College;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\Department;
use App\Models\Authentication\UserRole;

class ChairpersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //role and department/ college id
        $roles = UserRole::where('user_id', auth()->id())->pluck('role_id')->all();
        $departments = [];
        $colleges = [];
        $sectors = [];
        $departmentsResearch = [];
        $departmentsExtension = [];
        
        if(in_array(5, $roles)){
            $departments = Chairperson::where('chairpeople.user_id', auth()->id())->select('chairpeople.department_id', 'departments.code')
                                        ->join('departments', 'departments.id', 'chairpeople.department_id')->get();
        }
        if(in_array(6, $roles)){
            $colleges = Dean::where('deans.user_id', auth()->id())->select('deans.college_id', 'colleges.code')
                            ->join('colleges', 'colleges.id', 'deans.college_id')->get();
        }
        if(in_array(7, $roles)){
            $sectors = SectorHead::where('sector_heads.user_id', auth()->id())->select('sector_heads.sector_id', 'sectors.code')
                        ->join('sectors', 'sectors.id', 'sector_heads.sector_id')->get();
        }
        if(in_array(10, $roles)){
            $departmentsResearch = FacultyResearcher::where('faculty_researchers.user_id', auth()->id())
                                        ->select('faculty_researchers.department_id', 'departments.code')
                                        ->join('departments', 'departments.id', 'faculty_researchers.department_id')->get();
        }
        if(in_array(11, $roles)){
            $departmentsExtension = FacultyExtensionist::where('faculty_extensionists.user_id', auth()->id())
                                        ->select('faculty_extensionists.department_id', 'departments.code')
                                        ->join('departments', 'departments.id', 'faculty_extensionists.department_id')->get();
        }

        $reportsToReview = collect();
        $employees = collect();
        
        foreach ($departments as $row){
            $tempReports = Report::select('reports.*', 'departments.name as department_name', 'report_categories.name as report_category', 'users.last_name', 'users.first_name','users.middle_name', 'users.suffix')
                ->join('departments', 'reports.department_id', 'departments.id')
                ->join('report_categories', 'reports.report_category_id', 'report_categories.id')
                ->join('users', 'reports.user_id', 'users.id')
                ->where('department_id', $row->department_id)->where('chairperson_approval', null)->get();

                        
            $tempEmployees = Report::join('users', 'reports.user_id', 'users.id')
                ->where('reports.department_id', $row->department_id)
                ->select('users.last_name', 'users.first_name', 'users.suffix', 'users.middle_name')
                ->where('reports.chairperson_approval', null)
                ->distinct()
                ->orderBy('users.last_name')
                ->get();
            
            $reportsToReview = $reportsToReview->concat($tempReports);
            $employees = $employees->concat($tempEmployees);
        }
        //filternotyetreceived by researcher and/or extensionist
        $tempReports = collect();
        foreach($reportsToReview as $report){
            if($report->report_category_id >= 1 || $report->report_category_id <= 7){
                if($report->researcher_approval === 1){
                    $tempReports = $tempReports->concat($report);
                }
            }
            if($report->report_category_id == 12){
                if($report->extensionist_approval === 1){
                    $tempReports = $tempReports->concat($report);
                }
            }
        }
        $reportsToReview = $tempReports;
        
        $college_names = [];
        $department_names = [];
        foreach($reportsToReview as $row){
            $temp_college_name = College::select('name')->where('id', $row->college_id)->first();
            $temp_department_name = Department::select('name')->where('id', $row->department_id)->first();


            if($temp_college_name == null)
                $college_names[$row->id] = '-';
            else
                $college_names[$row->id] = $temp_college_name;
            if($temp_department_name == null)
                $department_names[$row->id] = '-';
            else
                $department_names[$row->id] = $temp_department_name;
        }
        

        return view('reports.chairpersons.index', compact('reportsToReview', 'roles', 'departments', 'colleges', 'employees', 'college_names', 'department_names', 'sectors', 'departmentsResearch','departmentsExtension'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accept($report_id){
        Report::where('id', $report_id)->update(['chairperson_approval' => 1]);

        return redirect()->route('chairperson.index')->with('success', 'Report Accepted');
    
    }
    public function rejectCreate($report_id){
        return view('reports.chairpersons.reject', compact('report_id'));
    }

    public function reject($report_id, Request $request){
        DenyReason::create([
            'report_id' => $report_id,
            'user_id' => auth()->id(),
            'position_name' => 'chairperson',
            'reason' => $request->input('reason'),
        ]);

        Report::where('id', $report_id)->update([
            'chairperson_approval' => 0
        ]);
        return redirect()->route('chairperson.index')->with('success', 'Report Denied');
    }

    public function relay($report_id){
        Report::where('id', $report_id)->update(['chairperson_approval' => 0]);
        return redirect()->route('submissions.denied.index')->with('deny-success', 'Report Denial has been sent');
    }

    public function undo($report_id){
        Report::where('id', $report_id)->update(['chairperson_approval' => null]);
        return redirect()->route('submissions.denied.index')->with('deny-success', 'Success. You can now review it again.');
    }

    public function acceptSelected(Request $request){
        $reportIds = $request->input('report_id');

        foreach($reportIds as $id){
            Report::where('id', $id)->update(['chairperson_approval' => 1]);
        }
        return redirect()->route('chairperson.index')->with('success', 'Report/s Approved Successfully');
    }

    public function denySelected(Request $request){
        $reportIds = $request->input('report_id');
        return view('reports.chairpersons.reject-select', compact('reportIds'));
    }

    public function rejectSelected(Request $request){
        $reportIds = $request->input('report_id');
        foreach($reportIds as $id){
            if($request->input('reason_'.$id) == null)
                continue;
            Report::where('id', $id)->update(['chairperson_approval' => 0]);
            DenyReason::create([
                'report_id' => $id,
                'user_id' => auth()->id(),
                'position_name' => 'chairperson',
                'reason' => $request->input('reason_'.$id),
            ]);
        }
        return redirect()->route('chairperson.index')->with('success', 'Report/s Denied Successfully');

    }

}
