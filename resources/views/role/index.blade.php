@extends('layouts.app')
@php
    $target = 'role';
@endphp
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Roles
                    @if (array_key_exists("ROLECRT",$auth->func) || $auth->role == "super_admin")
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-role-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="role-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.role.create')
    @include('includes.models.role.update')
    @include('includes.models.role.update-action')
    @include('includes.models.delete-recode', [
            'target' => $target
        ])
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let page        =   1;
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

        function assign_to_update(x, role)
        {
            let my_from     =   $("#update-role-form");
            var url         =   "{{ route('role-update', ':id') }}";
            url             =   url.replace(':id', role.id);
            let my_array    =   ['name','tag'];
            let type        =   'update_';

            if (role.is_system == 1)
            {
                $("#tag_update").attr("readonly", true);
                $("#update_linked_role_div").addClass('d-none');
            }
            else
            {
                $("#tag_update").attr("readonly", false);
                $("#update_linked_role_div").removeClass('d-none');
                $("#linked_role").val(role.linked_role_tag).trigger("change");
            }

            clear_fields(my_array,type);
            $("#name_update").val(role.name);
            $("#tag_update").val(role.tag);
            my_from.attr("action",url);
            $("#update-role-modal").modal('show');
        }

        function assign_to_update_permission(x,role)
        {
            let target          =   $(x);
            var route           =   "{{ route('get-role-action', ':id') }}";
            route               =   route.replace(':id', role.id);
            var method_modal    =   $("#update_action_modal");
            selectedIds         =   [];

            $.ajax(
            {
                method      :   "GET",
                url         :   route,
                "_token"    :   "{{ csrf_token() }}",
                success     :   function(success_response)
                {
                    let my_form     =   $("#update_role_action_form");
                    var action_route=   "{{ route('update-role-actions', ':id') }}";
                    action_route    =   action_route.replace(':id', role.id);
                    $("#role_action").empty().html(success_response.htm_text);
                    const checkboxes= document.querySelectorAll('.action_checkbox');

                    checkboxes.forEach(checkbox =>
                    {
                        var func_id = checkbox.getAttribute('data-id');

                        if (checkbox.checked && !selectedIds.includes(func_id))
                        {
                            selectedIds.push(parseInt(func_id));
                        }
                    });

                    $('#action_ids').val(selectedIds);
                    my_form.attr("action",action_route);
                    $('#update_action_modal').modal('show');
                },
                error       :   function(error_resp)
                {
                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            })
        }

        $(document).on('change', '.child-check', function()
        {
            let childId  = parseInt($(this).data('id'));
            let group = $(this).data('parent'); // numeric or sanitized string
            let parent = $('#parent_' + group);
            let parentId = parseInt(parent.data('id'));

            if ($(this).prop('checked'))
            {
                if (!selectedIds.includes(childId))
                    selectedIds.push(childId);

                parent.prop('checked', true);

                if (!selectedIds.includes(parentId))
                    selectedIds.push(parentId);
            }
            else
            {
                selectedIds = selectedIds.filter(id => id !== childId);
            }

            updateHiddenInput();
        });

        $(document).on('change', '.parent-check', function ()
        {
            let group     = $(this).data('group');
            let parentId  = parseInt($(this).data('id')); // ✅ FIX
            let isChecked = $(this).prop('checked');

            if (isChecked)
            {
                if (!selectedIds.includes(parentId))
                    selectedIds.push(parentId);

                // check all children
                $('.child_' + group).each(function ()
                {
                    let childId = parseInt($(this).data('id'));
                    $(this).prop('checked', true);

                    if (!selectedIds.includes(childId))
                        selectedIds.push(childId);
                });
            }
            else
            {
                selectedIds = selectedIds.filter(id => id !== parentId);

                $('.child_' + group).each(function ()
                {
                    let childId = parseInt($(this).data('id'));
                    $(this).prop('checked', false);
                    selectedIds = selectedIds.filter(id => id !== childId);
                });
            }

            updateHiddenInput();
        });

        function updateHiddenInput()
        {
            $('#action_ids').val(selectedIds);
        }

        $(document).on('submit', '#update_role_action_form', function(event)
        {
            event.preventDefault();

            let my_form     =   $("#update_role_action_form");
            let data        =   my_form.serialize();
            let route       =   my_form.attr("action");
            let btn         =   "update_role_action_btn"
            let btn_text    =   $("#"+btn).html();

            animate_btn(btn,btn_text,'load');

            // loader_on();

            $.ajax(
            {
                url     :   route,
                type    :   'post',
                data    :   data,
                success: function(success_resp)
                {
                    animate_btn(btn,btn_text,'remove');
                    // loader_off();
                    fetch_data(1,target);
                    $("#role_ids").val(" ");
                    $('#update_action_modal').modal('hide');
                    $("#update_role_action_form")[0].reset();
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                },
                error: function(error_resp)
                {
                    // loader_off();
                    animate_btn(btn,btn_text,'remove');

                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            });
        });
    </script>
@endsection
