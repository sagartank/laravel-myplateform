@props(['status'])

<label for="is-active" class="inline-flex relative items-center mr-5 cursor-pointer">
    <input type="checkbox" name="is_active" value="" id="is-active" class="sr-only peer" @if(old('is_active', $status) === 1) checked @endif>
    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
    <span class="ml-3 text-sm font-medium text-gray-900">@if(old('is_active', $status) === 1) Active @else Inactive @endif</span>
</label>
