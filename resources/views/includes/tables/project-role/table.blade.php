<table class="table table-striped">
    <thead>
        <tr>
            <th> {{__("Name")}} </th>
            <th> {{__("Action")}} </th>
        </tr>
    </thead>
    <tbody>
        @if (count($project_roles))
            @foreach ( $project_roles as $key => $project_role )
                <tr>
                    <td> {{ ucwords($project_role->name) ??  "" }} </td>
                    <td>
                        @if (array_key_exists("PROJECTROLEUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{json_encode($project_role)}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("PROJECTROLEDLT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$project_role->id}}, 'project-role')" title="{{ __('Delete') }}">
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
