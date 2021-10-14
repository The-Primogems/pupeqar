<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Research Fields Manager') }}
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
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <h4>{{ $research_form->label }} Fields</h4>
                                <hr>
                            </div>
                            {{-- ADD Fields --}}
                            <div class="col-md-12">
                                <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                                <hr>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Label</th>
                                                <th>Field Type</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="field_sortable">
                                            @foreach ($research_fields as $field)
                                            <tr id="{{ $field->id }}">
                                                <td>{{ $field->label }}</td>
                                                <td>{{ $field->field_type_name }}</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input active-switch" id="is_active_{{ $field->id }}" data-id="{{ $field->id }}" {{ ($field->is_active == 1) ? 'checked': '' }}>
                                                        <label class="custom-control-label" for="is_active_{{ $field->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('research-forms.research-fields.edit', [$research_form->id, $field->id]) }}" class="btn btn-warning btn-sm">
                                                        Update
                                                    </a>
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

    @include('maintenances.research.add', [
        'form_id' => $research_form->id,
        'fieldtypes' => $field_types,
        'dropdowns' => $dropdowns,
    ])

    @push('scripts')
        <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(function() {
                $('#field_sortable').sortable({
                    stop: function(e, ui) {
                        var array_values = $('#field_sortable').sortable('toArray');
                        var array_values = JSON.stringify(array_values);
                        $.ajax({
                            url: '/research-fields/arrange',
                            type: "POST",
                            data: {data: array_values},
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (){
                            },
                        });
                    }
                });


                $('.active-switch').on('change', function(){
                    var optionID = $(this).data('id');
                    if ($(this).is(':checked')) {
                        $.ajax({
                            url: '/research-fields/activate/'+optionID
                        });
                    } else {
                        $.ajax({
                            url: '/research-fields/inactivate/'+optionID
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>