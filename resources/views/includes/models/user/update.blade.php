@php
    $my_array   =   ['name', 'email', 'contact', 'address'];
@endphp
<div class="modal" tabindex="-1" id="update-user-modal" role="dialog" aria-labelledby="pendingTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Update User') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="update-user-form" class="update_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            @include('includes.models.create-field', [
                                'fields' => ['name', 'email', 'contact', 'address'],
                                'col' => 'col-md-6 col-12',
                                'target' => 'update'
                            ])

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Role') }}</label>
                                    <select class='form-control select2' id="role_update" name='role' onchange="show_fields(this, 'update')" style="width: 100%">
                                        <option disabled selected>{{ __('Select User') }}</option>
                                        @foreach ($roles as $key => $role)
                                            @if ($role['tag'] != "super_admin")
                                                <option value="{{ $role['tag'] }}">{{ $role['name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="update_role"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger">{{ __('Cancel') }}</button>
                            <button type="submit" id="update_user_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
