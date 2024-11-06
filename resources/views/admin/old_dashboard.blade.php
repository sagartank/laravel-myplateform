<x-app-admin-layout>
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
            <x-slot name="right">
            </x-slot>
        </x-header>
    </x-slot>

    <div class="container-lg">
        {{--   <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        you're logged in.
                    </div>
                </div>
            </div>
        </div> --}}
        @permission('users')
        <fieldset>
            <legend>{{ __('Users') }}</legend>
            <div class="row">
            <div class="col-sm-6 col-md-2">
              <div class="card text-white bg-info">
                <div class="card-body">
                  <div class="text-medium-emphasis-inverse text-end mb-4">
                    <svg class="icon icon-xxl">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $total_user->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Total User')}}</small>
                  <div class="progress progress-white progress-thin mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-md-2">
              <div class="card text-white bg-primary">
                <div class="card-body">
                  <div class="text-medium-emphasis-inverse text-end mb-4">
                    <svg class="icon icon-xxl">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user-follow"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $total_user->where('is_registered', '1')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Registere User')}}</small>
                  <div class="progress progress-white progress-thin mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-danger">
                  <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                      <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                      </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_user->where('is_active', '!=', '1')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Inactive User')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-success">
                  <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                      <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                      </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_user->where('is_active', '1')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Active User')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
  
           
          </div>
        </fieldset>
        @endpermission
        @permission('operations')
        <fieldset>
            <legend>{{ __('Operations') }}</legend>
            <div class="row">
            <div class="col-sm-6 col-md-2">
              <div class="card text-white bg-info">
                <div class="card-body">
                  <div class="text-medium-emphasis-inverse text-end mb-4">
                    <svg class="icon icon-xxl">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $total_operation->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Total Operation')}}</small>
                  <div class="progress progress-white progress-thin mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-md-2">
              <div class="card text-white bg-primary">
                <div class="card-body">
                  <div class="text-medium-emphasis-inverse text-end mb-4">
                    <svg class="icon icon-xxl">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user-follow"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $total_operation->where('operations_status', 'Draft')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Draft Operation')}}</small>
                  <div class="progress progress-white progress-thin mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-md-2">
              <div class="card text-white bg-warning">
                <div class="card-body">
                  <div class="text-medium-emphasis-inverse text-end mb-4">
                    <svg class="icon icon-xxl">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                    </svg>
                  </div>
                  <div class="fs-4 fw-semibold">{{ $total_operation->where('operations_status', 'Pending')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Pending Operation')}}</small>
                  <div class="progress progress-white progress-thin mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-danger">
                  <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                      <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                      </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_operation->where('operations_status', 'Rejected')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Rejected Operation')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-success">
                  <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                      <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                      </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_operation->where('operations_status', 'Approved')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Approved Operation')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
           
          </div>
        </fieldset>
        @endpermission
        @permission('offers')
        <fieldset>
            <legend>{{ __('Offers') }}</legend>
            <div class="row">
                <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-info">
                    <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                        <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_offer->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Total Offer')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                        <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user-follow"></use>
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_offer->where('offer_status', 'Pending')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Pending Offer')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-md-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                    <div class="text-medium-emphasis-inverse text-end mb-4">
                        <svg class="icon icon-xxl">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                        </svg>
                    </div>
                    <div class="fs-4 fw-semibold">{{ $total_offer->where('offer_status', 'Counter')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Counter Offer')}}</small>
                    <div class="progress progress-white progress-thin mt-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="col-sm-6 col-md-2">
                    <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="text-medium-emphasis-inverse text-end mb-4">
                        <svg class="icon icon-xxl">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                        </svg>
                        </div>
                        <div class="fs-4 fw-semibold">{{ $total_offer->where('offer_status', 'Rejected')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Rejected Offer')}}</small>
                        <div class="progress progress-white progress-thin mt-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-2">
                    <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="text-medium-emphasis-inverse text-end mb-4">
                        <svg class="icon icon-xxl">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                        </svg>
                        </div>
                        <div class="fs-4 fw-semibold">{{ $total_offer->where('offer_status', 'Approved')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Approved Offer')}}</small>
                        <div class="progress progress-white progress-thin mt-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="card text-white bg-dark">
                        <div class="card-body">
                        <div class="text-medium-emphasis-inverse text-end mb-4">
                            <svg class="icon icon-xxl">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                            </svg>
                        </div>
                        <div class="fs-4 fw-semibold">{{ $total_offer->where('offer_status', 'Completed')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Completed Offer')}}</small>
                        <div class="progress progress-white progress-thin mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        @endpermission
        @permission('deals')
        <fieldset>
            <legend>{{ __('Deals') }}</legend>
            <div class="row">
                <div class="col-sm-6 col-md-2">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                        <div class="text-medium-emphasis-inverse text-end mb-4">
                            <svg class="icon icon-xxl">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                            </svg>
                        </div>
                        <div class="fs-4 fw-semibold">{{  $total_offer->where('offer_status', 'Approved')->count()  }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Total Deals')}}</small>
                        <div class="progress progress-white progress-thin mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </div>
                    </div>
                <div class="col-sm-6 col-md-2">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="text-medium-emphasis-inverse text-end mb-4">
                            <svg class="icon icon-xxl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                            </svg>
                            </div>
                            <div class="fs-4 fw-semibold">{{ $total_offer->where('is_disputed', 'Yes')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Disputed Deals')}}</small>
                            <div class="progress progress-white progress-thin mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                        <div class="text-medium-emphasis-inverse text-end mb-4">
                            <svg class="icon icon-xxl">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                            </svg>
                        </div>
                        <div class="fs-4 fw-semibold">{{ $total_offer->where('offer_status', 'Completed')->count() }}</div><small class="text-medium-emphasis-inverse text-uppercase fw-semibold">{{ __('Completed Deals')}}</small>
                        <div class="progress progress-white progress-thin mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        @endpermission
    </div>

    @section('custom_script')
    @endsection
</x-app-admin-layout>
