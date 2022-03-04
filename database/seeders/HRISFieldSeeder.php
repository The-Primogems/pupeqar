<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maintenance\HRISField;

class HRISFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HRISField::truncate();
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Degree/Program',
            'name' => 'degree',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 2,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Name of School',
            'name' => 'school_name',
            'placeholder' => null,
            'size' => 'col-md-8',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 2,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Program Accreditation Level/ World Ranking/ COE or COD',
            'name' => 'program_level',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 49, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Type of Support',
            'name' => 'support_type',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 50, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Name of Sponsor/Agency/Organization',
            'name' => 'sponsor_name',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Amount',
            'name' => 'amount',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 3,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'From',
            'name' => 'from',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 2,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'To',
            'name' => 'to',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 2,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Status',
            'name' => 'status',
            'placeholder' => null,
            'size' => 'col-md-12',
            'field_type_id' => 5,
            'dropdown_id' => 51, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Number of Units Earned',
            'name' => 'units_earned',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 2,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Number of Units Currently Enrolled',
            'name' => 'units_enrolled',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 2,
            'dropdown_id' => null, 
            'required' => 0,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'College/Campus/Branch/Office to commit the accomplishment',
            'name' => 'college_id',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 12,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Department to commit the accomplishment',
            'name' => 'department_id',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 13,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Description of Supporting Documents',
            'name' => 'description',
            'placeholder' => "",
            'size' => 'col-md-12',
            'field_type_id' => 16,
            'dropdown_id' => null, 
            'required' => 0,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        HRISField::create([
            'h_r_i_s_form_id' => 1,
            'label' => 'Document Upload',
            'name' => 'document',
            'placeholder' => null,
            'size' => 'col-md-12',
            'field_type_id' => 10,
            'dropdown_id' => null, 
            'required' => 0,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
    }
}
