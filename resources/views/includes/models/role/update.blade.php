@php
    $my_array   =   ['name', 'tag', 'linked_role'];
@endphp
<div class="modal" tabindex="-1" id="update-role-modal" role="dialog" aria-labelledby="pendingTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Update Role') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="update_role_form" class="update_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        @include('includes.models.create-field', [
                            'fields' => ['name', 'tag'],
                            'col' => 'col-md-12 col-12',
                            'target' => 'update'
                        ])

                        <div class="col-md-12 col-12 d-none" id="update_linked_role_div">
                            <div class="form-group">
                                <label>{{ __('Role') }}</label>
                                <select class='form-control select2' id="linked_role" name='linked_role' style="width: 100%">
                                    <option disabled selected>{{ __('Select User') }}</option>
                                    @foreach (config('defaults.roles') as $key => $role)
                                        @if ($key != "super_admin")
                                            <option value="{{ $key }}">{{ $role }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger" id="update_linked_role"></small>
                            </div>
                        </div>

                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" id="update_role_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
