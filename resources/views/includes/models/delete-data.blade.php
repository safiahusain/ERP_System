<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Warning') }}</h5>
        <button type="button" class="close" id="delete_{{$target}}_close_btn_upper" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <label for="">{{ __('Are you sure you want to delete') }}?</label>
    </div>
    <input type="hidden" id="delete_{{$target}}_id">
    <div class="modal-footer">
        <button type="button" class="btn-modern btn-danger" id="delete_{{$target}}_close_btn" data-dismiss="modal">{{ __('Close') }}</button>
        <button type="button" id="delete_{{$target}}_btn" class="btn-modern btn-success">{{ __('Delete') }}</button>
    </div>
</div>
