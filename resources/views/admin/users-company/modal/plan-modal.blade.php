<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="userPlansModalLabel">User Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{route('admin.users.update-plan',$user->slug)}}" method="post">
        @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label for="plan_id" class="form-label">Plans</label>
            <select name="plan_id" id="plan_id" class="form-select">
                <option value="">{{ __('Select Plan') }}</option>
                @foreach ($plans as $plan)
                    <option
                        {{ $user->plan_id == $plan->id ? 'selected' : '' }}
                        value="{{ $plan->id }}">
                        {{ $plan->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    </form>
    </div>
</div>