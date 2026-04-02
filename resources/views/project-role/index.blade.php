@extends('layouts.app')
@php
    $target = 'project-role';
@endphp

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Project Roles
                    @if (array_key_exists("PROJECTCRT",$auth->func))
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create_project_role_modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="project-role-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.project-role.create')
    @include('includes.models.project-role.update')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let my_array    =   ['name'];
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
        });

        $('.select2').select2();
        $('.select2bs4').select2(
        {
            theme : 'bootstrap4'
        });

        function assign_to_update(x, project_role)
        {
            let my_form     = $("#update-project-role-form");
            var url         = "{{ route('project-role-update', ':id') }}";
            url             = url.replace(':id', project_role.id);
            let type        = 'update_';

            clear_fields(my_array,type);

            $("#name_update").val(project_role.name);

            my_form.attr("action",url);
            console.log(my_form);
            $("#update-project-role-modal").modal('show');
        }
    </script>
@endsection
