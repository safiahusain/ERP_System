@extends('layouts.app')
@php
    $target = 'invoice';
@endphp
@section('css')
    <style>
        .invoice-card {
            padding: 20px;
        }

        /* HEADER */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .invoice-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .invoice-header span {
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
        .invoice-grid {
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
                <h5 class="card-header header-primary">Invoices
                    @if (array_key_exists("INVOICECRT",$auth->func))
                        <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-invoice-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                            <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                        </a>
                    @endif
                </h5>
                <div id="invoice-table-data">

                </div>
            </div>
        </div>
    </div>
    @include('includes.models.invoice.create')
    @include('includes.models.invoice.update')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let my_array    =   ['project', 'client', 'amount', 'due_date'];
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

        function assign_to_update(x, invoice)
        {
            let my_from     =   $("#update-invoice-form");
            var url         =   "{{ route('invoice-update', ':id') }}";
            url             =   url.replace(':id', invoice.id);
            let type        =   'update_';

            clear_fields(my_array,type);
            $("#project_update").val(invoice.project_id).trigger('change');
            $("#client_update").val(invoice.client_id).trigger('change');
            $("#amount_update").val(invoice.total);
            $("#description_update").val(invoice.description);
            initDatePicker("#due_date_update").setDate(invoice.due_date);

            my_from.attr("action",url);
            $("#update-invoice-modal").modal('show');
        }

        function get_data_to_view(x)
        {
            let id      =   $(x).attr('data-id');
            var route   =   "{{ route('payment-index', ':id') }}";
            route       =   route.replace(':id', id);

            window.location.href = route;
        }
    </script>
@endsection
