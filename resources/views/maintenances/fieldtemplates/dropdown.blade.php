{{-- fieldInfo --}}

<div class="{{ $fieldInfo->size }} {{ $fieldInfo->name }} mb-3">
    <div class="form-group">
        <label for="{{ $fieldInfo->name }}" >{{ $fieldInfo->label }}</label><span style='color: red'>{{ ($fieldInfo->required == 1) ? " *" : '' }}</span>

        <select name="{{ $fieldInfo->name }}" id="{{ $fieldInfo->name }}" class="{{ $errors->has($fieldInfo->name) ? 'is-invalid' : '' }} form-control custom-select form-validation {{ $fieldInfo->name }}" {{ ($fieldInfo->required == 1) ? 'required' : '' }}
            @switch($fieldInfo->visibility)
                    @case(2)
                        {{ 'readonly' }}
                        @break
                    @case(3)
                        {{ 'disabled' }}
                        @break
                    @case(2)
                        {{ 'hidden' }}
                        @break
                    @default
                        
                @endswitch>

            <option value="" selected disabled>Choose...</option>
            
        </select>

        @error($fieldInfo->name)
            <span class='invalid-feedback' role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


@push('scripts')
    <script>

        $(document).ready(function() {
            
            $.get("{{ route('dropdowns.options', $fieldInfo->dropdown_id) }}", function (data){
                data.forEach(function (item){
                    $("#{{ $fieldInfo->name }}").append(new Option(item.name, item.id)).change();
                });
                var value = "{{ $value }}";
                if (value != ''){
                    $("#{{ $fieldInfo->name }}").val("{{ $value }}");
                }
                <?php if (old($fieldInfo->name) != '') { ?>
                    $("#{{ $fieldInfo->name }}").val("{{ old($fieldInfo->name) }}");
                <?php } ?>
                
            });
        });
    </script>
@endpush