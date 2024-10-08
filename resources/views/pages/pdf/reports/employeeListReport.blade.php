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
    <div class="container-fluid p-0 sm_padding_15px">
        <div class="px-4 py-1 theme_bg_1">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color: black; text-align: center">Employee List</h2>
            </div>
        </div>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center fw-bold text-dark">Employee List</p>
        <p class="text-center fw-medium text-dark">Office: {{$selectedOfficeName->name}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Userid</th>
                            <th>Employee Name</th>
                            <th>Date of Birth</th>
                            <th>Date of Joining</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Working Duration</th>
                            <th>Status</th>
                            <th>Mobile</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $masEmployee)
                        <tr>
                            <td>{{ $masEmployee->emp_id }}</td>
                            <td>{{ $masEmployee->emp_name }}</td>
                            <td>{{ $masEmployee->date_of_birth }}</td>
                            <td>{{ $masEmployee->date_of_joining }}</td>
                            <td>{{ $masEmployee->department }}</td>
                            <td>{{ $masEmployee->designation }}</td>
                            <td>
                                @if ($masEmployee->ndate > 0)
                                    {{\Carbon\Carbon::parse($masEmployee->ndate)->diffForHumans(['parts' => 2])}}
                                @endif
                            </td>
                            <td>{{ $masEmployee->name }}</td>
                            <td>{{ $masEmployee->mobile }}</td>
                            <td>{{ $masEmployee->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>