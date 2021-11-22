<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormBuilder\ExtensionProgramField;

class ExtensionServiceFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Level',
            'name' => 'level',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 23, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Status',
            'name' => 'status',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 24, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Nature of Involvement',
            'name' => 'nature_of_involvement',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 25, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Classification',
            'name' => 'classification',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 26, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Type',
            'name' => 'type',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 27, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Title of Extension Program',
            'name' => 'title_of_extension_program',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Title of Extension Project',
            'name' => 'title_of_extension_project',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Title of Extension Activity',
            'name' => 'title_of_extension_activity',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Type of Funding',
            'name' => 'type_of_funding',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 5,
            'dropdown_id' => 28, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Amount of Funding',
            'name' => 'amount_of_funding',
            'placeholder' => '0.00',
            'size' => 'col-md-3',
            'field_type_id' => 3,
            'dropdown_id' => null, 
            'required' => 0,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Funding Agency',
            'name' => 'funding_agency',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 0,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'From',
            'name' => 'from',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 4,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'To',
            'name' => 'to',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 4,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'No. of Trainess/Beneficiaries',
            'name' => 'no_of_trainees_or_beneficiaries',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 2,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Total No. of Hours',
            'name' => 'total_no_of_hours',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 11,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Classification of Trainees/Beneficiaries',
            'name' => 'classification_of_trainees_or_beneficiaries',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 29, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Place/Venue',
            'name' => 'place_or_venue',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Keywords',
            'name' => 'keywords',
            'placeholder' => null,
            'size' => 'col-md-6',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
            'label' => 'Description of Supporting Documents',
            'name' => 'description',
            'placeholder' => null,
            'size' => 'col-md-12',
            'field_type_id' => 8,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);

        ExtensionProgramField::create([
            'extension_programs_form_id' => 4,
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
