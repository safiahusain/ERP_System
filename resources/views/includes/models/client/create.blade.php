@php
    $my_array   =   ['name', 'email', 'contact', 'password', 'address', 'company_name', 'company_contact', 'company_address'];
@endphp
<div class="modal fade" id="create-client-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Client') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="create_client_form" class="create_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            @include('includes.models.create-field', [
                                'fields' => ['name', 'email', 'contact', 'password', 'address', 'company_name', 'company_contact', 'company_address'],
                                'col' => 'col-md-6 col-12',
                                'target' => 'create'
                            ])

                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger">{{ __('Cancel') }}</button>
                            <button type="submit" id="create_client_btn" data-route="{{ route('client-create') }}" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
