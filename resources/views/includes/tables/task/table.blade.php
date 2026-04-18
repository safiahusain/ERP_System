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
        @if (count($tasks))
            @foreach ( $tasks as $key => $task )
                @php
                // dd($task->assigned);
                    $status = config('defaults.status')[$task->status];
                    $priority = config('defaults.priority')[$task->priority];
                @endphp
                <tr>

                    <td> {{ ucwords($task->title) ??  "" }} </td>
                    <td>
                        <span class="badge-custom {{$status['class']}}">
                            <i class="{{$status['icon']}}"></i>
                            {{ ucwords(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </td>

                    <td>
                        <span class="badge-custom {{$priority['class']}}">
                            <i class="{{$priority['icon']}}"></i>
                            {{ ucwords(str_replace('_', ' ', $task->priority)) }}
                        </span>
                    </td>
                    <td> {{ $task->assignee->name ??  "" }} </td>
                    <td> {{ $task->project->title ??  "" }} </td>
                    <td>
                        @if (array_key_exists("TASKVIEW",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" data-task="{{json_encode($task)}}" onclick="get_data_to_view_task(this)" title="{{ __('view') }}">
                                <img src="{{asset('images/icons/view.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("TASKUPD",$auth->func))
                            <a href="javascript:void(0)" onclick="assign_to_update(this, {{$task}})" data-bs-toggle="tooltip" title="{{ __('Update') }}">
                                <img src="{{asset('images/icons/edit.png')}}" class="filters-btn">
                            </a>
                        @endif
                        @if (array_key_exists("TASKDLT",$auth->func))
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" onclick="set_delete_recode_id({{$task->id}}, 'task')" title="{{ __('Delete') }}">
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
@if ($tasks->total() > 10)
    <hr>
    <div class="float-left">
        {{$tasks->withQueryString()->links('vendor.pagination')}}
    </div>
@endif
