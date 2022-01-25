<x-app-layout>   
    <x-slot name="header">
        @include('submissions.navigation', compact('roles', 'departments', 'colleges', 'sectors', 'departmentsResearch', 'departmentsExtension'))
    </x-slot>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button onclick="showall();" class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="home" aria-selected="true">All</button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="received();" class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#received" type="button" role="tab" aria-controls="profile" aria-selected="false">Received</button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="returned();" class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#returned" type="button" role="tab" aria-controls="messages" aria-selected="false">Returned</button>
        </li>
    </ul>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5>{{ $department->name }} - Consolidated Accomplishments</h5>
                    <hr>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label for="reportFilter" class="mr-2">Accomplishment: </label>
                        <div class="d-flex">
                            @include('submissions.accomplishment-filter')
                        </div>
                    </div>
                    <span style="display: inline-block;
                            border-right: 1px solid #ccc;
                            margin: 0px 20px 0px 20px;;
                            height: 65px;"></span>
                    <div class="col-md-3">
                        <label for="yearFilter" class="mr-2">Year Reported: </label>
                        <select id="yearFilter" class="custom-select">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="quarterFilter" class="mr-2">Quarter Period: </label>
                        <div class="d-flex">
                            <select id="quarterFilter" class="custom-select" name="quarter">
                                <option value="1" {{$quarter== 1 ? 'selected' : ''}} class="quarter">1</option>
                                <option value="2" {{$quarter== 2 ? 'selected' : ''}} class="quarter">2</option>
                                <option value="3" {{$quarter== 3 ? 'selected' : ''}} class="quarter">3</option>
                                <option value="4" {{$quarter== 4 ? 'selected' : ''}} class="quarter">4</option>
                            </select>
                            <button id="filter" class="btn btn-secondary ml-4"><i class="bi bi-filter"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="table-responive">
                        <table class="table table-hover table-sm table-bordered" id="department_accomplishments_table">
                            <thead class="text-center">
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Accomplishment Report</th>
                                    <th rowspan="2">College/Branch/Campus/Office</th>
                                    <th rowspan="2">Department</th>
                                    <th colspan="6">Status</th>
                                    <th rowspan="2">Remarks</th>
                                </tr>
                                <tr>
                                    <th>Researcher</th>
                                    <th>Extensionist</th>
                                    <th>Chairperson</th>
                                    <th>Dean/Director</th>
                                    <th>Sector Head</th>
                                    <th>IPQMSO</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($department_accomps as $row)
                                <tr role="button">
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">{{ $loop->iteration }}</td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">{{ $row->report_category }}</td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">{{ $college_names[$row->id]->name }}</td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">{{ $department_names[$row->id]->name }}</td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">
                                        @if ($row->report_category_id >= 1 || $row->report_category_id <= 7)
                                            @if ($row->researcher_approval == null)
                                                Receiving...
                                            @elseif ($row->researcher_approval == 0)
                                                <span class="text-danger font-weight-bold">Returned</span>
                                            @elseif ($row->researcher_approval == 1)
                                                <span class="text-success font-weight-bold">Received</span>
                                            @endif
                                        @else
                                            n/a
                                        @endif
                                    </td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">
                                        @if ($row->report_category_id >= 12)
                                            @if ($row->extensionist_approval == null)
                                                Receiving...
                                            @elseif ($row->extensionist_approval == 0)
                                                <span class="text-danger font-weight-bold">Returned</span>
                                            @elseif ($row->extensionist_approval == 1)
                                                <span class="text-success font-weight-bold">Received</span>
                                            @endif
                                        @else
                                            n/a
                                        @endif
                                    </td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">
                                        @if ($row->report_category_id >= 1 || $row->report_category_id <= 7)
                                            @if ($row->researcher_approval == null)
                                                -
                                            @elseif ($row->researcher_approval == 0)
                                                -
                                            @else
                                                @if ($row->chairperson_approval === null)
                                                    Receiving...
                                                @elseif ($row->chairperson_approval === 0)
                                                    <span class="text-danger font-weight-bold">Returned</span>
                                                @elseif ($row->chairperson_approval === 1)
                                                    <span class="text-success font-weight-bold">Received</span>
                                                @endif
                                            @endif
                                        @elseif ($row->report_category_id >= 12)
                                            @if ($row->extensionist_approval == null)
                                                -
                                            @elseif ($row->extensionist_approval == 0)
                                                -
                                            @else
                                                @if ($row->chairperson_approval === null)
                                                    Receiving...
                                                @elseif ($row->chairperson_approval === 0)
                                                    <span class="text-danger font-weight-bold">Returned</span>
                                                @elseif ($row->chairperson_approval === 1)
                                                    <span class="text-success font-weight-bold">Received</span>
                                                @endif
                                            @endif
                                        @else
                                            @if ($row->chairperson_approval === null)
                                                Receiving...
                                            @elseif ($row->chairperson_approval === 0)
                                                <span class="text-danger font-weight-bold">Returned</span>
                                            @elseif ($row->chairperson_approval === 1)
                                                <span class="text-success font-weight-bold">Received</span>
                                            @endif
                                        @endif     
                                    </td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">
                                        @if ($row->chairperson_approval === 0)
                                            -
                                        @elseif ($row->chairperson_approval === null)
                                            -
                                        @else
                                            @if ($row->dean_approval === null)
                                                Receiving...
                                            @elseif ($row->dean_approval === 0)
                                                <span class="text-danger font-weight-bold">Returned</span>
                                            @elseif ($row->dean_approval === 1)
                                                <span class="text-success font-weight-bold">Received</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">
                                        @if ($row->dean_approval === 0)
                                            -
                                        @elseif ($row->dean_approval === null)
                                            -
                                        @else
                                            @if ($row->sector_approval === null)
                                                Receiving...
                                            @elseif ($row->sector_approval === 0)
                                                <span class="text-danger font-weight-bold">Returned</span>
                                            @elseif ($row->sector_approval === 1)
                                                <span class="text-success font-weight-bold">Received</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="report-view button-view" data-toggle="modal" data-target="#viewReport" data-url="{{ route('document.view', ':filename') }}" data-id="{{ $row->id }}">
                                        @if ($row->sector_approval === 0)
                                            -
                                        @elseif ($row->sector_approval === null)
                                            -
                                        @else
                                            @if ($row->ipqmso_approval === null)
                                                Receiving...
                                            @elseif ($row->ipqmso_approval === 0)
                                                <span class="text-danger font-weight-bold">Returned</span>
                                            @elseif ($row->ipqmso_approval === 1)
                                                <span class="text-success font-weight-bold">Received</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->report_category_id >= 1 || $row->report_category_id <= 7)
                                            @if (
                                                $row->researcher_approval === 0 ||
                                                $row->chairperson_approval === 0 ||
                                                $row->dean_approval === 0 ||
                                                $row->sector_approval === 0 ||
                                                $row->ipqmso_approval === 0
                                            )
                                                <button class="button-deny btn btn-primary btn-sm" data-toggle="modal" data-target="#viewDeny" data-id="{{ $row->id }}">Remarks</button>
                                            @else
                                                -
                                            @endif
                                        @elseif ($row->report_category_id == 12)
                                            @if (
                                                $row->extensionist_approval === 0 ||
                                                $row->chairperson_approval === 0 ||
                                                $row->dean_approval === 0 ||
                                                $row->sector_approval === 0 ||
                                                $row->ipqmso_approval === 0
                                            )
                                                <button class="button-deny btn btn-primary btn-sm" data-toggle="modal" data-target="#viewDeny" data-id="{{ $row->id }}">Remarks</button>
                                            @else
                                                -
                                            @endif
                                        @else
                                            @if (
                                                $row->chairperson_approval === 0 ||
                                                $row->dean_approval === 0 ||
                                                $row->sector_approval === 0 ||
                                                $row->ipqmso_approval === 0
                                            )
                                                <button class="button-deny btn btn-primary btn-sm" data-toggle="modal" data-target="#viewDeny" data-id="{{ $row->id }}">Remarks</button>

                                            @else
                                                -
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (
                                            $row->chairperson_approval === 0 ||
                                            $row->dean_approval === 0 ||
                                            $row->sector_approval === 0 ||
                                            $row->ipqmso_approval === 0
                                        )
                                        <button class="button-deny action-remarks" data-toggle="modal" data-target="#viewDeny" data-id="{{ $row->id }}"><i class="bi bi-chat-square-text"></i> Remarks</button>
                                    @else
                                        -
                                    @endif
                                </td>

                            </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>   

    <div class="modal fade" id="viewReport" tabindex="-1" aria-labelledby="viewReportLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewReportLabel">View Submission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <table class="table table-sm table-borderless" id="columns_value_table">
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-11 h5 font-weight-bold">Documents</div>
                    <div class="col-md-11" id="data_documents">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center" id="review_btn_undo">
                    </div>
                    <div class="col-md-12 text-center" id="review_btn_relay">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewDeny" tabindex="-1" aria-labelledby="viewDenyLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDenyLabel">Reason for Returned Accomplishment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-borderless" style="width: 100%" id="view_deny_details_table">
                            <tr id="deny-detail-1">
                                <td class="font-weight-bold" style="width:50%">Returned By:</td>
                            </tr>
                            <tr id="deny-detail-2">
                                <td class="font-weight-bold">Date:</td>
                            </tr>
                            <tr id="deny-detail-3">
                                <td class="font-weight-bold">Reason:</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $('.button-view').on('click', function(){
                var catID = $(this).data('id');
                var link = $(this).data('url');
                
                var countColumns = 0;
                $.get('/reports/data/'+catID, function (data){
                    Object.keys(data).forEach(function(k){
                        countColumns = countColumns + 1;
                        $('#columns_value_table').append('<tr id="row-'+countColumns+'" class="d-flex report-content"></tr>')
                        $('#row-'+countColumns).append('<td class="report-content font-weight-bold">'+k+':</td>');
                        $('#row-'+countColumns).append('<td class="report-content text-left">'+data[k]+'</td>');
                    });
                });
                $.get('/reports/docs/'+catID, function (data) {
                    data.forEach(function (item){
                        var newlink = link.replace(':filename', item)
                        $('#data_documents').append('<a href="'+newlink+'" target="_blank" class="report-content h5 m-1 btn btn-primary">'+item+'<a/>');
                    });
                });
                
            });

            $('.button-deny').on('click', function () {
                var categoryID = $(this).data('id');
            
                $.get('/reports/reject-details/'+categoryID, function(data){
                    var position = data.position_name;
                    var countColumns = 1;
                    var position_name = position.charAt(0).toUpperCase()+position.slice(1);
                    $('#deny-detail-'+countColumns).append('<td class="report-content">'+position_name+'</td>');
                    countColumns = countColumns + 1;
                    $('#deny-detail-'+countColumns).append('<td class="report-content">'+data.time+'</td>');
                    countColumns = countColumns + 1;
                    $('#deny-detail-'+countColumns).append('<td class="report-content">'+data.reason+'</td>');
                });
            });

            $('#viewReport').on('hidden.bs.modal', function(event) {
                $('.report-content').remove();
            });

            $('#viewDeny').on('hidden.bs.modal', function(event) {
                $('#deny-details').remove();
                $('.report-content').remove();
            });
            $(function(){
                $('#department_accomplishments_table').DataTable();
            });
            // auto hide alert
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 4000);
        </script>
        <script>
            var max = new Date().getFullYear();
            var min = 0;
            var diff = max-2022;
            min = max-diff;
            select = document.getElementById('yearFilter');

            var year = {!! json_encode($year) !!};
            for (var i = max; i >= min; i--) {
                select.append(new Option(i, i));
                if (year == i) {
                    document.getElementById("yearFilter").value = i;
                }
            }
        </script>
    @endpush
</x-app-layout>