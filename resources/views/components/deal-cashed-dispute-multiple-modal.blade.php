


<div class="report_incon_modal">
    <div class="modal fade" id="deal_dispute_multiple_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-20-medium" id="exampleModalLabel">{{ __('Report Inconvenience') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form name="deal_dispute_multiple_form" id="deal_dispute_multiple_form" method="post" action="javascript:;" novalidate="novalidate" enctype="multipart/form-data">
                    <input type="hidden" name="is_dispute_offer_id" id="is_dispute_offer_id_" value=""/>
                    <input type="hidden" name="is_dispute_group_offer_id" id="is_dispute_group_offer_id_" value=""/>
                    <input type="hidden" name="is_dispute_type" id="is_dispute_type_" value="group_offer"/>
                    <div class="modal-body">
                        <div class="reportdetail">
                            {{-- <label for="disputes_note" class="col-form-label text-16-medium">{{ __('Dispute Note') }}</label> --}}
                            <textarea class="form-control" style="height: 66px" required data-msg-required="The dispute note is required." minlength="5" name="disputes_note" id="disputes_note"></textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="disputes_file" class="form-label text-16-medium">{{ __('File') }}</label>
                            <input class="form-control" type="file" name="disputes_file" id="disputes_file">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="text-16-medium" data-bs-dismiss="modal">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary text-16-medium">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>