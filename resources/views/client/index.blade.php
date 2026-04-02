@extends('layouts.app')
@php
    $target = 'client';
@endphp
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">Clients
                    @if (array_key_exists("CLIENTCRT",$auth->func))
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-client-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="client-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.client.create')
    @include('includes.models.client.update')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let my_array    =   ['name', 'email', 'contact', 'password', 'address', 'role', 'company_name', 'company_contact', 'company_address'];
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

        function assign_to_update(x, client)
        {
            let my_from         =   $("#update-client-form");
            var url             =   "{{ route('client-update', ':id') }}";
            url                 =   url.replace(':id', client.id);
            let type            =   'update_';
            let role            =   client.role;
            let client_detail   =   client.detail;

            clear_fields(my_array,type);
            $("#name_update").val(client.name);
            $("#email_update").val(client.email);
            $("#email_update").val(client.email);
            $("#contact_update").val(client.phone);
            $("#address_update").val(client.address);

            if(client_detail)
            {
                $("#company_name_update").val(client_detail.company_name);
                $("#company_contact_update").val(client_detail.company_contact);
                $("#company_address_update").val(client_detail.company_address);
            }

            my_from.attr("action",url);
            $("#update-client-modal").modal('show');
        }

        function set_active_toggle(x)
        {
            let client_id       =   $(x).attr('client_id');
            let status          =   x.checked;
            var assets_route    =   "{{route('set-active-toggle',['id'=>':id','status'=>':status'])}}";
            assets_route        =   assets_route.replace(':id',client_id);
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
    </script>
@endsection
