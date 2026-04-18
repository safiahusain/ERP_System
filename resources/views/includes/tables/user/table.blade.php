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
                        @if (array_key_exists("USERACTTOGGLE",$auth->func) || $auth->role == "super_admin")
                            <label class="ios-switch">
                                <input type="checkbox"
                                    user_id="{{$user->id}}"
                                    @if($user->status) checked @endif
                                    onchange="set_active_toggle(this)">
                                <span class="ios-slider"></span>
                            </label>
                        @else
                            {{$asset->main ? __('data.yes') : __('data.no')}}
                        @endif
                    </td>
                    <td>
                        @if (array_key_exists("USERCRT",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{$user}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("USERCRT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$user->id}}, 'user')" title="{{ __('Delete') }}">
                                <img src="{{asset('images/icons/delete.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if((array_key_exists("USERCRT",$auth->func) || $auth->role == "super_admin") && ($user->isTeamMemberType() || $user->isManagerType()))
                            <a href="javascript:void(0)" onclick="showUserAssignments(this, {{$user}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/assign_leader.png')}}" class="filters-btn">
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
@if ($users->total() > 10)
    <hr>
    <div class="float-left">
        {{$users->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
