<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Research;
use App\Models\Invention;
use App\Models\Syllabus;
use App\Models\Reference;
use App\Models\ExpertServiceConsultant;
use App\Models\ExpertServiceConference;
use App\Models\ExpertServiceAcademic;
use App\Models\ExtensionService;
use App\Models\Partnership;
use App\Models\Mobility;
use App\Models\Request as RequestModel;
use App\Models\StudentAward;
use App\Models\StudentTraining;
use App\Models\ViableProject;
use App\Models\CollegeDepartmentAward;
use App\Models\TechnicalExtension;
use App\Models\OutreachProgram;
use App\Models\Report;
use App\Models\Chairperson;
use App\Models\Dean;
use App\Models\SectorHead;
use App\Models\Authentication\UserRole;

class DashboardController extends Controller
{
    public function index() {
        $currentMonth = date('m');

        $quarter = 0;
        if ($currentMonth <= 3 && $currentMonth >= 1) {
            $quarter = 1;
            $totalReports = Report::whereMonth('report_date', '>=', 1)->whereMonth('report_date', '<=', 3)
                    ->where('user_id', auth()->id())->whereYear('report_date', date('Y'))->count();
        if ($currentMonth <= 6 && $currentMonth >= 4) {
        $quarter = 2;
        $totalReports = Report::whereMonth('report_date', '>=', 4)->whereMonth('report_date', '<=', 6)
                ->where('user_id', auth()->id())->whereYear('report_date', date('Y'))->count();
        }
        if ($currentMonth <= 9 && $currentMonth >= 7) {
        $totalReports = Report::whereMonth('report_date', '>=', 7)->whereMonth('report_date', '<=', 9)
                ->where('user_id', auth()->id())->whereYear('report_date', date('Y'))->count();
        }
        if ($currentMonth <= 12 && $currentMonth >= 10) {
        $quarter = 4;
        $totalReports = Report::whereMonth('report_date', '>=', 10)->whereMonth('report_date', '<=', 12)
                ->where('user_id', auth()->id())->whereYear('report_date', date('Y'))->count();
        }

        //No. of accomplishments received by Chairperson
        $is_faculty_admin = UserRole::where('user_roles.user_id', auth()->id())
        ->whereIn('user_roles.role_id', [1, 2, 3, 4])
        ->first();
        $is_cp = UserRole::where('user_roles.user_id', auth()->id())->where('user_roles.role_id', 5)->first();
        $is_dean = UserRole::where('user_roles.user_id', auth()->id())->where('user_roles.role_id', 6)->first();
        $is_vp = UserRole::where('user_roles.user_id', auth()->id())->where('user_roles.role_id', 7)->first();
        $is_ipqmso = UserRole::where('user_roles.user_id', auth()->id())->where('user_roles.role_id', 8)->first();
        $is_sAdmin = UserRole::where('user_roles.user_id', auth()->id())->where('user_roles.role_id', 9)->first();

        if ($is_faculty_admin) {
        $department_reported = Report::where('user_id', auth()->id())->distinct('department_id')->count();
        $cbco_reported = Report::where('user_id', auth()->id())->distinct('college_id')->count();
        //     dd($department_reported);
        return view('dashboard', compact('quarter', 'totalReports', 'department_reported', 'cbco_reported'));
        }
        elseif ($is_cp) {
        $departments = Chairperson::where('chairpeople.user_id', auth()->id())
                ->join('departments', 'departments.id', 'chairpeople.department_id')
                ->pluck('chairpeople.department_id')->all();
                // dd($departments);
        $chairpersonReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('reports.chairperson_approval', 1)
                ->whereIn('reports.department_id', [$departments])
                ->whereYear('reports.report_date', date('Y'))->count();
        $chairpersonNotReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('reports.chairperson_approval', null)
                ->whereIn('reports.department_id', [$departments])
                ->whereYear('reports.report_date', date('Y'))
        //check for researcher and extensionist                   
                ->where('reports.researcher_approval', 1)
                ->orWhere('reports.extensionist_approval', 1)
                ->count();
        // $chairpersonReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
        //         ->where('chairperson_approval', 0)
        //         ->whereIn('department_id', [$departments])
        //         ->whereYear('report_date', date('Y'))->count();
        // $deanReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
        //         ->where('dean_approval', 0)
        //         ->where('user_id', auth()->id())
        //         ->whereYear('report_date', date('Y'))->count();
        return view('dashboard', compact('quarter', 'totalReports', 'chairpersonReceived', 'chairpersonNotReceived'));

        }
        elseif ($is_dean) {
        $colleges = Dean::where('deans.user_id', auth()->id())
                        ->join('colleges', 'colleges.id', 'deans.college_id')->pluck('deans.college_id')->all();
                        // dd($colleges);
        $deanReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('dean_approval', 1)
                ->whereIn('college_id', [$colleges])
                ->whereYear('report_date', date('Y'))->count();
        $deanNotReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('chairperson_approval', 1)
                ->where('dean_approval', null)
                ->whereIn('college_id', [$colleges])
                ->whereYear('report_date', date('Y'))->count();
        // $deanReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
        //         ->where('dean_approval', 0)
        //         ->whereIn('college_id', [$colleges])
        //         ->whereYear('report_date', date('Y'))->count();
        // $sectorReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
        //         ->where('sector_approval', 0)
        //         ->where('user_id', auth()->id())
        //         ->whereYear('report_date', date('Y'))->count();
        return view('dashboard', compact('quarter', 'totalReports', 'deanReceived', 'deanNotReceived'));

        }
        elseif ($is_vp) {
        $sectors = SectorHead::where('sector_heads.user_id', auth()->id())
                        ->join('sectors', 'sectors.id', 'sector_heads.sector_id')->pluck('sector_heads.sector_id')->all();
                        // dd($sectors);
        $vpReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('reports.sector_approval', 1)
                ->whereIn('reports.sector_id', [$sectors])
                ->whereYear('reports.report_date', date('Y'))->count();
        $vpNotReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('chairperson_approval', 1)
                ->where('dean_approval', 1)
                ->where('sector_approval', null)
                ->whereIn('sector_id', [$sectors])
                ->whereYear('report_date', date('Y'))->count();
        // $vpReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
        //         ->where('sector_approval', 0)
        //         ->whereIn('sector_id', [$sectors])
        //         ->whereYear('report_date', date('Y'))->count();
        // $ipqmsoReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
        //         ->where('ipqmso_approval', 0)
        //         ->where('user_id', auth()->id())
        //         ->whereYear('report_date', date('Y'))->count();
        return view('dashboard', compact('quarter', 'totalReports', 'vpReceived', 'vpNotReceived'));

        }
        elseif ($is_ipqmso) {
        $ipqmsoReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('ipqmso_approval', 1)
                ->whereYear('report_date', date('Y'))->count();
        $ipqmsoNotReceived = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('ipqmso_approval', null)
                ->whereYear('report_date', date('Y'))->count();
        $ipqmsoReturned = Report::where(DB::raw('QUARTER(reports.report_date)'), $quarter)
                ->where('ipqmso_approval', 0)
                ->whereYear('report_date', date('Y'))->count();
        return view('dashboard', compact('quarter', 'totalReports', 'ipqmsoReceived', 'ipqmsoNotReceived', 'ipqmsoReturned'));

        }
        }

        return view('dashboard', compact('quarter', 'totalReports', 'is_sAdmin'));
    }
}
