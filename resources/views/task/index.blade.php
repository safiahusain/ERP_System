@extends('layouts.app')
@php
    $target = 'task';
@endphp
@section('css')
    <style>
        .task-card {
            padding: 20px;
        }

        /* HEADER */
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .task-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .task-header span {
            font-size: 13px;
        }

        /* BADGES */
        .badges .badge {
            margin-left: 6px;
            font-size: 11px;
            padding: 5px 8px;
        }

        /* DIVIDER */
        .divider {
            height: 1px;
            background: #eee;
            margin: 15px 0;
        }

        /* GRID */
        .task-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 30px;
        }

        /* LABEL + VALUE */
        label {
            font-size: 12px;
            color: #999;
            display: block;
            margin-bottom: 3px;
        }

        p {
            margin: 0;
            font-size: 15px;
            font-weight: 500;
            color: #222;
        }

        /* DESCRIPTION */
        .description {
            margin-top: 15px;
        }

        .description p {
            max-height: 90px;
            overflow-y: auto;
            line-height: 1.5;
            padding-right: 5px;
        }

        /* FOOTER */
        .footer {
            margin-top: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Tasks
                    @if (array_key_exists("TASKCRT",$auth->func))
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-task-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="task-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.task.create')
    @include('includes.models.task.update')
    @include('includes.models.task.view')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let my_array    =   ['project', 'assigned_by', 'assigned_to', 'title', 'description', 'priority', 'status', 'due_date', 'completed_at'];
        let target      =   "{{$target}}";

        $(document).ready(function()
        {
            setTimeout(function()
            {
                fetch_data(1,target);
            }, 100);

            $(document).on('click', '.pagination a', function(event)
            {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var my_url  =   $(this).attr('href');
                var page    =   $(this).attr('href').split('page=')[1];
                fetch_data(page,target);
            });

            initDatePicker("#due_date_create");
        });

        $('.select2').select2();
        $('.select2bs4').select2(
        {
            theme : 'bootstrap4'
        });

        function assign_to_update(x, task)
        {
            let my_from     =   $("#update-task-form");
            var url         =   "{{ route('task-update', ':id') }}";
            url             =   url.replace(':id', task.id);
            let type        =   'update_';

            clear_fields(my_array,type);
            $("#project_update").val(task.project_id).trigger('change');
            $("#assigned_to_update").val(task.assigned_to).trigger('change');
            $("#title_update").val(task.title);
            $("#description_update").val(task.description);
            $("#priority_update").val(task.priority).trigger('change');
            $("#status_update").val(task.status).trigger('change');
            $("#due_date_update").val(task.due_date).trigger('change');
            initDatePicker("#due_date_update").setDate(task.due_date);
            initDatePicker("#completed_at_update").setDate(task.completed_at);

            my_from.attr("action",url);
            $("#update-task-modal").modal('show');
        }

        function get_data_to_view_task(x)
        {
            let task        =   $(x).data('task');
            let status      =   @json(config('defaults.status'));
            let priority    =   @json(config('defaults.priority'));
            let html_data   =   `<div class="task-card">
                                    <!-- HEADER -->
                                    <div class="task-header">
                                        <div>
                                            <h5>${task.title}</h5>
                                            <span style="color: #888;">Task Details</span>
                                        </div>

                                        <div class="badges">
                                            <span class="badge ${status[task.status].class}">
                                                <i class="${status[task.status].icon}"></i>
                                                ${task.status.replaceAll('_',' ').toUpperCase()}
                                            </span>

                                            <span class="badge ${priority[task.priority].class}">
                                                <i class="${priority[task.priority].icon}"></i>
                                                ${task.priority.toUpperCase()}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="divider"></div>

                                    <!-- GRID -->
                                    <div class="task-grid">
                                        <div>
                                            <label>Project</label>
                                            <p>${task.project?.title ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Due Date</label>
                                            <p>${task.due_date ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Assigned By</label>
                                            <p>${task.assigned?.name ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Assigned To</label>
                                            <p>${task.assignee?.name ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Completed At</label>
                                            <p>${task.completed_at ?? 'Not completed'}</p>
                                        </div>
                                    </div>

                                    <!-- DESCRIPTION -->
                                    <div class="description">
                                        <label>Description</label>
                                        <p>${task.description ?? '-'}</p>
                                    </div>

                                </div>`;
            $("#task_view_data").html(html_data);
            $("#view-task-modal").modal('show');
        }
    </script>
@endsection
