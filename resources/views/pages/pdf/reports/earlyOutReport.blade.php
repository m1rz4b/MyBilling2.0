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
                <h2 class="mb-0" style="color: black; text-align: center">Early Out Report</h2>
            </div>
        </div>

        @if ($masEmployees)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-semibold">Early Out Report</p>
        @if ($selectedDate)
            <p class="text-center text-dark fw-medium">For the period of: {{ $selectedDate }}</p>
        @endif
        @if ($subofficeName)
            <p class="text-center text-dark fw-medium">Office: {{ $subofficeName->name }}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        <div class="QA_table px-3">
            <div>
                @php
                    $count = ($paginator->currentPage() - 1) * $paginator->perPage() + 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Employee</th>
                            <th>Pin No</th>
                            <th width="15%">Early-Out Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($masEmployees as $employee)
                        @if ($ld_flag==1)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $employee->emp_name }}</td>
                                <td>{{ $employee->emp_no }}</td>
                                <td>
                                    @php
                                        $today = date("Y-m-d");
                                        if ($selectedDate==$today)
                                        {

                                        }
                                        else{
                                            echo $e . ' ' .$maxd;
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>