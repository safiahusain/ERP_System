<table class="table table-striped">
    <thead>
        <tr>
            <th> {{__("Name")}} </th>
            <th> {{__("Email")}} </th>
            <th> {{__("Role")}} </th>
            <th> {{__("Contact")}} </th>
            <th> {{__("Address")}} </th>
            <th> {{__("Action")}} </th>
        </tr>
    </thead>
    <tbody>
        @if (count($clients))
            @foreach ( $clients as $key => $client )
                <tr>
                    <td> {{ ucwords($client->name) ??  "" }} </td>
                    <td> {{ $client->email ??  "" }} </td>
                    <td> {{ $client->role    ?   ucwords($client->role->name)   : '' }} </td>
                    <td> {{ $client->phone ??  "" }} </td>
                    <td> {{ $client->address ??  "" }} </td>
                    <td>
                        @if (array_key_exists("CLIENTACTTOGGLE",$auth->func) || $auth->role == "super_admin")
                            <label class="ios-switch">
                                <input type="checkbox"
                                    client_id="{{$client->id}}"
                                    @if($client->status) checked @endif
                                    onchange="set_active_toggle(this)">
                                <span class="ios-slider"></span>
                            </label>
                        @else
                            {{$asset->main ? __('data.yes') : __('data.no')}}
                        @endif
                    </td>
                    <td>
                        @if (array_key_exists("CLIENTUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{$client}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("CLIENTDLT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$client->id}}, 'client')" title="{{ __('Delete') }}">
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
@if ($clients->total() > 10)
    <hr>
    <div class="float-left">
        {{$clients->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
