<div class="modal fade" id="delete-{{$target}}-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Warning') }}</h5>
                <button type="button" class="close" id="delete-{{$target}}-close-btn-upper" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">{{ __('Are you sure you want to delete') }}?</label>
            </div>
            <input type="hidden" id="delete-{{$target}}-id">
            <div class="modal-footer">
                <button type="button" class="btn-modern btn-danger" id="delete-{{$target}}-close-btn" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" id="delete-{{$target}}-btn" data-delete-route="{{ route($target.'-delete', ':id') }}" onclick="delete_recode('{{$target}}')" class="btn-modern btn-success">{{ __('Delete') }}</button>
            </div>
        </div>
    </div>
</div>
