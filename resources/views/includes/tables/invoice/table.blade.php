<table class="table table-striped">
    <thead>
        <tr>
            <th> {{__("Invoice Number")}} </th>
            <th> {{__("Client Name")}} </th>
            <th> {{__("Total")}} </th>
            <th> {{__("Paid")}} </th>
            <th> {{__("Due")}} </th>
            <th> {{__("Status")}} </th>
            <th> {{__("Due Date")}} </th>
            <th> {{__("Action")}} </th>
        </tr>
    </thead>
    <tbody>
        @if (count($invoices))
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->client->name }}</td>
                    <td>{{ $invoice->total }}</td>
                    <td>{{ $invoice->paid }}</td>
                    <td>{{ $invoice->due }}</td>
                    <td>
                        <span class="badge-custom
                            {{ $invoice->status == 'paid' ? 'priority-low' : '' }}
                            {{ $invoice->status == 'due' ? 'priority-high' : '' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>
                        @if (array_key_exists("INVOICEVIEW",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="{{$invoice->id}}" onclick="get_data_to_view(this)" title="{{ __('view') }}">
                                <img src="{{asset('images/icons/view.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("INVOICEUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{json_encode($invoice)}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("INVOICEDLT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$invoice->id}}, 'invoice')" title="{{ __('Delete') }}">
                                <img src="{{asset('images/icons/delete.png')}}" class="filters-btn">
                            </a>
                        @endif
                    </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">
                    <div class="text-center">
                        <h5>
                            {{ __('data.no_record_found') }}
                        </h5>
                        <hr>
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>
@if ($invoices->total() > 10)
    <hr>
    <div class="float-left">
        {{$invoices->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
