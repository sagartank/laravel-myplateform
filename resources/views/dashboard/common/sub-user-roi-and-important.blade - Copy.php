@if (
    $req_param['user_account_type'] == 'Enterprise' &&
        $req_param['preferred_dashboard'] == 'Borrower' &&
        isset($enterprises_data))
    <div class="sub_user_row">
        <div class="row_title">
            <h3>Sub User ROI</h3>
        </div>
        <div class="row five-cols">
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%
                            <p>Avg. Discount</p>
                        </div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Sold</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Total Cashed</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Sold</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Total Cashed</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Sold</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Total Cashed</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Sold</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Total Cashed</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Sold</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Total Cashed</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
        </div>
    </div>

    <div class="imp_data_row">
        <div class="row_title">
            <h3>Important Data</h3>
            @php
                $total_documents_purchased = $update_deals->where('offer_status', 'Completed')->count();
                $total_documents_cashed = $update_deals->where('is_cashed', 'Yes')->count();
                $total_on_going_deals = $update_deals->where('offer_status', 'Approved')->count();
                $total_pending_actions = $update_deals->where('offer_status', 'Pending')->count();
            @endphp
        </div>
        <div class="row five-cols">
            <div class="col">
                <div class="user_data_block">
                    <h6>Documents Sold</h6>
                    <span class="number" style="color: var(--mipo-gray);">15</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Documents Cashed</h6>
                    <span class="number" style="color: var(--mipo-gray);">7</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>On-Going Deals</h6>
                    <span class="number" style="color: var(--mipo-gray);">23</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Pending Actions</h6>
                    <span class="number" style="color: var(--mipo-gray);">12</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Counter Offered</h6>
                    <span class="number" style="color: var(--mipo-gray);">1</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Total Sold</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 8.350</span>
                        <span style="color: var(--mipo-green);">Gs. 37.146.200</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Total Cashed</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 8.350</span>
                        <span style="color: var(--mipo-green);">Gs. 37.146.200</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Overall Discount</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 8.350</span>
                        <span style="color: var(--mipo-green);">Gs. 37.146.200</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Pending Actions</h6>
                    <span class="number" style="color: var(--mipo-red);">23</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>Rejected Offers</h6>
                    <span class="number" style="color: var(--mipo-red);">23</span>
                </div>
            </div>
            <!-- Col end -->
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Sold With Resources</h6>
                    <span class="number" style="color: var(--mipo-gray);">3</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Sold Without Resources</h6>
                    <span class="number" style="color: var(--mipo-gray);">7</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Best Seller</h6>
                    <span class="number" style="color: var(--mipo-gray);">Biggie S.A.</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Sales Success Rate</h6>
                    <span class="number" style="color: var(--mipo-green);">85%</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 7 Days</h6>
                    <p>
                        <span style="color: var(--mipo-red);">USD 1.322</span>
                        <span style="color: var(--mipo-red);">Gs. 10.584.444</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 15 Days</h6>
                    <p>
                        <span style="color: var(--mipo-orange);">USD 0</span>
                        <span style="color: var(--mipo-orange);">Gs. 6.000.000</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 0</span>
                        <span style="color: var(--mipo-green);">Gs. 23.420.000</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 500</span>
                        <span style="color: var(--mipo-green);">Gs. 80.966.000</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 7 Days</h6>
                    <span class="number" style="color: var(--mipo-red);">3</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 15 Days</h6>
                    <span class="number" style="color: var(--mipo-orange);">15</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <span class="number" style="color: var(--mipo-green);">6</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-lg-3 col-md-6">
                <div class="user_data_block">
                    <h6>Document Due &lt; 30 Days</h6>
                    <span class="number" style="color: var(--mipo-green);">4</span>
                </div>
            </div>
            <!-- Col end -->
            <div class="col-md-6">
                <div class="chart_block">
                    <img src="{{ asset('images/doc-chart.svg') }}" alt="no-image">
                </div>
            </div>
            <!-- Col end -->
        </div>
    </div>
@elseif ($req_param['preferred_dashboard'] == 'Investor')
    <div class="sub_user_row">
        <div class="row_title">
            <h3>Sub User ROI</h3>
        </div>
        <div class="row five-cols">
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Invested</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Profit</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Invested</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Profit</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Invested</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Profit</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Invested</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Profit</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
            <div class="col">
                <div class="sub_user_block">
                    <div class="top_text">
                        <div class="left_box">
                            <p>USER 1</p>
                            <span>Profit/Loss</span>
                        </div>
                        <div class="right_box">17.2%</div>
                    </div>
                    <div class="body_text">
                        <ul>
                            <li>
                                <span style="color: var(--mipo-gray);">G. 1.355.200</span>
                                <span>Total Invested</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-green);">G. 1.355.200</span>
                                <span>Profit</span>
                            </li>
                            <li>
                                <span style="color: var(--mipo-red);">G. 0</span>
                                <span>Disputes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Col end -->
        </div>
    </div>

    <div class="imp_data_row">

        <div class="row_title">

            <h3>Important Data </h3>

        </div>
        @php
            $total_documents_purchased = $update_deals->where('offer_status', 'Completed')->count();
            $total_documents_cashed = $update_deals->where('is_cashed', 'Yes')->count();
            $total_on_going_deals = $update_deals->where('offer_status', 'Approved')->count();
            $total_pending_actions = $update_deals->where('offer_status', 'Pending')->count();
        @endphp
        <div class="row five-cols">

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Documents Purchased') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $total_documents_purchased }} </span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Documents Cashed') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);"> {{ $total_documents_cashed }}</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('On-Going Deals') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $total_on_going_deals }}</span>
                </div>
            </div>

            <!-- Col end -->
            <div class="col">
                <div class="user_data_block">
                    <h6>{{ __('Pending Actions') }}</h6>
                    <span class="number" style="color: var(--mipo-gray);">{{ $total_pending_actions }}</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>Outmatched Offers</h6>
                    <span class="number" style="color: var(--mipo-gray);">23</span>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>Total Profits</h6>
                    <span style="color: var(--mipo-green);">USD 8.350</span>
                    <span style="color: var(--mipo-green);">Gs. 37.146.200</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">

                <div class="user_data_block">
                    <h6>Total Invested</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 8.350</span>
                        <span style="color: var(--mipo-green);">Gs. 37.146.200</span>
                    </p>
                </div>
            </div>

            <!-- Col end -->

            <div class="col">
                <div class="user_data_block">
                    <h6>Overall ROI</h6>
                    <p>
                        <span style="color: var(--mipo-green);">USD 8.350</span>
                        <span style="color: var(--mipo-green);">Gs. 37.146.200</span>
                    </p>
                </div>
            </div>
            <!-- Col end -->

            <div class="col">

                <div class="user_data_block">

                    <h6>Pending Actions</h6>

                    <span class="number" style="color: var(--mipo-red);">23</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col">

                <div class="user_data_block">

                    <h6>Unclosed Deals</h6>

                    <span class="number" style="color: var(--mipo-red);">23</span>

                </div>

            </div>

            <!-- Col end -->

        </div>


        <div class="row">
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Commissions Pending</h6>

                    <span class="number" style="color: var(--mipo-gray);">1.335.000 MI</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Commissions Pending</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6> Commission Paid</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Total Saved Vs Regular Ac.</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>



            <!-- Col end -->


            <!-- Col end -->
            {{-- == --}}
            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>MICoins Available</h6>

                    <span class="number" style="color: var(--mipo-gray);">1.335.000 MI</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>MICoins Cashed</h6>

                    <span class="number" style="color: var(--mipo-gray);">0 MI</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <div class="data-logo"><img src="{{ asset('images/mipo-plus.svg') }}" alt="no-image">
                    </div>

                    <span class="number" style="color: var(--mipo-gray);">3</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <div class="data-logo"><img src="{{ asset('images/mipo-plus.svg') }}" alt="no-image">
                    </div>

                    <p>

                        <span style="color: var(--mipo-gray);">USD 8.350</span>

                        <span style="color: var(--mipo-gray);">Gs. 37.146.200</span>

                    </p>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 7 Days</h6>

                            <span class="number" style="color: var(--mipo-red);">3</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 15 Days</h6>

                            <span class="number" style="color: var(--mipo-orange);">15</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 30 Days</h6>

                            <span class="number" style="color: var(--mipo-green);">6</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-lg-3 col-md-6">

                <div class="user_data_block">

                    <h6>Document Due < 30 Days</h6>

                            <span class="number" style="color: var(--mipo-green);">4</span>

                </div>

            </div>

            <!-- Col end -->

            <div class="col-md-6">

                <div class="chart_block">

                    <img src="{{ asset('images/doc-chart.svg') }}" alt="no-image">

                </div>

            </div>

            <!-- Col end -->

        </div>

    </div>
@endif
