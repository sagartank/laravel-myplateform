<div class="protab_outerbox">
    <div class="favorite_Table">
        <table>
            <thead>
                <tr class="forbg">
                    <th class="text-14-medium">{!! __('Name') !!}</th>
                    <th class="text-14-medium">{!! __('Type of Account') !!}</th>
                    <th class="text-14-medium">{!! __('Location') !!}</th>
                    <th class="text-14-medium">{!! __('Action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favorites as $key => $favorite)
                    @if ($favorite->favoriteable_type == 'App\Models\Issuer')
                        <tr>
                            <td class="text-12-medium evt_ex_issuer_details"
                                data-issuer-details-link="{{ route('profile.public-payer-profile', $favorite->favoriteable->slug) }}"
                                role="button">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ $favorite->favoriteable->company_image_url ?? '' }}"
                                            alt="no-image"></div>
                                    <p class="text-14-medium">{{ $favorite->favoriteable->company_name ?? '' }}</p>
                                </div>
                            </td>
                            <td class="text-12-medium"></td>
                            <td class="text-12-medium"></td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" class="evt_favorite_delete"
                                        data-favorite-id="{{ $favorite->id }}"><i><img
                                                src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span
                                            class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                    @elseif($favorite->favoriteable_type == 'App\Models\User')
                        <tr>
                            <td class="text-12-medium evt_ex_seller_details"
                                data-seller-details-link="{{ route('profile.public-seller', $favorite->favoriteable?->slug) }}"
                                role="button">
                                <div class="user_namebox">
                                    <div class="imgbox"><img src="{{ $favorite->favoriteable->profile_image_url ?? '' }}"
                                            alt="no-image"></div>
                                    <p class="text-14-medium">{{ __($favorite->favoriteable->name ?? 'N/A') }}</p>
                                </div>
                            </td>
                            <td class="text-12-medium">{{ __($favorite->favoriteable->account_type ?? 'N/A') }}</td>
                            <td class="text-12-medium">{{ __($favorite->favoriteable->city->name ?? 'N/A') }}</td>
                            <td class="text-12-medium">
                                <div class="actionbtnbox">
                                    <a href="javascipt:;" class="evt_favorite_delete"
                                        data-favorite-id="{{ $favorite->id }}"><i><img
                                                src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i><span
                                            class="text-12-medium delete">{!! __('Delete') !!}</span></a>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- mobile table:st --}}
    <div class="mobile_cmn_table_wrap">
        @foreach ($favorites as $key => $favorite)
            @if ($favorite->favoriteable_type == 'App\Models\Issuer')
                <div class="mb_fav_table">
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Name') !!}</p>
                        </div>
                        <div class="right">
                            <div class="user_namebox">
                                <p class="text-16-medium">{{ __($favorite->favoriteable->company_name ?? 'N/A') }}</p>
                                <div class="imgbox"><img src="{{ $favorite->favoriteable->company_image_url ?? '' }}" alt="no-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Type of Account') !!}</p>
                        </div>
                        <div class="right">
                            <p class="text-16-medium"></p>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Location') !!}</p>
                        </div>
                        <div class="right">
                            <p class="text-16-medium"></p>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Action') !!}</p>
                        </div>
                        <div class="right">
                            <div class="actionbtnbox">
                                <a href="javascipt:;" class="evt_favorite_delete"
                                    data-favorite-id="{{ $favorite->id }}"><i><img
                                            src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($favorite->favoriteable_type == 'App\Models\User')
                <div class="mb_fav_table">
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Name') !!}</p>
                        </div>
                        <div class="right">
                            <div class="user_namebox">
                                <p class="text-16-medium">{{ __($favorite->favoriteable->name ?? 'N/A') }}</p>
                                <div class="imgbox"><img src="{{ $favorite->favoriteable->profile_image_url ?? '' }}" alt="no-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Type of Account') !!}</p>
                        </div>
                        <div class="right">
                            <p class="text-16-medium">{{ __($favorite->favoriteable->account_type ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Location') !!}</p>
                        </div>
                        <div class="right">
                            <p class="text-16-medium">{{ __($favorite->favoriteable->city->name ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div class="mb_boxdata">
                        <div class="lft">
                            <p class="text-16-medium">{!! __('Action') !!}</p>
                        </div>
                        <div class="right">
                            <div class="actionbtnbox">
                                <a href="javascipt:;" class="evt_favorite_delete"
                                    data-favorite-id="{{ $favorite->id }}"><i><img
                                            src="{{ asset('images/mipo/paydelete.svg') }}" alt="no-image"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    {{-- mobile table:nd --}}
</div>

{{-- not found favorites :st --}}
@if (isset($favorites) && $favorites->count() == 0)
    <div class="ope_notfoundWrap fav_not_wrap" id="evt_no_favorites">
        <div class="imgbox">
            <div class="day"><img src="{{ asset('images/mipo/not_fav_day.svg') }}" alt="no-image"></div>
            <div class="night"><img src="{{ asset('images/mipo/not_fav_night.svg') }}" alt="no-image"></div>
            <strong class="text-20-semibold">{!! __('No favorites added') !!}</strong>
            <p class="text-16-medium">{!! __('Explore and add Favorites') !!}</p>

            <div class="favbtn">
                <a href="{{ route('explore-operations.index') }}" class="text-16-medium"><i><img
                            src="{{ asset('images/mipo/payplus.svg') }}" alt="no-image"></i>
                    {!! __('Add Favorites') !!}</a>
            </div>
        </div>
    </div>
@endif
