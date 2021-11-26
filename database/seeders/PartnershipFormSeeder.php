<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormBuilder\ExtensionProgramField;

class PartnershipFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'MOA/MOU Code Number',
            'name' => 'moa_code',
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
            'extension_programs_form_id' => 5,
            'label' => 'Nature of Collaboration',
            'name' => 'collab_nature',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 30, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Type of Partnership Institution',
            'name' => 'partnership_type',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 31, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Deliverable/ Desired Output',
            'name' => 'deliverable',
            'placeholder' => null,
            'size' => 'col-md-4',
            'field_type_id' => 5,
            'dropdown_id' => 32, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Name of Organization/ Partner',
            'name' => 'name_of_partner',
            'placeholder' => null,
            'size' => 'col-md-8',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Title of Partnership',
            'name' => 'title_of_partnership',
            'placeholder' => null,
            'size' => 'col-md-12',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Target Beneficiaries',
            'name' => 'beneficiaries',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Validity Period',
            'name' => 'start_date',
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
            'extension_programs_form_id' => 5,
            'label' => '-',
            'name' => 'end_date',
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
            'extension_programs_form_id' => 5,
            'label' => 'Level',
            'name' => 'level',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 5,
            'dropdown_id' => 33, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Name of Contact Person',
            'name' => 'name_of_contact_person',
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
            'extension_programs_form_id' => 5,
            'label' => 'Address of Contact Person',
            'name' => 'address_of_contact_person',
            'placeholder' => null,
            'size' => 'col-md-5',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => 'Telephone No.',
            'name' => 'telephone_number',
            'placeholder' => null,
            'size' => 'col-md-3',
            'field_type_id' => 1,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
            'label' => '',
            'name' => '',
            'placeholder' => null,
            'size' => '',
            'field_type_id' => 12,
            'dropdown_id' => null, 
            'required' => 1,
            'visibility' => 1,
            'order' => 1,
            'is_active' => 1,
        ]);
        ExtensionProgramField::create([
            'extension_programs_form_id' => 5,
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
            'extension_programs_form_id' => 5,
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
