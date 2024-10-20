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
                <h2 class="mb-0" style="color: black; text-align: center">Leave Register Report</h2>
            </div>
        </div>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-semibold">Leave Register Report</p>
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        @if ($employeenName)
            <p class="text-center text-dark fw-medium">Employee: {{ $employeenName->emp_name }}</p>
        @endif
        <div class="QA_table px-3">
            <div>                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Allowed</th>
                            <th>Taken</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $nemp = null;
                        @endphp
                        @foreach ($masEmployees as $employees)
                            @if ($nemp != $employees->emp_name)
                                <tr>
                                    <td colspan="4"><strong>Employee: {{ $employees->emp_name }}</strong></td>
                                </tr>
                            @endif
                            <tr>
                                <td>{{ $employees->name }}</td>
                                <td>{{ $employees->total }}</td>
                                <td>{{ $employees->consumed }}</td>
                                <td>{{ $employees->allowed - $employees->consumed }}</td>
                            </tr>
                            
                            @php
                                $nemp = $employees->emp_name;  // Update $nemp after the check
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>