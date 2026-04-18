@php
    $my_array   =   ['project', 'client', 'amount', 'due_date'];
@endphp
<div class="modal" tabindex="-1" id="update-invoice-modal" role="dialog" aria-labelledby="pendingTransactionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Update Invoice') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="update-invoice-form" class="update_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>{{ __('Project') }}</label>
                                    <select class='form-control select2' id="project_update" name='project' style="width: 100%">
                                        <option disabled selected>{{ __('Select Project') }}</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project['id'] }}">{{ $project['title'] }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="update_project"></small>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label>{{ __('Client') }}</label>
                                    <select class='form-control select2' id="client_update" name='client' style="width: 100%">
                                        <option disabled selected>{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client['id'] }}">{{ $client['email'] }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="update_client"></small>
                                </div>
                            </div>

                            @include('includes.models.create-field', [
                                'fields' => ['amount', 'description'],
                                'col' => 'col-md-12 col-12',
                                'target' => 'update'
                            ])

                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                   <label>Due Date</label>
                                    <div class="date-wrapper">
                                        <input type="text" id="due_date_update" name="due_date"
                                            class="form-control modern-date due_date"
                                            placeholder="Select Due Date">

                                        <i class="fa-solid fa-calendar calendar-icon"></i>
                                    </div>
                                    <small class="text-danger" id="update_due_date"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger">{{ __('Cancel') }}</button>
                            <button type="submit" id="update_invoice_btn" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
