@extends('layouts.app')
@php
    $target = 'user';
@endphp
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Users
                    @if (array_key_exists("USERCRT",$auth->func))
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-user-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="user-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.user.create')
    @include('includes.models.user.update')
    @include('includes.models.user.assign-user')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let my_array    =   ['name', 'email', 'contact', 'password', 'address', 'role'];
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

        function assign_to_update(x, user)
        {
            let my_from     =   $("#update-user-form");
            var url         =   "{{ route('user-update', ':id') }}";
            url             =   url.replace(':id', user.id);
            let type        =   'update_';
            let role        =   user.role;

            clear_fields(my_array,type);
            $("#name_update").val(user.name);
            $("#email_update").val(user.email);
            $("#email_update").val(user.email);
            $("#contact_update").val(user.phone);
            $("#address_update").val(user.address);
            $("#role_update").val(role.name).trigger("change");

            my_from.attr("action",url);
            $("#update-user-modal").modal('show');
        }

        function set_active_toggle(x)
        {
            let user_id         =   $(x).attr('user_id');
            let status          =   x.checked;
            var assets_route    =   "{{route('set-active-toggle',['id'=>':id','status'=>':status'])}}";
            assets_route        =   assets_route.replace(':id',user_id);
            assets_route        =   assets_route.replace(':status',status);

            $.ajax(
            {
                url         :   assets_route,
                type        :   'get',
                success: function(success_resp)
                {
                    fetch_data(1,target);
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                },
                error: function(error_resp)
                {
                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            });
        }

        function showUserAssignments(x,user)
        {
            let target          =   $(x);
            var route           =   "{{ route('show-user-assign', ':id') }}";
            route               =   route.replace(':id', user.id);
            var method_modal    =   $("#update_action_modal");
            selectedIds         =   [];

            $.ajax(
            {
                method      :   "GET",
                url         :   route,
                "_token"    :   "{{ csrf_token() }}",
                success     :   function(success_response)
                {
                    let my_form     =   $("#user_assign_form");
                    var action_route=   "{{ route('store-user-assign', ':id') }}";
                    action_route    =   action_route.replace(':id', user.id);
                    console.log(success_response.htm_text);
                    $("#user_assign_div").empty().html(success_response.htm_text);
                    const checkboxes    =   document.querySelectorAll('.user_checkbox');

                    checkboxes.forEach(checkbox =>
                    {
                        var func_id = checkbox.getAttribute('data-id');

                        if (checkbox.checked && !selectedIds.includes(func_id))
                        {
                            selectedIds.push(parseInt(func_id));
                        }
                    });

                    $('#assign_ids').val(selectedIds);
                    my_form.attr("action",action_route);
                    $('#user_assign_modal').modal('show');
                },
                error       :   function(error_resp)
                {
                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            })
        }

        function get_ids(x,id)
        {
            if (x.checked)
            {
                if (!selectedIds.includes(id))
                {
                    selectedIds.push(id);
                }
            }
            else
            {
                selectedIds = selectedIds.filter(item => item !== id);
            }

            console.log(selectedIds);
            $("#assign_ids").val(selectedIds);
        }

        $(document).on('submit', '#user_assign_form', function(event)
        {
            event.preventDefault();

            let my_form         =   $("#user_assign_form");
            let data            =   my_form.serialize();
            let route           =   my_form.attr("action");
            let edit_btn        =   $("#user_assign_btn");
            let btn_text        =   edit_btn.html();

            edit_btn.empty().html("<div class='btn_loader'></div>");
            edit_btn.attr( "disabled", "disabled" );

            $.ajax(
            {
                url     :   route,
                type    :   'post',
                data    :   data,
                success :   function(success_resp)
                {
                    selectedIds =  [];
                    $("#webhook_release_tx_id").val(null);
                    $("#assign_ids").val(" ");
                    $("input[type=checkbox]").prop('checked', false);
                    edit_btn.empty().html(btn_text);
                    edit_btn.removeAttr( "disabled", "disabled" );
                    fetch_data(1,target);
                    $('#user_assign_modal').modal('hide');
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());

                },
                error   :   function(error_resp)
                {
                    edit_btn.empty().html(btn_text);
                    edit_btn.removeAttr( "disabled", "disabled" );
                    let data    =   error_resp.responseJSON;
                    toastr[data.type](data.message,data.type.toUpperCase());
                }
            });

        });

    </script>
@endsection
