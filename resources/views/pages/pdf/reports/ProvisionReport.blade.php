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
                <h2 class="mb-0" style="color: black; text-align: center">Employee List</h2>
            </div>
        </div>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-bold">Employee List</p>
        <p class="text-center text-dark fw-medium">Printing Date: {{ \Carbon\Carbon::now()->setTimezone('Asia/Dhaka')->format('d M Y h:i a') }}</p>
        @if ($subofficeName)
            <p class="text-center text-dark fw-medium">Office: {{ $subofficeName->name }}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        @if ($designationName)
            <p class="text-center text-dark fw-medium">Designation: {{ $designationName->designation }}</p>
        @endif
        <div class="QA_table px-3">
            <div>
                @php
                    $count = ($masEmployees->currentPage() - 1) * $masEmployees->perPage() + 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th>Employee Name</th>
                            <th>Employee No</th>
                            <th>Date of Joining</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Provision preiod end</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $employee)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $employee->emp_name }}</td>
                            <td>{{ $employee->emp_no }}</td>
                            <td>{{ $employee->date_of_joining }}</td>
                            <td>{{ $employee->department }}</td>
                            <td>{{ $employee->designation }}</td>
                            <td>{{ $employee->mobile }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->provision_days }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>