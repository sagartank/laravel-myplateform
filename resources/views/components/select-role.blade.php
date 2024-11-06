<div class="form-group mb-3">
    <label class="form-label" for="role-id">{{ __('Select Role') }}</label>
    <select name="role_id" id="role-id" class="form-control select2 @error('role_id') is-invalid @enderror" required>
        <option value="" selected disabled hidden>{{ __('Select Role') }}</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ (old('role_id') == $role->id ?: $isSelected($role->name)) ? 'selected="selected"' : '' }}>{{ $role->display_name }}</option>
        @endforeach
    </select>
    @error('role_id')
        <x-error-alert :message="$message" />
    @enderror
</div>
