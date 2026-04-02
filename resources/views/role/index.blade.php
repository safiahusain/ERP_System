@extends('layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Roles
                    @if (array_key_exists("ROLECRT",$auth->func) || $auth->role == "super_admin")
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create_modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.role.create')
    @include('includes.models.role.update')
    @include('includes.models.role.update-action')
    @include('includes.models.role.delete')
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let page        =   1;

        $(document).ready(function()
        {
            setTimeout(function()
            {
                fetch_data(1);
            }, 100);

            $(document).on('click', '.pagination a', function(event)
            {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var my_url  =   $(this).attr('href');
                var page    =   $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });
        });

        function clear_data(x)
        {
            let modal_name = $(x).attr('data-target');

            $(modal_name).find('input').val('');
            $(modal_name).find('select').prop('selectedIndex', 0).trigger('change');
        }

        function fetch_data(page)
        {
            // loader_on();

            var next_url    =   "{{route('role-index')}}?page="+page;

            $.ajax(
            {
                url         :   next_url,
                type        :   "get",
                datatype    :   "html",
                success     :   function(success_response)
                {
                    $('#table-data').empty().html(success_response);
                    location.hash   =   page;
                    // loader_off();
                },
                error       :   function(error_response)
                {
                    // loader_off();
                    toastr['error']('Server error','Error');
                }
            });
        }

        $('.select2').select2();
        $('.select2bs4').select2(
        {
            theme : 'bootstrap4'
        });

        $(document).on('submit', '#create_role_form', function(event)
        {
            event.preventDefault();

            let data        =   $("#create_role_form").serialize();
            let btn         =   "create_role_btn";
            let route       =   "{{ route('role-create') }}";
            let btn_text    =   $("#"+btn).html();

            animate_btn(btn,btn_text,'load');

            // loader_on();

            $.ajax(
            {
                url     :   route,
                type    :   'post',
                headers :   {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data    :   data,
                success :   function(success_resp)
                {
                    animate_btn(btn,btn_text,'remove');
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                    $('#create_modal').modal('hide');
                    setTimeout(function()
                    {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }, 200);
                    $("#create_role_form")[0].reset();
                    fetch_data(1);
                },
                error   : function(error_resp)
                {
                    // loader_off();
                    animate_btn(btn,btn_text,'remove');

                    if (error_resp.status   ==  422)
                    {
                        let my_array    =   ['name', 'tag'];
                        let type        =   'create_';
                        var obj         =   error_resp.responseJSON.errors;

                        validate_fields(my_array,type,obj)
                    }
                    else
                    {
                        let data    =   error_resp.responseJSON;
                        toastr[data.type](data.message,data.type.toUpperCase());
                    }
                }
            });

        });

        function assign_to_update(x, role)
        {
            let my_from     =   $("#update_role_form");
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
            $("#update_modal").modal('show');
        }

        $(document).on('submit', '#update_role_form', function(event)
        {
            event.preventDefault();

            let my_form     =   $("#update_role_form");
            let data        =   my_form.serialize();
            let route       =   my_form.attr("action");
            let btn         =   "update_role_btn";
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
                    fetch_data(1);
                    animate_btn(btn,btn_text,'remove');
                    // loader_off();
                    $('#update_modal').modal('hide');
                    $("#update_role_form")[0].reset();
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                },
                error: function(error_resp)
                {
                    // loader_off();
                    animate_btn(btn,btn_text,'remove');

                    if (error_resp.status   ==  422)
                    {
                        let my_array    =   ['name', 'tag'];
                        let type        =   'update_';
                        var obj         =   error_resp.responseJSON.errors;

                        validate_fields(my_array,type,obj)
                    }
                    else
                    {
                        let data    =   error_resp.responseJSON;
                        toastr[data.type](data.message,data.type.toUpperCase());
                    }
                }
            });
        });

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
            console.log(selectedIds);
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
                    fetch_data(1);
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

        $(document).on('click', '.deleteBtn', function(event)
        {
            let id = $(this).attr('id');
            $('#delete_role_id').val(id);
        });

        $(document).on('click', '#delete_role_btn', function(event)
        {
            let id              =   $('#delete_role_id').val();
            var delete_route    =   "{{ route('role-delete', ':id') }}";
            delete_route        =   delete_route.replace(':id', id);
            let btn             =   "delete_role_btn";
            let btn_text        =   $("#"+btn).html();

            animate_btn(btn,btn_text,'load');

            // loader_on();

            $.ajax(
            {
                url     :   delete_route,
                type    :   'get',
                headers :   {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success : function(success_resp)
                {
                    // loader_off();
                    animate_btn(btn,btn_text,'remove');
                    $('#delete_model').modal('hide');
                    setTimeout(function() {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }, 200);
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                    fetch_data(1);

                },
                error   : function(error_resp)
                {
                    // loader_off();
                    animate_btn(btn,btn_text,'remove');
                    $('#delete_model').modal('hide');
                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            });
        });
    </script>
@endsection
