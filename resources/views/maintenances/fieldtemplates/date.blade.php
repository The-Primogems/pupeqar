<div class="{{ $fieldInfo->size }} {{ $fieldInfo->name }} mb-3">
    <div class="form-group">
        <label for="{{ $fieldInfo->name }}">{{ $fieldInfo->label }}</label> <span style='color: red'>{{ ($fieldInfo->required == 1) ? " *" : '' }}</span>

        <input type="date" name="{{ $fieldInfo->name }}" id="{{ $fieldInfo->name }}" value="{{ (old($fieldInfo->name) == '') ?  $value : old($fieldInfo->name) }}" 
            class="{{ $errors->has($fieldInfo->name) ? 'is-invalid' : '' }} 
            form-control form-validation" 
            {{ ($fieldInfo->required == 1) ? 'required' : '' }}
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

                @error($fieldInfo->name)
                    <span class='invalid-feedback' role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

    </div>
</div>