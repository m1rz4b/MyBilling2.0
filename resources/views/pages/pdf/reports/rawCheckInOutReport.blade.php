<style>
    table {
        border-collapse: collapse;
    }
    .table th,
    .table td {
        padding: 0.25rem;
        border: 1px solid black;
    }
</style>

<div class="main_content_iner">
    <div class="container-fluid p-0 pb-3 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color: black; text-align: center">Raw Check In Out Report</h2>
            </div>
        </div>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-semibold">Raw Check In Out Report</p>
        @if ($selectedFromDate)
            <p class="text-center text-dark fw-medium">For the period of: {{$selectedFromDate}}</p>
        @endif
        @if ($subofficeName)
            <p class="text-center text-dark fw-medium">Office: {{ $subofficeName->name }}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        @if ($employeeName)
            <p class="text-center text-dark fw-medium">Employee: {{ $employeeName->emp_name }}</p>
        @endif
        <div class="QA_table px-3">
            <div>
                @php
                    $count = ($masEmployees->currentPage() - 1) * $masEmployees->perPage() + 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th width="10%">Sl</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Access Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $employees)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $employees->emp_name }}</td>
                            <td>{{ $employees->department }}</td>
                            <td>{{ $employees->checktime }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>