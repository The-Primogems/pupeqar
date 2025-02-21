<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Maintenance\College;
use App\Models\Maintenance\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Department::truncate();

        $db_ext = DB::connection('mysql_external');
        $allDepartments = $db_ext->select(" EXEC GetDepartment");
        $collegeHRISCodes = College::pluck('hris_code')->all();

        foreach ($allDepartments as $row) {
            if($row->IsActive == "Y"){
                if($row->RootID == "0"){
                    if(in_array($row->DepartmentID, $collegeHRISCodes)){
                        Department::create([
                            'name' => $row->Department,
                            'code' => $row->DepartmentCode,
                            'hris_code' => $row->DepartmentID,
                            'college_id' => College::where('hris_code', $row->DepartmentID)->pluck('id')->first()
                        ]);
                    }
                }
                else{
                    if($row->Level == "1"){
                        if(in_array($row->DepartmentID, $collegeHRISCodes)){
                            Department::create([
                                'name' => $row->Department,
                                'code' => $row->DepartmentCode,
                                'hris_code' => $row->DepartmentID,
                                'college_id' => College::where('hris_code', $row->DepartmentID)->pluck('id')->first()
                            ]);
                        }
                    }
                    else{
                        if(in_array($row->RootID, $collegeHRISCodes)){
                            Department::create([
                                'name' => $row->Department,
                                'code' => $row->DepartmentCode,
                                'hris_code' => $row->DepartmentID,
                                'college_id' => College::where('hris_code', $row->RootID)->pluck('id')->first()
                            ]);
                        }
                    }
                }

            }
            
        }
    }
}
