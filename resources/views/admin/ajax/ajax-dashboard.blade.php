<div class="col-12 mt-2">
    <div class="card">
        <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>{{ __('New users') }}</th>
            <td>{{ $totalNewUser }}</th>
          </tr>
          <tr>
            <th>{{ __('Loaded Operations') }}</th>
            <td>{{ $totalLoadedOperations }}</th>
          </tr>
          <tr>
            <th>{{ __('Sent Offers') }}</th>
            <td>{{ $totalSentOffer }}</th>
          </tr>
          <tr>
            <th>{{ __('Counteroffers Sent') }}</th>
            <td>{{ $totalCounterSentOffer }}</td>
          </tr>
          <tr>
            <th>{{ __('Online users') }}</th>
            <td>{{ $totalOnlineUser }}</td>
          </tr>
          <tr>
            <th>{{ __('Completed Operations') }}</th>
            <td>{{ $totalCompletedOperations }}</td>
          </tr>
          <tr>
            <th>{{ __('Completed Operations') }} {{ __('In Guaranies') }}</th>
            <td>Gs. {{ $totalGsOpAmount }}</td>
          </tr>
          <tr>
            <th>{{ __('Completed Operations') }} {{ __('In dollars') }}</th>
            <td>USD {{ $totalUsdOpAmount }}</td>
          </tr>
          <tr>
            <th>{{ __('Commissions Generated') }}</th>
            <td>{{ $commissionsGenerated }}</td>
          </tr>
          <tr>
            <th>{{ __('By Operations') }}</th>
            <td>Gs.100.00</td>
          </tr>
          <tr>
            <th>{{ __('MIPO+') }}</th>
            <td>Gs. 100.00</td>
          </tr>
          <tr>
            <th>{{ __('Documents Due Today') }}</th>
            <td>{{ $documentsDueToday }}</td>
          </tr>
          <tr>
            <th>{{ __('Documents that expire in 1 week') }}</th>
            <td>{{ $documentsExpiringInOneWeek }}</td>
          </tr>
          <tr>
            <th>{{ __('Documents that expire in 1 month') }}</th>
            <td>{{ $documentsExpiringInOneMonth }}</td>
          </tr>
          <tr>
            <th>{{ __('Operations that expired 1 week ago') }}</th>
            <td>{{ $expiredDocumentsOneWeekAgo }}</td>
          </tr>
          <tr>
            <th>{{ __('Operations that expired 1 month ago') }}</th>
            <td> {{ $expiredDocumentsOneMonthAgo }}</td>
          </tr>
          <tr>
            <th>{{ __('Transactions that expired > 1 month ago') }}</th>
            <td>{{ $expiredTransactionsMoreThanOneMonthAgo }}</td>
          </tr>
          <tr>
            <th>{{ __('Open Disputes') }}</th>
            <td>{{ $totalOpenDisputes }}</td>
          </tr>
          <tr>
            <th>{{ __('Closed Disputes') }}</th>
            <td>{{ $totalCloseDisputes }}</td>
          </tr>
        {{--   <tr>
            <th></th>
            <td></td>
          </tr> --}}
        </thead>
      </table>
    </div>
    </div>
    </div>