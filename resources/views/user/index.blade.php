@extends('layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Users
                    @if (array_key_exists("USERCRT",$auth->func))
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
    @include('includes.models.user.create')
    @include('includes.models.user.update')
    @include('includes.models.user.assign-user')
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let my_array    =   ['name', 'email', 'contact', 'password', 'address', 'role', 'company_name', 'company_contact', 'company_address'];

        $(document).ready(function()
        {
            setTimeout(function()
            {
                fetch_data(1);
            }, 100);
        });

        function fetch_data(page)
        {
            // loader_on();

            var next_url    = "{{route('user-index')}}";

            $.ajax(
            {
                url         :   next_url,
                type        :   "get",
                datatype    :   "html",
                success     :   function(success_response)
                {
                    $('#table-data').empty().html(success_response);
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

        function show_fields(x, target)
        {
            var role    =   x.value;

            $("#show_hidden_fields_" + target).addClass('d-none');

            if(role == 'client')
            {
                $("#show_hidden_fields_" + target).removeClass('d-none');
            }
        }

        $(document).on('submit', '#create_user_form', function(event)
        {
            event.preventDefault();

            let data        =   $("#create_user_form").serialize();
            let create_btn  =   $("#create_user_btn");
            let route       =   "{{ route('user-create') }}";
            let btn_text    =   create_btn.html();

            create_btn.empty().html("<div class='btn_loader'></div>");
            create_btn.attr( "disabled", "disabled" );

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
                    create_btn.empty().html(btn_text);
                    create_btn.removeAttr( "disabled", "disabled" );
                    toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
                    $('#create_modal').modal('hide');
                    setTimeout(function() {
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }, 200);
                    $("#create_user_form")[0].reset();
                    page        =   1;
                    fetch_data(page);
                },
                error   : function(error_resp)
                {
                    // loader_off();
                    create_btn.empty().html(btn_text);
                    create_btn.removeAttr( "disabled", "disabled" );

                    if (error_resp.status   ==  422)
                    {
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

        function assign_to_update(x, user)
        {
            let my_from     =   $("#update_user_form");
            var url         =   "{{ route('user-update', ':id') }}";
            url             =   url.replace(':id', user.id);
            let type        =   'update_';

            if (user.is_system == 1)
            {
                $("#tag_update").attr("readonly", true);
                $("#update_linked_user_div").addClass('d-none');
            }
            else
            {
                $("#tag_update").attr("readonly", false);
                $("#update_linked_user_div").removeClass('d-none');
                $("#linked_user").val(user.linked_user_tag).trigger("change");
            }

            clear_fields(my_array,type);
            $("#name_update").val(user.name);
            $("#email_update").val(user.email);
            $("#email_update").val(user.email);
            $("#contact_update").val(user.contact);
            $("#address_update").val(user.address);
            $("#role_update").val(user.role).trigger("change");
            // $("#team_lead_update").val(user.role).trigger("change");
            $("#company_name_update").val(user.company_name);
            $("#company_contact_update").val(user.company_contact);
            $("#company_address_update").val(user.company_address);
            my_from.attr("action",url);
            $("#update_modal").modal('show');
        }

        // $(document).on('submit', '#update_user_form', function(event)
        // {
        //     event.preventDefault();

        //     let my_form     =   $("#update_user_form");
        //     let data        =   my_form.serialize();
        //     let route       =   my_form.attr("action");
        //     let btn         =   "update_user_btn";
        //     let btn_text    =   $("#"+btn).html();

        //     animate_btn(btn,btn_text,'load');

        //     // loader_on();

        //     $.ajax(
        //     {
        //         url     :   route,
        //         type    :   'post',
        //         data    :   data,
        //         success: function(success_resp)
        //         {
        //             fetch_data(1);
        //             animate_btn(btn,btn_text,'remove');
        //             // loader_off();
        //             $('#update_modal').modal('hide');
        //             $("#update_user_form")[0].reset();
        //             toastr[success_resp.type](success_resp.message,success_resp.type.toUpperCase());
        //         },
        //         error: function(error_resp)
        //         {
        //             // loader_off();
        //             animate_btn(btn,btn_text,'remove');

        //             if (error_resp.status   ==  422)
        //             {
        //                 let my_array    =   ['name', 'tag'];
        //                 let type        =   'update_';
        //                 var obj         =   error_resp.responseJSON.errors;

        //                 validate_fields(my_array,type,obj)
        //             }
        //             else
        //             {
        //                 let data    =   error_resp.responseJSON;
        //                 toastr[data.type](data.message,data.type.toUpperCase());
        //             }
        //         }
        //     });
        // });

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

                    $('#user_ids').val(selectedIds);
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

            $("#user_ids").val(selectedIds);
        }
    </script>
@endsection
