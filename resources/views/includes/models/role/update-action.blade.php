<div class="modal" tabindex="-1" id="update_action_modal" role="dialog" aria-labelledby="pendingTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Update Role') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" id="update_role_action_form">
                        @csrf
                        <input type="hidden" id="action_ids" name="action_ids">
                        <div id="role_action">

                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" id="update_role_action_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
