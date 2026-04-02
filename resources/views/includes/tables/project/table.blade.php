<table class="table table-striped">
    <thead>
        <tr>
            <th> {{__("Client")}} </th>
            <th> {{__("Manager")}} </th>
            <th> {{__("Title")}} </th>
            <th> {{__("Description")}} </th>
            <th> {{__("Status")}} </th>
            {{-- <th> {{__("Start Data")}} </th>
            <th> {{__("End Data")}} </th> --}}
            <th> {{__("Action")}} </th>
        </tr>
    </thead>
    <tbody>
        @if (count($projects))
            @foreach ( $projects as $key => $project )
                <tr>
                    @php
                        $manager_team = $project->manager ? $project->manager->teamMembers->pluck('email','id')->toArray() : [];
                    @endphp
                    <td> {{ $project->client->email ??  "" }} </td>
                    <td> {{ $project->manager->email ??  "" }} </td>
                    <td> {{ ucwords($project->title) ??  "" }} </td>
                    <td> {{ $project->description ??  "" }} </td>
                    <td> {{ ucwords($project->status) ??  "" }} </td>
                    {{-- <td> {{ $project->start_date ??  "" }} </td>
                    <td> {{ $project->end_date ??  "" }} </td> --}}
                    <td>
                        @if (array_key_exists("PROJECTVIEW",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="{{$project->id}}" onclick="get_data_to_view(this)" title="{{ __('view') }}">
                                <img src="{{asset('images/icons/view.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("PROJECTUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{json_encode($project)}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("PROJECTDLT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$project->id}}, 'project')" title="{{ __('Delete') }}">
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
