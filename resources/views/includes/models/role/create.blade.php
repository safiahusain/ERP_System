<div class="modal" tabindex="-1" id="create_modal" role="dialog" aria-labelledby="pendingTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Role') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" id="create_role_form">
                        @csrf
                        @include('includes.models.create-field', [
                            'fields' => ['name', 'tag'],
                            'col' => 'col-md-12 col-12',
                            'target' => 'create'
                        ])

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label>{{ __('Role') }}</label>
                                <select class='form-control select2' name='linked_role' style="width: 100%">
                                    <option disabled selected>{{ __('Select User') }}</option>
                                    @foreach (config('defaults.roles') as $key => $role)
                                        @if ($key != "super_admin")
                                            <option value="{{ $key }}">{{ $role }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-danger" id="create_linked_role"></small>
                            </div>
                        </div>

                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" id="create_role_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
