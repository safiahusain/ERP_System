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
                <tr>
                    <td> {{ ucwords($role->name) ??  "" }} </td>
                    <td> {{ $role->slug ??  "" }} </td>
                    <td>
                        <a href="javascript:void(0)" onclick="assign_to_update(this, {{$role}})" title="{{ __('Edit') }}">
                            <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                        </a>
                        <a href="javascript:void(0)" onclick="assign_to_update_permission(this, {{$role}})" title="{{ __('Permission') }}">
                            <img src="{{asset('images/icons/permission.png')}}" class="filters-btn">
                        </a>
                        @if(!$role->is_system)
                            <a href="javascript:void(0)" class="deleteBtn" id="{{ $role->id }}"  data-toggle="modal" data-target="#delete_model" title="{{ __('Delete') }}">
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
@if ($roles->total() > 3)
    <hr>

    <div class="float-left">
        {{$roles->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
