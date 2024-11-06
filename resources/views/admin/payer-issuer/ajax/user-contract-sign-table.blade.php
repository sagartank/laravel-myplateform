<div class="row">
    <div class="col-md-12">
        <h6><strong>{{ $company_owner_name }}</strong></h6>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Mobile Number') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr role="button" id="row-{{ $item->id }}">
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->mobile_number }}</td>
                <td>
                    <button type="button" data-id="{{ $item->id }}" data-user-id="{{ $item->user->slug ?? '' }}" data-issure-id="{{ $item->issuer_id }}"
                        data-name="{{ $item->name }}" data-email="{{ $item->email }}"
                        data-mobile-number="{{ $item->mobile_number }}"
                        class="btn btn-primary btn-sm evt_edit_user_contract_sing">{{ __('Edit') }}</button>
                    <a href="javascript:;" data-href="{{ route('admin.user-contract-sing.delete', $item->id) }}"
                        onclick="permanentDeleteRecord(this)" data-slug="{{ $item->id }}"
                        class="text-white btn btn-sm btn-danger">{{ __('Delete') }}</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center"> {{ __('No Record.') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>
