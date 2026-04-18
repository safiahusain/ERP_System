<table class="table table-striped">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="px-4 py-2 border-b">ID</th>
            <th class="px-4 py-2 border-b">Date</th>
            <th class="px-4 py-2 border-b">Amount</th>
            <th class="px-4 py-2 border-b">Method</th>
            <th class="px-4 py-2 border-b">Actions</th>
        </tr>
    </thead>
    <tbody>
        @if (count($payments))
            @foreach($payments as $payment)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b">{{ $payment->id }}</td>
                    <td class="px-4 py-2 border-b">{{ $payment->date }}</td>
                    <td class="px-4 py-2 border-b">${{ number_format($payment->amount, 2) }}</td>
                    <td class="px-4 py-2 border-b">{{ $payment->method }}</td>
                    <td class="px-4 py-2 border-b">
                         @if (array_key_exists("INVOICEUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{json_encode($payment)}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("INVOICEDLT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$payment->id}}, 'payment')" title="{{ __('Delete') }}">
                                <img src="{{asset('images/icons/delete.png')}}" class="filters-btn">
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="20">
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
@if ($payments->total() > 10)
    <hr>
    <div class="float-left">
        {{$payments->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
