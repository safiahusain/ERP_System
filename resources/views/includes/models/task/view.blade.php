@php
    $my_array    =   ['client', 'manager', 'title', 'description', 'status', 'start_date', 'end_date'];
@endphp
<div class="modal fade" id="view-task-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('View Task Detail') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <!-- TASK INFO -->
                    <div id="task_view_data">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
