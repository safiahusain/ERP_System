<table class="table table-striped">
    <thead>
        <tr>
            <th> {{__("Name")}} </th>
            <th> {{__("Tag")}} </th>
            <th> {{__("Action")}} </th>
        </tr>
    </thead>
    <tbody>
        @if (count($roles))
            @php
                $i = $roles->perPage() * ($roles->currentPage() - 1);
            @endphp
            @foreach ( $roles as $key => $role )
                @if ($role->tag != "super_admin")
                    <tr>
                        <td> {{ ucwords($role->name) ??  "" }} </td>
                        <td> {{ $role->tag ??  "" }} </td>
                        <td>
                            @if (array_key_exists("ROLEUPD",$auth->func) || $auth->role == "super_admin")
                                <a href="javascript:void(0)" onclick="assign_to_update(this, {{$role}})" title="{{ __('Update') }}">
                                    <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                                </a>
                            @endif
                            @if (array_key_exists("ROLEPRMSION",$auth->func) || $auth->role == "super_admin")
                                <a href="javascript:void(0)" onclick="assign_to_update_permission(this, {{$role}})" title="{{ __('Permission') }}">
                                    <img src="{{asset('images/icons/permission.png')}}" class="filters-btn">
                                </a>
                            @endif
                            @if(!$role->is_system && (array_key_exists("ROLEDLT",$auth->func) || $auth->role == "super_admin"))
                                <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$role->id}}, 'role')" title="{{ __('Delete') }}">
                                    <img src="{{asset('images/icons/delete.png')}}" class="filters-btn">
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
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
@if ($roles->total() > 10)
    <hr>
    <div class="float-left">
        {{$roles->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
