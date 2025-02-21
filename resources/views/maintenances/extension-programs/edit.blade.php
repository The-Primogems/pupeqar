<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Extension Program Fields Manager') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('maintenances.navigation-bar')
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <h4>{{ $extension_program_form->label }} Field > {{ $extension_program_field->label }}</h4>
                                <hr>
                            </div>
                            {{-- ADD Fields --}}
                            <div class="col-md-12">
                                <a href="{{ route('extension-program-forms.show', $extension_program_form->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                </a>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <form action="{{ route('extension-program-forms.extension-program-fields.update', [$extension_program_form->id, $extension_program_field->id]) }}" id="field_form" class="needs-validation" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- Name Input --}}
                                            <div class="form-group">
                                                <x-jet-label value="{{ __('Label') }}" />
                            
                                                <input class="form-control" type="text" id="label" name="label" value="{{ $extension_program_field->label }}" required>
                                                        
                                                <div class="invalid-feedback">
                                                    This is required. 
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-md-12">
                                            {{-- Field Name Input --}}
                                            <div class="form-group">
                                                <x-jet-label value="{{ __('Column Name') }}" />
                            
                                                <input class="form-control" type="text" id="field_name" name="field_name" value="{{ $extension_program_field->name }}" disabled required>
                                                        
                                                <div class="invalid-feedback">
                                                    This is required. 
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-md-6">
                                            {{-- Field Size Input --}}
                                            <div class="form-group">
                                                <x-jet-label value="{{ __('Field Size') }}" />
                        
                                                <select name="size" id="size" class="form-control custom-select" required>
                                                    <option value="col-md-12" {{ ($extension_program_field->size === 'col-md-12')? 'selected': '' }}>col-md-12</option>
                                                    <option value="col-md-11" {{ ($extension_program_field->size === 'col-md-11')? 'selected': '' }}>col-md-11</option>
                                                    <option value="col-md-10" {{ ($extension_program_field->size === 'col-md-10')? 'selected': '' }}>col-md-10</option>
                                                    <option value="col-md-9" {{ ($extension_program_field->size === 'col-md-9')? 'selected': '' }}>col-md-9</option>
                                                    <option value="col-md-8" {{ ($extension_program_field->size === 'col-md-8')? 'selected': '' }}>col-md-8</option>
                                                    <option value="col-md-7" {{ ($extension_program_field->size === 'col-md-7')? 'selected': '' }}>col-md-7</option>
                                                    <option value="col-md-6" {{ ($extension_program_field->size === 'col-md-6')? 'selected': '' }}>col-md-6</option>
                                                    <option value="col-md-5" {{ ($extension_program_field->size === 'col-md-5')? 'selected': '' }}>col-md-5</option>
                                                    <option value="col-md-4" {{ ($extension_program_field->size === 'col-md-4')? 'selected': '' }}>col-md-4</option>
                                                    <option value="col-md-3" {{ ($extension_program_field->size === 'col-md-3')? 'selected': '' }}>col-md-3</option>
                                                    <option value="col-md-2" {{ ($extension_program_field->size === 'col-md-2')? 'selected': '' }}>col-md-2</option>
                                                    <option value="col-md-1" {{ ($extension_program_field->size === 'col-md-1')? 'selected': '' }}>col-md-1</option>
                                                </select>
                        
                                                <div class="invalid-feedback">
                                                    This is required. 
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-md-6">
                                            {{-- Field Type --}}
                                            <div class="form-group">
                                                <x-jet-label value="{{ __('Field Type') }}" />
                
                                                <select name="field_type" id="field_type" class="form-control custom-select" disabled required>
                                                    <option value="" disabled>Choose...</option>
                                                    @foreach ($fieldtypes as $fieldtype)
                                                    <option value="{{ $fieldtype->id }}" {{ ($extension_program_field->field_type_id === $fieldtype->id)? 'selected': '' }} class="{{ $fieldtype->name }}">{{ $fieldtype->name }}</option>
                                                    @endforeach
                                                </select>
                
                                                <div class="invalid-feedback">
                                                    This is required. 
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-md-12" id="dropdown_field">
                                            {{-- Dropdown --}}
                                            <div class="form-group">
                                                <x-jet-label value="{{ __('Dropdown') }}" />
                
                                                <select name="dropdown" id="dropdown" class="form-control custom-select" disabled>
                                                    <option value="" selected disabled>Choose...</option>
                                                    @foreach ($dropdowns as $dropdown)
                                                    <option value="{{ $dropdown->id }}" {{ ($extension_program_field->dropdown_id === $dropdown->id)? 'selected': '' }}>{{ $dropdown->name }}</option>
                                                    @endforeach
                                                </select>
                
                                                <div class="invalid-feedback">
                                                    This is required. 
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-md-12" id="placeholderfield">
                                            {{-- Field Placeholder Input --}}
                                            <div class="form-group">
                                                <x-jet-label value="{{ __('Placeholder') }}" />
                            
                                                <input class="form-control" type="text" id="placeholder" value="{{ $extension_program_field->placeholder }}" name="placeholder">
                                                        
                                                <div class="invalid-feedback">
                                                    This is required. 
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-md-12">
                                            {{-- Required --}}
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="1" {{ ($extension_program_field->required === 1)? 'checked' : '' }} name="required" id="required">
                                                <label class="form-check-label" for="required">
                                                    Required
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="visibility" {{ ($extension_program_field->visibility === 1)? 'checked' : '' }} id="default" required>
                                                <label class="form-check-label" for="default">
                                                    Default
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="visibility" {{ ($extension_program_field->visibility === 2)? 'checked' : '' }} id="readonly" required>
                                                <label class="form-check-label" for="readonly">
                                                    Read-Only
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="visibility" {{ ($extension_program_field->visibility === 3)? 'checked' : '' }} id="disabled" required>
                                                <label class="form-check-label" for="disabled">
                                                    Disabled
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="visibility" {{ ($extension_program_field->visibility === 4)? 'checked' : '' }} id="hidden" required>
                                                <label class="form-check-label" for="hidden">
                                                    Hidden
                                                </label>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-0">
                                                <div class="d-flex justify-content-end align-items-baseline">
                                                    <button type="submit" class="btn btn-primary mb-2 mr-2">SAVE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <h4>Suggested {{ $extension_program_field->label }}</h4>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <a href="{{ route('document-description.create') }}" role="button" class="btn btn-success">Add</a>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="description-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($descriptions as $description)
                                            <tr role="button">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$description->name}}</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input active-switch" id="is_active_{{ $description->id }}" data-description-id="{{ $description->id }}" data-report-id="{{ $description->report_category_id }}" {{ ($description->is_active == 1) ? 'checked': '' }}>
                                                        <label class="custom-control-label" for="is_active_{{ $description->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div role="group">
                                                        <a href="{{route('document-description.edit', $description->id) }}"  class="action-edit mr-3"><i class="bi bi-pencil-square" style="font-size: 1.25em;"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
      <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
      <script>
          $("#description-table").dataTable({
                "searching":true
            });
          var table =  $("#description-table").DataTable();
          $ (function (){
            $("#placeholderfield").hide();
            $("#dropdown_field").hide();

            $("#field_type").find("option:selected").each(function(){
                    var fieldtype = $(this).attr("class");
                    if(fieldtype === 'dropdown'){
                        $('#dropdown_field').show();
                        $('#placeholderfield').hide();
                        $('#dropdown').attr('required', '');
                    }else if(fieldtype === 'date' || fieldtype === 'date-range'){
                        $('#placeholderfield').hide();
                    } else if(fieldtype === 'text' || fieldtype === 'number' || fieldtype === 'decimal' || fieldtype === 'textarea' || fieldtype === 'document_description'){
                        $("#dropdown_field").hide();
                        $('#placeholderfield').show();
                        $("#dropdown").removeAttr('required');
                    }else{
                        $("#dropdown_field").hide();
                        $("#dropdown").removeAttr('required');
                    }
            });
        });
      </script>
      <script>
        $('.active-switch').on('change', function(){
            var optionID = $(this).data('description-id');
            var reportCategoryID = $(this).data('report-id');
            if ($(this).is(':checked')) {
                var isActive = 1;
            } else {
                var isActive = 0;
            }
            $.ajax({
                url: '/maintenances/description/isActive/'+reportCategoryID+'/'+optionID+'/'+isActive
            });
        });
    </script>
    @endpush
</x-app-layout>