@props(['status'])

<div class="form-group mb-3">
    <label class="form-label" for="is-active">Is Active ?</label>
    <select name="is_active" id="is-active" class="form-control @error('is_active') is-invalid @enderror" required>
        <option value=1 @if(old('is_active', $status) == 1) selected @endif>Yes</option>
        <option value=0 @if(old('is_active', $status) == 0) selected @endif>No</option>
    </select>
    @error('is_active')
        <x-error-alert :message="$message" />
    @enderror
</div>
