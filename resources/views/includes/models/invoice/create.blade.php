@php
    $my_array   =   ['project', 'assigned_by', 'assigned_to', 'title', 'description', 'priority', 'status', 'due_date', 'completed_at'];
@endphp
<div class="modal fade" id="create-invoice-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Invoice') }}</h5>
                <img src="{{ asset('images/icons/cross.png') }}" class="filters-btn" data-dismiss="modal"
                    aria-label="Close">
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" id="create_invoice_form" class="create_form" data-target="{{$target}}" data-array='@json($my_array)'>
                        @csrf
                        <div class="row">

                            @include('includes.models.create-field', [
                                'fields' => ['title', 'description'],
                                'col' => 'col-md-6 col-12',
                                'target' => 'create'
                            ])

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Priority') }}</label>
                                    <select class='form-control select2' name='priority' style="width: 100%">
                                        <option disabled selected>{{ __('Select Priority') }}</option>
                                        <option value="low">{{ __('Low') }}</option>
                                        <option value="high">{{ __('High') }}</option>
                                    </select>
                                    <small class="text-danger" id="create_priority"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Status') }}</label>
                                    <select class='form-control select2' name='status' style="width: 100%">
                                        <option disabled selected>{{ __('Select Status') }}</option>
                                        <option value="pending">{{ __('Pending') }}</option>
                                        <option value="in_progress">{{ __('In Progress') }}</option>
                                        <option value="testing">{{ __('Testing') }}</option>
                                        <option value="completed">{{ __('Completed') }}</option>
                                    </select>
                                    <small class="text-danger" id="create_status"></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Project') }}</label>
                                    <select class='form-control select2' name='project' style="width: 100%">
                                        <option disabled selected>{{ __('Select Project') }}</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project['id'] }}">{{ $project['title'] }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="create_project"></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label>{{ __('Assign To') }}</label>
                                    <select class='form-control select2' name='assigned_to' style="width: 100%">
                                        <option disabled selected>{{ __('Select Team Member') }}</option>
                                        @foreach ($team_members as $member)
                                            <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="create_assigned_to"></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                   <label>Due Date</label>
                                    <div class="date-wrapper">
                                        <input type="text" id="due_date_create" name="due_date"
                                            class="form-control modern-date due_date"
                                            placeholder="Select Due Date">

                                        <i class="fa-solid fa-calendar calendar-icon"></i>
                                    </div>
                                    <small class="text-danger" id="create_due_date"></small>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="float-right">
                            <button class="btn-modern btn-danger">{{ __('Cancel') }}</button>
                            <button type="submit" id="create_invoice_btn" data-route="{{ route('invoice-create') }}" class="btn-modern btn-success">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
