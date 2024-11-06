<thead>
    <tr>
        <th scope="col">{{ __('FILE') }}</th>
        <th scope="col">{{ __('UPLOADED BY') }}</th>
        <th scope="col">{{ __('UPLOADED DATE') }}</th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
    @forelse($deals_documents as $deals_document)
        @if (!empty($deals_document->deals_path_url))
            <tr>
                @if ($deals_document->extension == 'pdf')
                    <td><i class="img_icon"><img src="{{ asset('images/PDF-icon.svg') }}" alt="mipo"></i>{{ __('PDF') }}</td>
                @else
                    <td><i class="img_icon"><img src="{{ asset('images/Image-icon.svg') }}"alt="mipo"></i>{{ __('Image') }}</td>
                @endif
            <td>{{ __('You') }}</td>
            <td>{{ $deals_document->uploaded_date }}</td>
            <td>
                @if ($deals_document->extension == 'pdf')
                    <a href="{{ $deals_document->deals_path_url }}" class="btn btn-link btn-sm">{{ __('View') }}</a>
                @else
                    <a href="{{ $deals_document->deals_path_url }}" class="btn btn-link btn-sm">{{ __('View') }}</a>
                @endif
            </td>
        </tr>
    @endif
@empty
    <tr>
        <td colspan="4"><center>{{ __('No Documents') }}</center></td>
    </tr>
    @endforelse
</tbody>
