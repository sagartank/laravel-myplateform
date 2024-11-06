<div class="modal fade" id="deal_cashed_multiple_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deals_modal_heading">{{ __('Document Collection Date') }}</h5>
            <button type="button" class="btn-close deal_cashed_multiple_modal_close"aria-label="Close"></button>
        </div>
        <form name="deal_cashed_multiple_form" id="deal_cashed_multiple_form" class="form-validation"
            method="post" action="javascript:;" novalidate="novalidate"
            enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-3">
                    <input type="hidden" name="is_cashed_offer_id" id="is_cashed_offer_id_" value=""/>
                    <input type="hidden" name="is_cashed_group_offer_id" id="is_cashed_group_offer_id_" value=""/>
                    <input type="hidden" name="is_cashed_type" id="is_cashed_type_" value=""/>
                    <input type="text" name="is_cashed_date" id="is_cashed_date_" value="{{ date('d/m/Y') }}" class="form-control evt_cashed_date" readonly/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="deal_cashed_multiple_form_btn">{{ __('Add')}}</button>
                <button type="button" class="btn btn-secondary deal_cashed_multiple_modal_close">{{ __('Close') }}</button>
            </div>
        </form>
    </div>
</div>
</div>