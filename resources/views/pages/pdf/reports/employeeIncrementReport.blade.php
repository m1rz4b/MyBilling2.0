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
                <h2 class="mb-0" style="color: black; text-align: center;">Employee Increment Report</h2>
            </div>
        </div>

        @if ($hrm_increments)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-bold">Increment Report</p>
        @if ($selectedMonth && $selectedYear)
            <p class="text-center text-dark fw-medium">For the period of <span id="time_period">{{$selectedMonth}}</span>, {{$selectedYear}}</p>
        @endif
        @if ($departmentName)
            <p class="text-center text-dark fw-medium">Department: {{ $departmentName->department }}</p>
        @endif
        @if ($incrementTypeName)
            <p class="text-center text-dark fw-medium">Increment Type: {{ $incrementTypeName->name }}</p>
        @endif
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th>Employee</th>
                            <th>Increment Type</th>
                            <th>Previous Gross</th>
                            <th>Percentage</th>
                            <th>Amount</th>
                            <th>Current Gross</th>
                            <th>Effective Month</th>
                            <th>Entry Date</th>
                            <th>Approve Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hrm_increments as $hrm_increment)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $hrm_increment->emp_name }}</td>
                            <td>{{ $hrm_increment->name }}</td>
                            <td>{{ number_format($hrm_increment->previous_gross, 2) }}</td>                    
                            <td>{{ $hrm_increment->increment_percent }}</td>
                            <td>{{ number_format($hrm_increment->increment_amount, 2) }}</td>
                            <td>{{ number_format($hrm_increment->current_gross, 2) }}</td>
                            <td class="month">{{ $hrm_increment->month }}, {{$hrm_increment->year }}</td>
                            <td>{{ date('d-m-Y', strtotime($hrm_increment->entry_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($hrm_increment->approve_date)) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong>{{ number_format($tprevious_gross, 2) }}</strong></td>        
                            <td><strong></strong></td>
                            <td><strong>{{ number_format($tincrement_amount, 2) }}</strong></td>
                            <td><strong>{{ number_format($tcurrent_gross, 2) }}</strong></td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>