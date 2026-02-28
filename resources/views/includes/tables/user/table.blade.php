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
        @if (count($users))
            @foreach ( $users as $key => $user )
                <tr>
                    <td> {{ ucwords($user->name) ??  "" }} </td>
                    <td> {{ $user->email ??  "" }} </td>
                    <td> {{ $user->roles    ?   ucwords($user->roles->name)   : '' }} </td>
                    <td> {{ $user->contact ??  "" }} </td>
                    <td> {{ $user->address ??  "" }} </td>
                    <td>
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" title="{{ __('Download') }}">
                            <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                        </a>
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" title="{{ __('Download') }}">
                            <img src="{{asset('images/icons/delete.png')}}" class="filters-btn">
                        </a>
                    </td>
                </tr>
            @endforeach
        @else

        @endif
    </tbody>
</table>
