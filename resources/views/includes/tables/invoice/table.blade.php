<table class="table table-striped">
    <thead>
        <tr>
            <th> {{__("Title")}} </th>
            <th> {{__("Assigned To")}} </th>
            <th> {{__("Priority")}} </th>
            <th> {{__("Status")}} </th>
            <th> {{__("Project")}} </th>
            <th> {{__("Action")}} </th>
        </tr>
    </thead>
    <tbody>
        @if (count($invoices))
            @foreach ( $invoices as $key => $invoice )
                @php
                // dd($invoice->assigned);
                    $status = config('defaults.status')[$invoice->status];
                    $priority = config('defaults.priority')[$invoice->priority];
                @endphp
                <tr>

                    <td> {{ ucwords($invoice->title) ??  "" }} </td>
                    <td>
                        <span class="badge-custom {{$status['class']}}">
                            <i class="{{$status['icon']}}"></i>
                            {{ ucwords(str_replace('_', ' ', $invoice->status)) }}
                        </span>
                    </td>

                    <td>
                        <span class="badge-custom {{$priority['class']}}">
                            <i class="{{$priority['icon']}}"></i>
                            {{ ucwords(str_replace('_', ' ', $invoice->priority)) }}
                        </span>
                    </td>
                    <td> {{ $invoice->assignee->name ??  "" }} </td>
                    <td> {{ $invoice->project->title ??  "" }} </td>
                    <td>
                        @if (array_key_exists("TASKVIEW",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-invoice="{{json_encode($invoice)}}" onclick="get_data_to_view_invoice(this)" title="{{ __('view') }}">
                                <img src="{{asset('images/icons/view.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("TASKUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{$invoice}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else

        @endif
    </tbody>
</table>
