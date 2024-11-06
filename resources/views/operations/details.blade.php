<x-app-layout>
    @section('pageTitle', 'My Operations Details')
    @section('custom_style')
        <link href="{{ asset('plugins/fancybox/fancybox.css') }}" rel="stylesheet">
    @endsection
    <div class="operation_wrap opcon_sec">
        <div class="container">
            <div class="op_dtl_head">
                <div class="mobile_dtl_btns">
                    <a href="{{ route('operations.index') }}" class="back_btn"><img src="{{ asset('images/mipo/cr-op-img21.svg') }}" alt="no-image"></a>
                    <div class="btnbox_wrapper">
                        @if ($result->operations_status != 'Approved')
                            <a href="{{ route('operations.edit', $result) }}" class="edit"><img src="{{ asset('images/mipo/cr-op-img10.svg') }}" alt="no-image"></a>
                        @endif
                     
                        @if ($result->offers->count() == 0)
                            <a href="javascript:;"  data-operation-id="{{ $result->id }}" data-href="{{ Route('operations.ajax-delete-multiple') }}" class="delete delete_single_operation"><img src="{{ asset('images/mipo/cr-op-img11.svg') }}" alt="no-image"></a>
                        @endif
                        
                        <a href="{{ route('operations.create') }}" class="create"><img src="{{ asset('images/mipo/addsubmit.svg') }}" alt="no-image"></a>
                    </div>
                </div>
                <div class="dtl_page_head">
                    <div class="title">
                        <div class="arobox">
                            <a href="{{ route('operations.index') }}">
                                <i><img src="{{ asset('images/mipo/topleftAro.svg') }}" class="day" alt="no-image"></i>
                                <i><img src="{{ asset('images/mipo/white_lft_aro.svg') }}" class="night" alt="no-image"></i>
                            </a>
                            <h3 class="text-24-semibold">{!! __('Operation') !!}</h3>
                        </div>
                        <div class="contentbox">
                            <p class="text-14-medium">{!! __($result->operation_type_number) !!}</p>
                            <span class="text-14-medium">{!! __($result->operations_status) !!}</span>
                        </div>
                    </div>
                    <div class="btn_box">
                        
                        @if ($result->operations_status != 'Approved')
                            <a href="{{ Route('operations.edit', $result) }}" class="edit text-16-medium"><i><img src="{{ asset('images/mipo/cr-op-img10.svg') }}" alt="no-image"></i>{!! __('Edit') !!}</a>
                        @endif

                        @if ($result->offers->count() == 0)
                            <a href="javascript:;" data-operation-id="{{ $result->id }}" data-href="{{ Route('operations.ajax-delete-multiple') }}" class="delete text-16-medium delete_single_operation"><i><img src="{{ asset('images/mipo/cr-op-img11.svg') }}" alt="no-image"></i>{!! __('Delete') !!}</a>
                        @endif

                        <a href="{{ route('operations.create') }}" class="create text-16-medium">
                            <i>
                                <svg width="20" height="20" viewBox="0 0 11 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 1.3125V10.6875M10.1875 6H0.8125" stroke="white" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </i>{!! __('Create New Operation') !!}
                        </a>
                    </div>
                </div>
            </div>
            <div class="op_dtl_wrap">
                <div class="left_dtl_sec">
                    <div class="pase_part_section">
                        <div class="payer_part">
                            <div class="left_wrap">
                                <div class="imgbox">
                                    <img src="{{ $result->seller->profile_image_url }}" alt="no-image">
                                </div>
                                <div class="text_box">
                                    <h6 class="text-14-medium">{{ $result->seller->name }}</h6>
                                    <a class="text-14-medium">{!! __('Seller of Document') !!}</a>
                                    <span class="text-14-medium">{{ $result->seller?->issuer?->ruc_code ?? '' }}</span>
                                </div>
                            </div>

                            <div class="right_wrap">
                                <ul>
                                    @if($result->seller->user_level!= '')
                                    <li><i><img src="{{ app('common')->userLevelImage($result->seller->user_level) }}" alt="no-image"></i></li>
                                    @endif
                                    
                                    @if($result->seller->address_verify == 'Yes')
                                        <li><i><img src="{{ asset('images/mipo/cr-op-img16.svg') }}" alt="no-image"></i></li>
                                    @endif

                                    @if($result->mipo_verified == 'Yes')
                                        <li><div class="imgbox"><img src="{{ asset('images/mipo/cr-op-img17.svg') }}" alt="no-image"></div></li>
                                    @endif
                                </ul>
                                <div class="rate_wrap">
                                    <i><img src="{{ asset('images/mipo/cr-op-img14.svg') }}" alt="no-image"></i>
                                    <span class="text-14-medium">{{ floor($result->seller?->ratings_avg_rating_number) }}{!! __('/5') !!} ({{ $result->seller?->ratings_count }})</span>
                                </div>
                            </div>
                            <a href="{{ route('profile.public-seller', $result->seller?->slug) }}" class="full_link"></a>
                        </div>
                        @if(isset($result->issuer))
                            <div class="seller_part">
                                <div class="left_wrap">
                                    <div class="imgbox">
                                        <img src="{{ $result->issuer?->company_image_url }}" alt="no-image">
                                    </div>
                                    <div class="text_box">
                                        <h6 class="text-14-medium">{!! __($result->issuer?->company_name) !!}</h6>
                                        <a class="text-14-medium">{!! __('Payer of Document') !!}</a>
                                        <span class="text-14-medium">{!! __($result->issuer?->ruc_code ?? '') !!}</span>
                                    </div>
                                </div>
                                <div class="right_wrap">
                                    <ul>
                                        @if($result->issuer?->verified_address == 'Yes')
                                            <li><i><img src="{{ asset('images/mipo/cr-op-img16.svg') }}" alt="no-image" title="{{ __('verified address') }}"></i></li>
                                        @endif
                                        @if($result->issuer?->registry_in_mipo == 'Yes')
                                            <li><div class="imgbox"><img src="{{ asset('images/mipo/cr-op-img17.svg') }}" alt="no-image"></div></li>
                                        @endif
                                    </ul>
                                    <div class="rate_wrap">
                                        <i><img src="{{ asset('images/mipo/cr-op-img14.svg') }}" alt="no-image"></i>
                                        <span class="text-14-medium">{{ floor($result->issuer?->ratings_avg_rating_number) }}{!! __('/5') !!} ({{$result->issuer?->ratings_count}})</span>
                                    </div>
                                </div>
                                <a href="{{ ($result->issuer) ? route('profile.public-payer-profile', $result->issuer?->slug) : 'javascript:;' }}" class="full_link"></a>
                            </div>
                        @endif

                    </div>
                    <div class="feild_dtl_sec">
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Type of Document') !!}</p>
                            <span class="text-14-medium">
                                {{ ($result->operation_type == 'Cheque') ? __('Check') : __($result->operation_type) }}
                            </span>
                        </div>
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('With or Without Recurso') !!}</p>
                            <span class="text-14-medium">{!! app('common')->responsibility($result->responsibility) !!}</span>
                        </div>
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Payment Preferences') !!}</p>
                            <span class="text-14-medium">{!! __($result->preferred_payment_method) !!}</span>
                        </div>
                        
                        @if($result->operation_type != 'Cheque' && $result->operation_type != 'Invoice')
                            <div class="detail_caption">
                                <p class="text-14-medium">{!! __('Commercial or Government') !!}</p>
                                <span class="text-14-medium">{!! __($result->is_government_contract) !!}</span>
                            </div>
                        @endif

                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Document’s Nominal Value') !!}</p>
                            <span class="text-14-medium">{{ app('common')->currencyBySymbol($result->preferred_currency) }} {{ app('common')->currencyNumberFormat($result->preferred_currency, $result->amount) }}</span>
                        </div>
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Amount able to Sell Document (this value is not public)') !!}</p>
                            <span class="text-14-medium">{{ app('common')->currencyBySymbol($result->preferred_currency) }} {{ app('common')->currencyNumberFormat($result->preferred_currency, $result->amount_requested) }}</span>
                        </div>
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Accepts Offers Below Requested Value') !!}</p>
                            <span class="text-14-medium">{!! ($result->accept_below_requested == '1') ? __('Yes') : __('No') !!}</span>
                        </div>
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Issuance Date') !!}</p>
                            <span class="text-14-medium">{!! __($result->issuance_date_iso) !!}</span>
                        </div>
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Expiration Date') !!}</p>
                            <span class="text-14-medium">
                                    {!! __($result->expire_date_iso) !!}
                            </span>
                        </div>
                        @if($result->operation_type != 'Cheque' && $result->extra_expiration_days != '')
                            <div class="detail_caption">
                                <p class="text-14-medium">{!! __('Additional Days After Expiration') !!}</p>
                                <span class="text-14-medium">
                                    {{ $result->extra_expiration_days }}
                                </span>
                            </div>
                        @endif

                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Document’s Automatic Expiration') !!}</p>
                            <span class="text-14-medium">{!! ($result->auto_expire == '1') ? __('Yes') : __('No') !!}</span>
                        </div>

                        @if($result->operation_type == 'Invoice')
                            <div class="detail_caption">
                                <p class="text-14-medium">{!! __('Type of Invoice') !!}</p>
                                <span class="text-14-medium">{!! __($result->invoice_type) !!}</span>
                            </div>
                            @if($result->invoice_number!='')
                                <div class="detail_caption">
                                    <p class="text-14-medium">{!! __('Invoice Number') !!}</p>
                                    <span class="text-14-medium">{!! __($result->invoice_number) !!}</span>
                                </div>
                            @endif
                            @if($result->timbrado!='')
                                <div class="detail_caption">
                                    <p class="text-14-medium" data-info="timbrado">{!! __('Stamped') !!}</p>
                                    <span class="text-14-medium">{!! __($result->timbrado) !!}</span>
                                </div>
                            @endif
                            @if($result->stamp_expiration!='')
                                <div class="detail_caption">
                                    <p class="text-14-medium">{!! __('Stamped Expiration') !!}</p>
                                    <span class="text-14-medium">{!! __($result->stamp_expiration_iso) !!}</span>
                                </div>
                            @endif
                        @endif
                        @if($result->operation_type == 'Cheque' && $result->check_number!='')
                            <div class="detail_caption">
                                <p class="text-14-medium">{!! __('Check Number') !!}</p>
                                <span class="text-14-medium">{!! __($result->check_number) !!}</span>
                            </div>
                        @endif

                        @if($result->issuer?->company_name!='')
                            <div class="detail_caption">
                                <p class="text-14-medium">{!! __('Payer’s Bank') !!}</p>
                                <span class="text-14-medium">{!! __($result->issuer?->company_name) !!}</span>
                            </div>
                        @endif

                        @if(isset($result->legal_telephone))
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Declared Phone') !!}</p>
                            <span class="text-14-medium">{!! ($result->legal_telephone) !!}</span>
                        </div>
                        @endif

                        @if(isset($result->legal_direction))
                        <div class="detail_caption">
                            <p class="text-14-medium">{!! __('Legal Address') !!}</p>
                            <span class="text-14-medium">{!! ($result->legal_direction) !!}</span>
                        </div>
                        @endif

                        @if($result->operation_type == 'Contract')
                            @if($result->contract_number!='')
                                <div class="detail_caption">
                                    <p class="text-14-medium">{!! __('Document Number') !!}</p>
                                    <span class="text-14-medium">{!! ($result->contract_number) !!}</span>
                                </div>
                            @endif
                        @endif
                        @if($result->operation_type != 'Cheque' && isset($result->issuer_company_type))
                            <div class="detail_caption">
                                <p class="text-14-medium">{!! __('Type of Business') !!}</p>
                                <span class="text-14-medium">{!! __($result->issuer_company_type) !!}</span>
                            </div>
                        @endif
                    </div>

                    @if ($result->references->count() > 0 && $result->references->first()->name !='')
                        <div class="commercial_table">
                            <h6 class="text-20-medium">{!! __('Commercial References') !!}</h6>
                            <div class="table_sec">
                                <table>
                                    <thead>
                                        <tr class="forbg">
                                            <th class="text-14-medium">{!! __('Name') !!}</th>
                                            <th class="text-14-medium">{!! __('Email') !!}</th>
                                            <th class="text-14-medium">{!! __('Phone') !!}</th>
                                            <th class="text-14-medium">{!! __('Business Name') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result->references as $reference)
                                        <tr>
                                            <td class="text-14-medium">{!! __($reference->name) !!}</td>
                                            <td class="text-14-medium">{!! __($reference->email) !!}</td>
                                            <td class="text-14-medium">{!! __($reference->phone_number) !!}</td>
                                            <td class="text-14-medium">{!! __($reference->company_name) !!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mobile_table_wrapper" data-info="mobile">
                                <div class="moop_headbody">
                                    @foreach ($result->references as $reference)
                                        <div class="delr_mobile_wrap">
                                            <p class="text-16-medium">{!! __('Name') !!}</p>
                                            <h6 class="text-16-medium">{!! __($reference->name) !!}</h6>
                                        </div>
                                        <div class="delr_mobile_wrap">
                                            <p class="text-16-medium">{!! __('Email') !!}</p>
                                            <h6 class="text-16-medium">{!! __($reference->email) !!}</h6>
                                        </div>
                                        <div class="delr_mobile_wrap">
                                            <p class="text-16-medium">{!! __('Phone') !!}</p>
                                            <h6 class="text-16-medium">{!! __($reference->phone_number) !!}</h6>
                                        </div>
                                        <div class="delr_mobile_wrap">
                                            <p class="text-16-medium">{!! __('Business Name') !!}</p>
                                            <h6 class="text-16-medium">{!! __($reference->company_name) !!}</h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="right_dtl_sec">
                    @if ($result->documents && $result->documents->count() > 0)
                        <div class="main_docsec">
                            <p class="text-16-medium">{!! __('Main Document') !!}</p>
                            @foreach ($result->documents as $document)
                                @if ($document->path != '')
                                    @php
                                        $file_ext = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                                    @endphp
                                    <div class="main_doc_wrap">
                                        <div class="doc_img">
                                            <div class="doc_wrap">
                                                @if ($file_ext == 'pdf' && $document->path != '')
                                                    <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="document pdf" alt="document" data-dz-thumbnail>
                                                @else
                                                    <img width="100" role="button" src="{{ $document->document_url }}" title="document pdf" alt="document" data-dz-thumbnail data-fancybox>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if ($result->supportingAttachments && $result->supportingAttachments->count() > 0)
                        <div class="additional_section">
                            <p class="text-16-medium">{!! __('Additional Attachments') !!}</p>
                            @foreach ($result->supportingAttachments as $supporting_attachment)
                                @if ($supporting_attachment->path != '')
                                    @php
                                        $file_ext = strtolower(pathinfo($supporting_attachment->path, PATHINFO_EXTENSION));
                                    @endphp
                                    <div class="doc_row">
                                        <div class="doc_wrap">
                                            <div class="doc_img">
                                                @if ($file_ext == 'pdf' && $supporting_attachment->path != '')
                                                <img width="100" src="{{ asset('images/mipo/pdf.png') }}" title="support pdf" alt="support" data-dz-thumbnail>
                                                @else
                                                <img width="100" role="button" src="{{ $supporting_attachment->attachment_url }}" title="support pdf" alt="support" data-dz-thumbnail data-fancybox>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    @section('custom_script')
    <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.delete_single_operation', function (e) {
                e.preventDefault();
                var self = $(this);
                var operation_id = self.attr('data-operation-id');
                Swal.fire({
                    title: ays_en_msg,
                    text: ays_delete_en_msg,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#13153B',
                    confirmButtonText: yes_delete_en_msg,
                    cancelButtonText: cancel_en_msg,   
                }).then((result) => {
                    if (result.isConfirmed) {
                        setLoadin();
                        $.ajax({
                            type: 'POST',
                            url: self.attr('data-href'),
                            dataType: 'json',
                            data: {
                                'operation_ids': operation_id,
                                'action': 'single'
                            },
                            cache: false,
                            success: function (res) {
                                unsetLoadin();
                                if (res.status == true) {
                                    toastr.success(res.message);
                                    if (res.redirect_url != '') {
                                        setTimeout(
                                            window.location.href = res.redirect_url,
                                            5000);
                                    }
                                } else {
                                    toastr.error(res.message);
                                }
                            },
                            error: function (data) {
                                unsetLoadin();
                                toastr.error(error_something_en_msg);
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endsection
</x-app-layout>
