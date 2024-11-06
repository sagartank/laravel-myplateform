<div class="pay_detailTable">
<table>
    <thead>
        <tr class="forbg">
            <th class="text-14-medium">{!! __('Payment Method') !!}</th>
            <th class="text-14-medium">{!! __('Financial Institution') !!}</th>
            <th class="text-14-medium">{!! __('Account Number') !!} </th>
            <th class="text-14-medium">{!! __('Phone') !!} #</th>
            <th class="text-14-medium">{!! __('Payment Note') !!}</th>
            <th class="text-14-medium">{!! __('ID') !!}</th>
            <th class="text-14-medium">{!! __('Action') !!}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($banks as $bank)
            <tr>
                <td class="text-12-medium">{{ __($bank->payment_options) }}</td>
                <td class="text-12-medium">{{ $bank->issuer_bank?->name }}</td>
                <td class="text-12-medium">{{ $bank->account_number }}</td>
                <td class="text-12-medium">{{ $bank->phone_company ??  $bank->phone_number }}</td>
                <td class="text-12-medium">{{ $bank->payment_note }}</td>
                <td class="text-12-medium">{{ $bank->identification_id }}</td>
                <td class="text-12-medium">
                    <div class="actionbtnbox">
                        <a href="javascript:void(0)" class="evt_bank_modal_open" data-action="Update"
                            data-bank-object="{{ $bank->toJson() }}" data-form-name="#addUserBankForm"
                            data-modal-name="#add_new_bank_modal">
                            <i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="deleteRecord(this, () => loadMoreBankUserData())"
                            data-href="{{ route('profile.ajax-bank-delete', ['bank_id' => $bank->id]) }}"
                            data-name="delete">
                            <i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
    
        @endforelse
    </tbody>
</table>
</div>

<div class="mobile_cmn_table_wrap">
    @forelse ($banks as $bank)
    <div class="mb_profiletable">
        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('Payment Method') !!}</p></div>
            <div class="right"><p class="text-16-medium">{{ __($bank->payment_options) }}</p></div>
        </div>

        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('Financial Institution') !!}</p></div>
            <div class="right"><p class="text-16-medium">{{ $bank->issuer_bank?->name }}</p></div>
        </div>

        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('Account Number') !!}</p></div>
            <div class="right"><p class="text-16-medium">{{ $bank->account_number }}</p></div>
        </div>

        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('Phone') !!}#</p></div>
            <div class="right"><p class="text-16-medium">{{ $bank->phone_company ??  $bank->phone_number }}</p></div>
        </div>

        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('Payment Note') !!}</p></div>
            <div class="right"><p class="text-16-medium">{{ $bank->payment_note }}</p></div>
        </div>

        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('ID') !!}</p></div>
            <div class="right"><p class="text-16-medium">{{ $bank->identification_id }}</p></div>
        </div>

        <div class="mb_boxdata">
            <div class="lft"><p class="text-16-medium">{!! __('Action') !!}</p></div>
            <div class="right">
                <div class="actionbtnbox">
                    <a href="javascript:void(0)" class="evt_bank_modal_open" data-action="Update"
                    data-bank-object="{{ $bank->toJson() }}" data-form-name="#addUserBankForm"
                    data-modal-name="#add_new_bank_modal">
                    <i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i>
                </a>
                <a href="javascript:void(0)" onclick="deleteRecord(this, () => loadMoreBankUserData())"
                    data-href="{{ route('profile.ajax-bank-delete', ['bank_id' => $bank->id]) }}"
                    data-name="delete">
                    <i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i>
                </a>
                    {{-- <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#pay_method"><i><img src="{{ asset('images/mipo/payedit.svg') }}" alt="no-image"></i></a>
                    <a href="javascipt:;" data-bs-toggle="modal" data-bs-target="#delete_confirm"><i><img src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a> --}}
                </div>
            </div>
        </div>
    </div>
    @empty
    
    @endforelse
</div>