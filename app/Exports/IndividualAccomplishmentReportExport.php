<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Models\Maintenance\College;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\Department;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Maintenance\GenerateTable;
use App\Models\Maintenance\GenerateColumn;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class IndividualAccomplishmentReportExport implements FromView, WithEvents
{
    function __construct($source_type, $reportFormat, $source_generate, $year_generate, $quarter_generate, $cbco, $id, $table_columns, $table_contents, $table_format) {
        $this->source_type = $source_type;
        $this->report_format = $reportFormat;
        $this->source_generate = $source_generate;
        $this->year_generate = $year_generate;
        $this->quarter_generate = $quarter_generate;
        $this->cbco = $cbco;
        $this->id = $id;
        $this->table_columns = $table_columns;
        $this->table_contents = $table_contents;
        $this->table_format = $table_format;

        $user = User::where('id', auth()->id())->first();
        $this->name_user = $user->last_name.', '.$user->first_name.' '.$user->middle_name; 
    }

    public function view(): View
    {
        $source_type = $this->source_type;
        $reportFormat = $this->report_format;
        $source_generate = $this->source_generate;
        $year_generate = $this->year_generate;
        $quarter_generate = $this->quarter_generate;
        $id = $this->id;
        $table_format = '';
        $table_columns = '';
        $table_contents = '';
        $data = '';
        $source_type = '';
        
        if($reportFormat == "academic"){
            if($source_generate == "department"){
                $source_type = "department";
                $department_id = $id;
                $data = Department::where('id', $department_id)->first();
                $table_format = GenerateTable::where('type_id', 2)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }

                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else
                        $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                            ->where('reports.department_id', $department_id)
                            ->where('reports.chairperson_approval', 1)
                            ->whereYear('reports.updated_at', $year_generate)
                            ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                            ->join('users', 'users.id', 'reports.user_id')
                            ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                            ->get()->toArray();
                }

            }
            elseif($source_generate == "college"){
                $source_type = "college";
                $college_id = $id;
                $data = College::where('id', $college_id)->first();
                $table_format = GenerateTable::where('type_id', 2)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }
                
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else
                        $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                            ->where('reports.college_id', $college_id)
                            ->where('reports.dean_approval', 1)
                            ->whereYear('reports.updated_at', $year_generate)
                            ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                            ->join('users', 'users.id', 'reports.user_id')
                            ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                            ->get()->toArray();
                }
            }
            elseif($source_generate == "my"){
                $source_type = "individual";
                $user_id = $id;
                $data = User::where('id', $user_id)->select('users.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as name"))->first();
                $table_format = GenerateTable::where('type_id', 2)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }
                
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else
                        $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                            ->whereYear('reports.updated_at', $year_generate)
                            ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                            ->where('reports.user_id', $user_id)
                            ->join('users', 'users.id', 'reports.user_id')
                            ->where('reports.college_id', $this->cbco)
                            // ->join('departments', 'departments.id', 'reports.department_id')
                            // ->join('colleges', 'colleges.id', 'reports.college_id')
                            ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                            ->get()->toArray();
                }
            }
            elseif($source_generate == "research"){
                $source_type = "department";
                $department_id = $id;
                $data = Department::where('id', $department_id)->first();
                $table_format = GenerateTable::where('type_id', 2)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }

                $research_reports = [1, 2, 3, 4, 5, 6, 7, 8];
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else{
                        if(in_array($format->report_category_id, $research_reports))
                            $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                                ->where('reports.department_id', $department_id)
                                ->where('reports.researcher_approval', 1)
                                ->whereYear('reports.updated_at', $year_generate)
                                ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                                ->join('users', 'users.id', 'reports.user_id')
                                ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                                ->get()->toArray();
                        else
                            $table_contents[$format->id] = [];
                    }
                }
            }
            elseif($source_generate == "extension"){
                $source_type = "department";
                $department_id = $id;
                $data = Department::where('id', $department_id)->first();
                $table_format = GenerateTable::where('type_id', 2)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }

                $extension_reports = [9, 10, 11, 12, 13, 14];
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else{
                        if(in_array($format->report_category_id, $extension_reports))
                            $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                                ->where('reports.department_id', $department_id)
                                ->where('reports.extensionist_approval', 1)
                                ->whereYear('reports.updated_at', $year_generate)
                                ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                                ->join('users', 'users.id', 'reports.user_id')
                                ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                                ->get()->toArray();
                        else
                            $table_contents[$format->id] = [];
                    }
                }
            }
        }
        elseif($reportFormat == "admin"){
            if($source_generate == "department"){
                $source_type = "department";
                $department_id = $id;
                $data = Department::where('id', $department_id)->first();
                $table_format = GenerateTable::where('type_id', 1)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }
                
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else
                        $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                            ->where('reports.department_id', $department_id)
                            ->where('reports.chairperson_approval', 1)
                            ->whereYear('reports.updated_at', $year_generate)
                            ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                            ->join('users', 'users.id', 'reports.user_id')
                            ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                            ->get()->toArray();
                }
            }
            elseif($source_generate == "college"){
                $source_type = "college";
                $college_id = $id;
                $data = College::where('id', $college_id)->first();
                $table_format = GenerateTable::where('type_id', 1)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }
                
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else
                        $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                            ->where('reports.college_id', $college_id)
                            ->where('reports.dean_approval', 1)
                            ->whereYear('reports.updated_at', $year_generate)
                            ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                            ->join('users', 'users.id', 'reports.user_id')
                            ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                            ->get()->toArray();
                }
            }
            elseif($source_generate == "my"){
                $source_type = "individual";
                $user_id = $id;
                $data = User::where('id', $user_id)->select('users.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as name"))->first();
                $table_format = GenerateTable::where('type_id', 1)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }
                
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else
                        $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                            ->whereYear('reports.updated_at', $year_generate)
                            ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                            ->where('reports.user_id', $user_id)
                            ->where('reports.college_id', $this->cbco)
                            ->join('users', 'users.id', 'reports.user_id')
                            ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                            ->get()->toArray();
                }
            }
            elseif($source_generate == "research"){
                $source_type = "department";
                $department_id = $id;
                $data = Department::where('id', $department_id)->first();
                $table_format = GenerateTable::where('type_id', 1)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }

                $research_reports = [1, 2, 3, 4, 5, 6, 7, 8];
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else{
                        if(in_array($format->report_category_id, $research_reports))
                            $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                                ->where('reports.department_id', $department_id)
                                ->where('reports.researcher_approval', 1)
                                ->whereYear('reports.updated_at', $year_generate)
                                ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                                ->join('users', 'users.id', 'reports.user_id')
                                ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                                ->get()->toArray();
                        else
                            $table_contents[$format->id] = [];
                    }
                }
            }
            elseif($source_generate == "extension"){
                $source_type = "department";
                $department_id = $id;
                $data = Department::where('id', $department_id)->first();
                $table_format = GenerateTable::where('type_id', 1)->get();
                $table_columns = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0")
                        $table_columns[$format->id] = [];
                    else
                        $table_columns[$format->id] = GenerateColumn::where('table_id', $format->id)->orderBy('order')->get()->toArray();
                }

                $extension_reports = [9, 10, 11, 12, 13, 14];
                $table_contents = [];
                foreach ($table_format as $format){
                    if($format->is_table == "0" || $format->report_category_id == null)
                        $table_contents[$format->id] = [];
                    else{
                        if(in_array($format->report_category_id, $extension_reports))
                            $table_contents[$format->id] = Report::where('reports.report_category_id', $format->report_category_id)
                                ->where('reports.department_id', $department_id)
                                ->where('reports.extensionist_approval', 1)
                                ->whereYear('reports.updated_at', $year_generate)
                                ->where(DB::raw('QUARTER(reports.updated_at)'), $quarter_generate)
                                ->join('users', 'users.id', 'reports.user_id')
                                ->select('reports.*', DB::raw("CONCAT(COALESCE(users.last_name, ''), ', ', COALESCE(users.first_name, ''), ' ', COALESCE(users.middle_name, ''), ' ', COALESCE(users.suffix, '')) as faculty_name"))
                                ->get()->toArray();
                        else
                            $table_contents[$format->id] = [];
                    }
                }
            }
        }

        $this->table_format = $table_format;
        $this->table_columns = $table_columns;
        $this->table_contents = $table_contents;
        return view('reports.generate.example', compact('table_format', 'table_columns', 'table_contents', 'source_type', 'data', 'reportFormat', 'source_generate', 'year_generate', 'quarter_generate', 'id'));
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(Aftersheet $event) {
                $event->sheet->getSheetView()->setZoomScale(70);
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                // $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setSize(12);
                $event->sheet->getDefaultColumnDimension()->setWidth(33);
                // $event->sheet->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
                $event->sheet->mergeCells('A1:G1');
                if ($this->source_type == "individual")
                    if ($this->report_format == "academic")
                    {   
                        $event->sheet->setCellValue('A1', 'FACULTY INDIVIDUAL ACCOMPLISHMENT REPORT');
                        $event->sheet->getStyle('A1')->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'size' => 20,
                            ]
                        ]);
                    }
                    else {
                        $event->sheet->setCellValue('A1', 'ADMIN INDIVIDUAL ACCOMPLISHMENT REPORT');
                        $event->sheet->getStyle('A1')->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'size' => 20,
                            ]
                        ]);
                    }
                else {
                    $event->sheet->setCellValue('A1', 'CONSOLIDATED ACCOMPLISHMENT REPORT');
                    $event->sheet->getStyle('A1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 20,
                        ]
                    ]);
                }

                $event->sheet->getStyle('A1:Z500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                // $event->sheet->getRowDimension('1')->setRowHeight(26.25);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('B2:C2');
                $event->sheet->setCellValue('B2', 'COLLEGE/BRANCH/CAMPUS/OFFICE:');
                $event->sheet->getStyle('B2')->applyFromArray([
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ]);
                $college = College::where('id', $this->cbco)->select('name')->first();
                $event->sheet->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('D2:F2');
                $event->sheet->setCellValue('D2', $college->name);
                $event->sheet->getStyle('D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D2:F2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getStyle('D2')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);

                // Name
                $event->sheet->setCellValue('C3', 'NAME:');
                $event->sheet->getStyle('C3')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);
                $event->sheet->getStyle('C3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->mergeCells('D3:F3');
                $event->sheet->setCellValue('D3', $this->name_user);
                $event->sheet->getStyle('D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D3:F3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getStyle('D3')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);

                $event->sheet->setCellValue('C4', 'QUARTER:');
                $event->sheet->getStyle('C4')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);
                $event->sheet->getStyle('C4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->setCellValue('D4', $this->quarter_generate);
                $event->sheet->getStyle('D4')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);
                $event->sheet->getStyle('D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('D4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $event->sheet->setCellValue('E4', 'CALENDAR YEAR:');
                $event->sheet->getStyle('E4')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);
                $event->sheet->getStyle('E4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->setCellValue('F4', $this->year_generate);
                $event->sheet->getStyle('F4')->applyFromArray([
                    'font' => [
                        'size' => 16,
                    ]
                ]);
                $event->sheet->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $count = 7;
                $table_format = $this->table_format;
                $table_columns = $this->table_columns;
                $table_contents = $this->table_contents;
                foreach($table_format as $format) {
                    if($format->is_table == '0'){
                        
                        //title
                        $event->sheet->mergeCells('A'.$count.':K'.$count);
                        $event->sheet->getStyle('A'.$count)->getAlignment()->setWrapText(true);
                        $event->sheet->getStyle('A'.$count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FFC00000");
                        $event->sheet->getStyle('A'.$count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                        $event->sheet->getStyle('A'.$count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getRowDimension($count)->setRowHeight(30);
                        $event->sheet->getStyle('A'.$count)->applyFromArray([
                            'font' => [
                                'name' => 'Arial',
                            ]
                        ]);
                        $count++;

                    }
                    elseif($format->is_table == '1') {
                        $length = count($table_columns[$format->id]);
                        if ($length == null){
                            $length = 2;
                        }
                        else{
                            $length = $length+2;
                        }
                        $letter = Coordinate::stringFromColumnIndex($length);

                        // title
                        $event->sheet->mergeCells('A'.$count.':'.$letter.$count);
                        $event->sheet->getStyle('A'.$count)->getAlignment()->setWrapText(true);
                        // $event->sheet->getStyle('A'.$count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FF800000");
                        $event->sheet->getStyle('A'.$count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FFFFC000");
                        
                        // $event->sheet->getStyle('A'.$count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                        $event->sheet->getStyle('A'.$count)->getFont()->getColor()->setARGB('FFC00000');

                        $event->sheet->getRowDimension($count)->setRowHeight(30);
                        $event->sheet->getStyle('A'.$count)->applyFromArray([
                            'font' => [
                                'name' => 'Arial',
                            ]
                        ]);
                        $count++;

                        //column
                        $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getAlignment()->setWrapText(true);
                        $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FF203764");
                        $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                        $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getStyle('A'.$count.':'.$letter.$count)->applyFromArray([
                            'font' => [
                                'name' => 'Arial',
                                'bold' => true, 
                                'size' => 14
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => 'FF515256'],
                                ],
                            ],
                        ]);
                        $count++;

                        //contents
                        foreach($table_contents[$format->id] as $contents){
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getAlignment()->setWrapText(true);
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FFD9E1F2");
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => 'FF515256'],
                                    ],
                                ],
                            ]);
                            $count++;
                        }

                        if($table_contents[$format->id] == null){
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getAlignment()->setWrapText(true);
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB("FFD9E1F2");
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $event->sheet->getStyle('A'.$count.':'.$letter.$count)->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => 'FF515256'],
                                    ],
                                ],
                            ]);
                            $count++;
                        }

                        $footers = json_decode($format->footers);
                        if ($footers != null){
                            foreach ($footers as $footer){
                                $event->sheet->getStyle('A'.$count)->applyFromArray([
                                    'font' => [
                                        'name' => 'Arial',
                                    ]
                                ]);
                                $count++;
                            }
                        }
                        
                        $count += 2;
                    }
                }
                $event->sheet->getStyle('A'.$count)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
                $event->sheet->getStyle('C'.$count)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
                $event->sheet->getStyle('E'.$count)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
                $event->sheet->setCellValue('A'.$count, 'Prepared by:');
                $event->sheet->setCellValue('C'.$count, 'Certified correct:');
                $event->sheet->setCellValue('E'.$count, 'Approved by:');
                $count = $count + 4;
                $event->sheet->setCellValue('A'.$count, 'Name and Signature of Employee');
                $event->sheet->setCellValue('C'.$count, 'Name and Signature of Head of Office');
                $event->sheet->setCellValue('E'.$count, 'Name and Signature of Sector Head');

                $event->sheet->getStyle('A'.$count)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getStyle('C'.$count)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getStyle('E'.$count)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            }

        ];
    }
}
