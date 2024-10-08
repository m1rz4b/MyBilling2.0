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
                <h2 class="mb-0" style="color: black; text-align: center;">Employee Promotion Report</h2>
            </div>
        </div>

        @if ($hrmEmpJobHistory)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-bold">Promotion Report</p>
        <p class="text-center text-dark fw-medium">For the period of <span id="time_period">{{$selectedMonth}}</span>, {{$selectedYear}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th>Employee Name</th>
                            <th>Promotion Date</th>
                            <th>New Designation</th>
                            <th>Previous Promotion Date</th>                                        
                            <th>Previous Designation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($hrmEmpJobHistory as $jobHistory)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $jobHistory->emp_name }}</td>
                            <td>{{ $jobHistory->pro_date }}</td>
                            <td>{{ $jobHistory->prodes }}</td>
                            <td>{{ $jobHistory->pre_pro_date }}</td>
                            <td>{{ $jobHistory->predes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {!! $hrmEmpJobHistory->links() !!} --}}
            </div>
        </div>
        @endif
    </div>
</div>