@extends('layouts.app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Users
                    <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create_modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                        <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                    </a>
                </h5>
                <div id="table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.user.create')
@endsection
@section('js')
    <script>

        $(document).ready(function()
        {
            setTimeout(function()
            {
                fetch_data(1);
            }, 100);
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

        function show_fields(x)
        {
            var role    =   x.value;

            if(role == '4')
            {
                $("#show_hidden_fields").removeClass('d-none');
            }
            else
            {
                $("#show_hidden_fields").addClass('d-none');
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
                        let my_array    =   ['name', 'email', 'contact', 'password', 'address', 'role', 'company_name', 'company_contact', 'company_address'];
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
    </script>
@endsection
