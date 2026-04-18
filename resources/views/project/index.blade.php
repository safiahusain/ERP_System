@extends('layouts.app')

@php
    $target = 'project';
@endphp
@section('css')
    <style>
        table {
            table-layout: fixed; /* important */
            width: 100%;
        }

        td, th {
            word-wrap: break-word; /* old support */
            word-break: break-word;
            white-space: normal;  /* ensure wrap allowed */
            max-width: 200px;     /* adjust per column */
        }
    </style>
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">projects
                    @if (array_key_exists("PROJECTCRT",$auth->func))
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-project-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="project-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.project.create')
    @include('includes.models.project.update')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let my_array    =   ['client', 'manager', 'title', 'description', 'status', 'start_date', 'end_date'];
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

            initDatePicker("#start_date_create");
            initDatePicker("#end_date_create");
        });

        $('.select2').select2();
        $('.select2bs4').select2(
        {
            theme : 'bootstrap4'
        });

        function assign_to_update(x, project)
        {
            let my_form =   $("#update-project-form");
            var url     =   "{{ route('project-update', ':id') }}";
            url         =   url.replace(':id', project.id);
            let type    =   'update_';

            clear_fields(my_array,type);

            $("#client_update").val(project.client_id).trigger('change');
            $("#manager_update").val(project.manager_id).trigger('change');
            $("#title_update").val(project.title);
            $("#description_update").val(project.description);
            $("#status_update").val(project.status).trigger("change");

            // Set start and end dates

            initDatePicker("#start_date_update").setDate(project.start_date);
            initDatePicker("#end_date_update").setDate(project.end_date);

            my_form.attr("action",url);
            console.log(my_form);
            $("#update-project-modal").modal('show');
        }

        function get_data_to_view(x)
        {
            let id      =   $(x).attr('data-id');
            var route   =   "{{ route('project-view', ':id') }}";
            route       =   route.replace(':id', id);

            window.location.href = route;
        }
    </script>
@endsection
