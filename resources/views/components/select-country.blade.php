<!-- It is never too late to be what you might have been. - George Eliot -->
<div class="form-group mb-3">
    <label class="form-label" for="country-id">{{ __('Country') }}</label>
    <select name="country_id" id="country-id" class="form-control select2 @error('country_id') is-invalid @enderror" required>
        <option value="" selected disabled hidden>Select</option>
        @foreach($countries as $country)
            <option value="{{ $country->id }}" {{ (old('country_id') == $country->id ?: $isSelected($country->id)) ? 'selected="selected"' : '' }}>{{ $country->name }}</option>
        @endforeach
    </select>
    @error('country_id')
        <x-error-alert :message="$message" />
    @enderror
</div>
