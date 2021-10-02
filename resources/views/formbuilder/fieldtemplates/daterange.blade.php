{{-- fieldInfo --}}

<div class="{{ $fieldInfo->size }}">
    {{-- <div class="row">
        <div class="col">
            <h6>{{ $fieldInfo->label }}</h6>
        </div>
    </div> --}}
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>{{ $fieldInfo->label }} - From</label>
        
                <input type="date" name="{{ $fieldInfo->name }}[]" id="{{ $fieldInfo->name }}_from" value="{{ (isset($value[0]))? $value[0]: '' }}" class="form-control" {{ $fieldInfo->required }}>
        
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label>To</label>
        
                <input type="date" name="{{ $fieldInfo->name }}[]" id="{{ $fieldInfo->name }}_to" value="{{  (isset($value[1]))? $value[1]: ''}}" min="" class="form-control" {{ $fieldInfo->required }}>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
         $(document).on('change', '#{{ $fieldInfo->name }}_from', function(){
            $('#{{ $fieldInfo->name }}_to').attr('min', this.value);
        });
    </script>
@endpush