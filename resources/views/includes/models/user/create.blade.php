@php
    $my_array   =   ['name', 'email', 'contact', 'password', 'address'];
@endphp
<div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create User') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="create_user_form" class="create_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            @include('includes.models.create-field', [
                                'fields' => ['name', 'email', 'contact', 'password', 'address'],
                                'col' => 'col-md-6 col-12',
                                'target' => 'create'
                            ])

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Role') }}</label>
                                    <select class='form-control select2' name='role' onchange="show_fields(this, 'create')" style="width: 100%">
                                        <option disabled selected>{{ __('Select User') }}</option>
                                        @foreach ($roles as $key => $role)
                                            @if ($role['tag'] != "super_admin")
                                                <option value="{{ $role['tag'] }}">{{ $role['name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="create_role"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger">{{ __('Cancel') }}</button>
                            <button type="submit" id="create_user_btn" data-route="{{ route('user-create') }}" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
