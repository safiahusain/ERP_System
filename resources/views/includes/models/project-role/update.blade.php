@php
    $my_array    =   ['name'];
@endphp
<div class="modal fade" id="update-project-role-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Update Project Role') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="update-project-role-form" class="update_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">
                            @include('includes.models.create-field', [
                                'fields' => ['name'],
                                'col' => 'col-md-12 col-12',
                                'target' => 'update'
                            ])
                        </div>
                        <hr>
                        <div class="float-right">
                            <button type="button" class="btn-modern btn-danger" data-dismiss="modal">{{__("Cancel")}}</button>
                            <button type="submit" id="update_project_role_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
