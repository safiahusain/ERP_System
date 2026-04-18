@extends('layouts.app')

@php
    $target = 'payment';
@endphp

@section('css')
    <style>
        /* ================= HEADER ================= */
        .payment-header-card {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border-radius: 18px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .payment-header-card::after {
            content: "";
            position: absolute;
            right: -60px;
            top: -60px;
            width: 220px;
            height: 220px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }

        /* ================= CARDS ================= */
        .payment-stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #f1f5f9;
            transition: 0.3s;
        }

        .payment-stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* ================= ICON ================= */
        .icon-bg {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-bg.primary { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
        .icon-bg.success { background: rgba(22, 163, 74, 0.1); color: #16a34a; }
        .icon-bg.danger { background: rgba(220, 38, 38, 0.1); color: #dc2626; }

        /* ================= BADGE ================= */
        .status-badge {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 999px;
            font-weight: 600;
        }

        .status-paid { background: #dcfce7; color: #16a34a; }
        .status-partial { background: #fef9c3; color: #ca8a04; }
        .status-unpaid { background: #fee2e2; color: #dc2626; }

        /* ================= TABLE ================= */
        .payment-table-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
        }

        .payment-table thead {
            background: #f8fafc;
        }

        .payment-table th {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
        }

        .payment-table tbody tr {
            transition: 0.2s;
        }

        .payment-table tbody tr:hover {
            background: #f9fafb;
            transform: scale(1.01);
        }

        /* ================= PROGRESS ================= */
        .progress-bar-custom {
            height: 10px;
            border-radius: 10px;
            background: #f1f5f9;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, #22c55e, #4ade80);
        }

        /* ================= BUTTON ================= */
        .btn-primary {
            border-radius: 10px;
        }

        /* ================= SECTION ================= */
        .section-title {
            font-size: 20px;
            font-weight: 700;
        }

        .section-subtitle {
            font-size: 13px;
            color: #64748b;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">

    @if($id)
        <!-- HEADER -->
        <div class="payment-header-card mb-4 p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-1">Invoice #{{ $invoice->id }}</h4>
                    <small>{{ $invoice->client->name }}</small>

                    <div class="row mt-3">
                        <div class="col-4">
                            <small>Invoice Date</small>
                            <div>{{ $invoice->date }}</div>
                        </div>
                        <div class="col-4">
                            <small>Due Date</small>
                            <div>{{ $invoice->due_date ?? 'N/A' }}</div>
                        </div>
                        <div class="col-4">
                            <small>Project</small>
                            <div>{{ $invoice->project->title ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <h2 class="fw-bold">${{ number_format($invoice->total_amount,2) }}</h2>

                    <span class="status-badge
                        @if($invoice->status=='Paid') status-paid
                        @elseif($invoice->status=='Partial') status-partial
                        @else status-unpaid @endif">
                        {{ $invoice->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- STATS -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="payment-stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small>Total</small>
                            <h5>${{ number_format($invoice->total_amount,2) }}</h5>
                        </div>
                        <div class="icon-bg primary">
                            <i class="mdi mdi-currency-usd"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="payment-stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small>Paid</small>
                            <h5 class="text-success">
                                ${{ number_format($invoice->payments->sum('amount'),2) }}
                            </h5>
                        </div>
                        <div class="icon-bg success">
                            <i class="mdi mdi-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                @php
                    $total = $invoice->total_amount;
                    $paid  = $invoice->payments->sum('amount');
                    $percent = $total > 0 ? ($paid / $total) * 100 : 0;
                @endphp

                <div class="payment-stat-card">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small>Balance</small>
                            <h5 class="text-danger">
                                ${{ number_format($total - $paid,2) }}
                            </h5>
                        </div>
                        <div class="icon-bg danger">
                            <i class="mdi mdi-minus"></i>
                        </div>
                    </div>

                    <div class="progress-bar-custom mt-3">
                        <div class="progress-bar-fill" style="width: {{ $percent }}%"></div>
                    </div>
                    <small>{{ round($percent) }}% Paid</small>
                </div>
            </div>
        </div>
    @endif

    <!-- TABLE -->
    <div class="payment-table-card p-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h5 class="section-title">Payment History</h5>
                <small class="section-subtitle">Manage invoice payments</small>
            </div>

            @if (array_key_exists("PAYMENTCRT",$auth->func))
                <a href="javascript:void(0)" class="float-right data-value" data-toggle="modal" data-target="#create-payment-modal" onclick="clear_data(this)" title="{{ __('Create') }}">
                    <img src="{{asset('images/icons/create.png')}}" class="create-btn">
                </a>
            @endif
        </div>

        <div id="payment-table-data"></div>
    </div>

</div>

@include('includes.models.payment.create')
@include('includes.models.payment.update')
@include('includes.models.delete-recode',['target'=>$target])
@endsection


@section('js')
    <script>
        let id = "{{$id}}";

        $(document).ready(function() {
            fetch_payment(1);

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                fetch_payment($(this).attr('href').split('page=')[1]);
            });
        });

        function fetch_payment(page)
        {
            var route = "{{ route('payment-index', ':id') }}".replace(':id', id);

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
    </script>
@endsection
