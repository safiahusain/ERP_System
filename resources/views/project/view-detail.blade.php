@extends('layouts.app')
@php
    $target = 'project';
@endphp
@section('css')
    <style>
        .project-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px;
        }

        /* Header */
        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-title {
            margin: 0;
            font-weight: 600;
        }

        /* Actions */
        .project-actions img {
            width: 18px;
            margin-left: 8px;
            cursor: pointer;
            opacity: 0.7;
        }

        .project-actions img:hover {
            opacity: 1;
        }

        /* Body */
        .project-body {
            margin-top: 10px;
        }

        /* Labels */
        .label {
            font-size: 12px;
            color: #6b7280;
        }

        /* Status */
        .status-row {
            margin-bottom: 10px;
        }

        /* Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .info-grid p {
            margin: 2px 0 0;
        }

        /* Tabs */
        .project-tabs {
            display: flex;
            gap: 8px;
        }

        .tab {
            padding: 6px 12px;
            background: #f3f4f6;
            border-radius: 6px;
            font-size: 13px;
        }

        .tab.active {
            background: #2563eb;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header header-primary">project Detail</h5>
                <div id="project-view-data">
                    {!! $html_data !!}
                </div>
            </div>
        </div>
    </div>
    @include('includes.models.project.view')
    @include('includes.models.project.create')
    @include('includes.models.project.update')
    @include('includes.models.delete-recode',[
        'target' => $target
    ])
@endsection
@section('js')
    <script>
        let my_array=   ['client', 'manager', 'title', 'description', 'status', 'start_date', 'end_date'];

        $('.select2').select2();
        $('.select2bs4').select2(
        {
            theme : 'bootstrap4'
        });

        function assign_to_update(x, project)
        {
            let my_form =   $("#update-project-form");
            var url     =   "{{ route('project-update', ':id') }}";
            url         =   url.replace(':id', project.id);
            let type    =   'update_';

            clear_fields(my_array,type);

            $("#client_update").val(project.client_id).trigger('change');
            $("#manager_update").val(project.manager_id).trigger('change');
            $("#title_update").val(project.title);
            $("#description_update").val(project.description);
            $("#status_update").val(project.status).trigger("change");

            // Set start and end dates
            $("#update_start_date").val(project.start_date);
            $("#update_end_date").val(project.end_date);

            my_form.attr("action",url);
            console.log(my_form);
            $("#update-project-modal").modal('show');
        }

        // Initialize start and end pickers
        let startPicker = flatpickr(".start_date", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            defaultDate: function() {
                // Get value from input if present (for update)
                return document.querySelector(".start_date").value || null;
            }(),
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length > 0) {
                    let startDate = selectedDates[0];

                    // next day calculate
                    let nextDate = new Date(startDate);
                    nextDate.setDate(nextDate.getDate() + 1);

                    // set as minimum for end date
                    endPicker.set('minDate', nextDate);

                    // optional: if end date is before new minDate, clear it
                    let currentEnd = endPicker.selectedDates[0];
                    if (currentEnd && currentEnd < nextDate) {
                        endPicker.clear();
                    }
                }
            }
        });

        let endPicker = flatpickr(".end_date", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            defaultDate: function() {
                // Get value from input if present (for update)
                return document.querySelector(".end_date").value || null;
            }(),
            onOpen: function(selectedDates, dateStr, instance) {
                // Ensure minDate is set if start date exists
                let startDateInput = document.querySelector(".start_date").value;
                if (startDateInput) {
                    let minDate = new Date(startDateInput);
                    minDate.setDate(minDate.getDate() + 1);
                    instance.set('minDate', minDate);
                }
            }
        });

        // function get_data_to_view(id)
        // {
        //     var route   =   "{{ route('project-view', ':id') }}";
        //     route       =   route.replace(':id', id);

        //     $.ajax(
        //     {
        //         url     :   route,
        //         type    :   'get',
        //         success :   function(success_resp)
        //         {
        //             let html_data   =   success_resp.html_data;
        //             $("#project-view-data").empty().html(html_data);
        //         },
        //         error: function(error_resp)
        //         {
        //             let data    =   error_resp.responseJSON;
        //             toastr[data.type](data.message,data.type.toUpperCase());
        //         }
        //     });
        // }
    </script>
@endsection
