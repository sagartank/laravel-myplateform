@props(['total_micoin_credit', 'referrer_code'])

<div class="coin_tabdetail">
    <div class="protab_outerbox">
        <div class="micoinbox">
           <div class="leftbox">
              <div class="titlebox">
                <h3 class="text-14-semibold">{{ __('1 MICoin = 1 Gs.') }}</h3>
                <p class="text-12-medium">{!! __('Each transaction performed by your referral will earn you tokens!') !!}</p>
              </div>

              <div class="available">
                <p class="text-14-medium">{!! __('Available MICoins') !!}</p>
                <h3 class="text-24-semibold">{{ $total_micoin_credit }} {!! __('Coins') !!}</h3>
              </div>
           </div>
           <div class="rightbox">
            <div class="logobox">
                <div class="imgbox">
                    <img src="{{ asset('images/mipo/m_symbol.jpg') }}" alt="no-image">
                </div>
            </div>
            <div class="ref_code">
                <div class="imgbox">
                    <div class="icon referral_code_copy"  data-ref-code="{{ $referrer_code }}">
                        <img src="{{ asset('images/mipo/copy_ref.svg') }}" alt="no-image">
                    </div>
                </div>
                <p class="text-12-medium">{!! __('Referral Code') !!}: <span class="text-12-semibold" id="txt_referral_code" data-ref-code="{{ $referrer_code }}">{{ $referrer_code }}</span></p>
            </div>
           </div>
        </div>
        {{--  --}}

            <div class="credits_tab_content" data>
                <div class="credits_step_row">
                    <div class="credits_step_col">
                        <div class="credits_step_blk">
                            <div class="icon_credits_step">
                                <img src="{{ asset('images/mipo/invite_frnd.svg') }}" alt="no-image">
                            </div>
                            <div class="credits_step_title text-14-medium">
                                <!-- <span>1</span> -->
                                {!! __('Invite Friends') !!}
                            </div>
                            <p class="text-12-medium">{!! __('Send invitation to friends through email or shared links') !!}</p>
                        </div>
                    </div>
                    <div class="credits_step_col">
                        <div class="credits_step_blk">
                            <div class="icon_credits_step"> 
                                <img src="{{ asset('images/mipo/use_mipo.svg') }}" alt="no-image">
                            </div>
                            <div class="credits_step_title text-14-medium">
                                <!-- <span>2</span> -->
                                {!! __('They Use MIPO') !!}
                            </div>
                            <p class="text-12-medium">{!! __('They sign up as investors or sellers and they start buying and selling documents.') !!}</p>
                        </div>
                    </div>
                    <div class="credits_step_col">
                        <div class="credits_step_blk">
                            <div class="icon_credits_step">
                                <img src="{{ asset('images/mipo/earn_micoin.svg') }}" alt="no-image">
                            </div>
                            <div class="credits_step_title text-14-medium">
                                <!-- <span>3</span> -->
                                {!! __('Earn MICOINS') !!}
                            </div>
                            <p class="text-12-medium">{!! __('Earn MICOINS that you can exchange at any moment for cash. The more users you refer, the more transactions they do, the more $$ you can make!') !!}</p>
                        </div>
                    </div>
                </div>
                <div class="invite_referral_blk">
                    <form name="invite-form" id="inviteForm" action="{{ route('profile.ajax-invite-friend') }}" method="post" novalidate="novalidate">
                        <div class="profile_inputbox">
                            <label for="email_invite" class="text-14-medium">{!! __('Send Invitations by email') !!}</label>
                            <input type="email" name="email_invite" class="text-14-medium" required  minlength="5" data-msg-required="The email is required." id="email_invite">
                            <div class="invitebtn">
                                <button type="submit" value="{!! __('Invite') !!}" class="text-12-medium">{!! __('Invite') !!}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>