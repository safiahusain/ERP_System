@extends('layouts.app')
@php
    $target = 'payment';
@endphp
@section('css')
    <style>
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .badge-paid {
            background: #d1f7e1;
            color: #0f9d58;
        }

        .badge-partial {
            background: #fff4cc;
            color: #f4b400;
        }

        .badge-unpaid {
            background: #fde2e2;
            color: #d93025;
        }

        .table-modern thead {
            background: #f8f9fa;
        }

        .table-modern tbody tr:hover {
            background: #f1f3f5;
            transition: 0.2s;
        }

        .btn-custom {
            border-radius: 8px;
            padding: 6px 14px;
        }

        .section-title {
            font-weight: 600;
            font-size: 18px;
        }
    </style>
@endsection
@section('content')
    <div class="container py-4">

        <!-- Invoice Card -->
        <div class="card card-custom mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Invoice #{{ $invoice->id }}</h4>

                    <span class="badge
                        @if($invoice->status == 'Paid') badge-paid
                        @elseif($invoice->status == 'Partial') badge-partial
                        @else badge-unpaid @endif">
                        {{ $invoice->status }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Client:</strong> {{ $invoice->client->name }}</p>
                        <p><strong>Date:</strong> {{ $invoice->date }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><strong>Total:</strong> ${{ number_format($invoice->total_amount, 2) }}</p>
                        <p><strong>Paid:</strong> ${{ $invoice->payments->sum('amount') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Payments</h3>
                @if (array_key_exists("PAYMENTCRT",$auth->func))
                    <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-payment-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                        <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                    </a>
                @endif
            </div>

            <div id="invoice-table-data">

            </div>
        </div>
    </div>
    @include('includes.models.payment.create')
    @include('includes.models.payment.update')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let selectedIds =   [];
        let my_array    =   ['project', 'assigned_by', 'assigned_to', 'title', 'description', 'priority', 'status', 'due_date', 'completed_at'];
        let id          =   "{{$id}}";

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

            initDatePicker("#due_date_create");
        });

        $('.select2').select2();
        $('.select2bs4').select2(
        {
            theme : 'bootstrap4'
        });

        function fetch_data(page)
        {
            var route   =   "{{ route('payment-index', ':id') }}";
            route       =   route.replace(':id', id);

            $.ajax(
            {
                url         :   route+"?page="+page,
                type        :   "get",
                datatype    :   "html",
                success     :   function(success_response)
                {
                    $('#payment-table-data').empty().html(success_response);


                    $("input[data-bootstrap-switch]").each(function()
                    {
                        $(this).bootstrapSwitch();
                    });
                },
                error       :   function(error_response)
                {
                    toastr['error']('Server error','Error');
                }
            });
        }

        function assign_to_update(x, invoice)
        {
            let my_from     =   $("#update-invoice-form");
            var url         =   "{{ route('invoice-update', ':id') }}";
            url             =   url.replace(':id', invoice.id);
            let type        =   'update_';

            clear_fields(my_array,type);
            $("#project_update").val(invoice.project_id).trigger('change');
            $("#assigned_to_update").val(invoice.assigned_to).trigger('change');
            $("#title_update").val(invoice.title);
            $("#description_update").val(invoice.description);
            $("#priority_update").val(invoice.priority).trigger('change');
            $("#status_update").val(invoice.status).trigger('change');
            $("#due_date_update").val(invoice.due_date).trigger('change');
            initDatePicker("#due_date_update").setDate(invoice.due_date);
            initDatePicker("#completed_at_update").setDate(invoice.completed_at);

            my_from.attr("action",url);
            $("#update-invoice-modal").modal('show');
        }

        function get_data_to_view_invoice(x)
        {
            let invoice        =   $(x).data('invoice');
            let status      =   @json(config('defaults.status'));
            let priority    =   @json(config('defaults.priority'));
            let html_data   =   `<div class="invoice-card">
                                    <!-- HEADER -->
                                    <div class="invoice-header">
                                        <div>
                                            <h5>${invoice.title}</h5>
                                            <span style="color: #888;">Task Details</span>
                                        </div>

                                        <div class="badges">
                                            <span class="badge ${status[invoice.status].class}">
                                                <i class="${status[invoice.status].icon}"></i>
                                                ${invoice.status.replaceAll('_',' ').toUpperCase()}
                                            </span>

                                            <span class="badge ${priority[invoice.priority].class}">
                                                <i class="${priority[invoice.priority].icon}"></i>
                                                ${invoice.priority.toUpperCase()}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="divider"></div>

                                    <!-- GRID -->
                                    <div class="invoice-grid">
                                        <div>
                                            <label>Project</label>
                                            <p>${invoice.project?.title ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Due Date</label>
                                            <p>${invoice.due_date ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Assigned By</label>
                                            <p>${invoice.assigned?.name ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Assigned To</label>
                                            <p>${invoice.assignee?.name ?? '-'}</p>
                                        </div>
                                        <div>
                                            <label>Completed At</label>
                                            <p>${invoice.completed_at ?? 'Not completed'}</p>
                                        </div>
                                    </div>

                                    <!-- DESCRIPTION -->
                                    <div class="description">
                                        <label>Description</label>
                                        <p>${invoice.description ?? '-'}</p>
                                    </div>

                                </div>`;
            $("#invoice_view_data").html(html_data);
            $("#view-invoice-modal").modal('show');
        }
    </script>
@endsection
