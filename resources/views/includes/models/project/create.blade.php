@php
    $my_array    =   ['client', 'manager', 'title', 'description', 'status', 'start_date', 'end_date'];
@endphp
<div class="modal fade" id="create-project-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Project') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="create_project_form" class="create_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Client') }}</label>
                                    <select class='form-control select2' name='client' style="width: 100%">
                                        <option disabled selected>{{ __('Select Client') }}</option>
                                        @foreach ($clients as $key => $client)
                                            <option value="{{ $client['id'] }}">{{ $client['email'] }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="create_client"></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Manager') }}</label>
                                    <select class='form-control select2' name='manager' style="width: 100%">
                                        <option disabled selected>{{ __('Select Manager') }}</option>
                                        @foreach ($managers as $key => $manager)
                                            <option value="{{ $manager['id'] }}">{{ $manager['email'] }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="create_manager"></small>
                                </div>
                            </div>

                            @include('includes.models.create-field', [
                                'fields' => ['title', 'description'],
                                'col' => 'col-md-6 col-12',
                                'target' => 'create'
                            ])

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Status') }}</label>
                                    <select class='form-control select2' name='status' style="width: 100%">
                                        <option disabled selected>{{ __('Select Status') }}</option>
                                        <option value="pending">{{ __("Pending") }}</option>
                                        <option value="active">{{ __("Active") }}</option>
                                        <option value="completed">{{ __("Completed") }}</option>
                                    </select>
                                    <small class="text-danger" id="create_status"></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                   <label>Start Date</label>
                                    <div class="date-wrapper">
                                        <input type="text" id="start_date_create" name="start_date"
                                            class="form-control modern-date start_date"
                                            placeholder="Select Start Date">

                                        <i class="fa-solid fa-calendar calendar-icon"></i>
                                    </div>
                                    <small class="text-danger" id="create_start_date"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                   <label>End Date</label>
                                    <div class="date-wrapper">
                                        <input type="text" id="end_date_create" name="end_date"
                                            class="form-control modern-date end_date"
                                            placeholder="Select End Date">

                                        <i class="fa-solid fa-calendar calendar-icon"></i>
                                    </div>
                                    <small class="text-danger" id="create_end_date"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="float-right">
                            <button type="button" class="btn-modern btn-danger" data-dismiss="modal">{{__("Cancel")}}</button>
                            <button type="submit" id="create_project_btn" data-route="{{ route('project-create') }}" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
