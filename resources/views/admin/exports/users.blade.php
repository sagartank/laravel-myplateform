<table>
    <thead>
        <tr>
            <th>{{ __('First Name') }}</th>
            <th>{{ __('Last Name') }}</th>
            <th>{{ __('RUC ID') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Phone') }}</th>
            <th>{{ __('Address') }}</th>
            <th>{{ __('Address Verify') }}</th>
            <th>{{ __('City') }}</th>
            <th>{{ __('Account Type') }}</th>
            <th>{{ __('Is Registered') }}</th>
            <th>{{ __('Registered At') }}</th>
            <th>{{ __('Last Login At') }}</th>
            <th>{{ __('Last Login IP') }}</th>
            <th>{{ __('Is Active') }}</th>
        </tr>
    </thead>
    <tbody>
        @if($users->isNotEmpty())
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->ruc_tax_id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ ($user->address_verify == 'Yes') ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->city?->name }}</td>
                    <td>{{ $user->account_type }}</td>
                    <td>{{ ($user->is_registered == '1') ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->last_login_at }}</td>
                    <td>{{ $user->last_login_ip }}</td>
                    <td>{{ ($user->is_active == '1') ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
