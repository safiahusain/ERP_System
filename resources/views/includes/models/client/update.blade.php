@php
    $my_array   =   ['name', 'email', 'contact', 'address', 'company_name', 'company_contact', 'company_address'];
@endphp
<div class="modal" tabindex="-1" id="update-client-modal" role="dialog" aria-labelledby="pendingTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Update Client') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="update-client-form" class="update_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            @include('includes.models.create-field', [
                                'fields' => ['name', 'email', 'contact', 'address', 'company_name', 'company_contact', 'company_address'],
                                'col' => 'col-md-6 col-12',
                                'target' => 'update'
                            ])

                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger">{{ __('Cancel') }}</button>
                            <button type="submit" id="update_client_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
