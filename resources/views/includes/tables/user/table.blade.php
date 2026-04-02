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
                    <td> {{ $user->role    ?   ucwords($user->role->name)   : '' }} </td>
                    <td> {{ $user->phone ??  "" }} </td>
                    <td> {{ $user->address ??  "" }} </td>
                    <td>
                        @if (array_key_exists("USERCRT",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{$user}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if(array_key_exists("USERCRT",$auth->func) && ($user->isTeamMemberType() || $user->isManagerType()))
                            <a href="javascript:void(0)" onclick="showUserAssignments(this, {{$user}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/assign_leader.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("USERCRT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                <img src="{{asset('images/icons/delete.png')}}" class="filters-btn">
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else

        @endif
    </tbody>
</table>
