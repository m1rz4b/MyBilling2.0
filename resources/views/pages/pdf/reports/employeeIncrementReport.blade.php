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
                <h2 class="mb-0 text-black text-center" style="color: black; text-align: center;">Employee Increment Report</h2>
            </div>
        </div>

        @if ($hrm_increments)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center text-dark fw-bold">Increment Report</p>
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
                {{-- {!! $hrm_increments->links() !!} --}}
            </div>
        </div>
        @endif
    </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        const month = document.getElementsByClassName('month');
        const timePeriod = document.getElementById('time_period');
        
        function getMonth(m){
            if(m==1){
                return "January";
            }else if(m==2){
                return "February";
            }else if(m==3){
                return "March";
            }else if(m==4){
                return "April";
            }else if(m==5){
                return "May";
            }else if(m==6){
                return "June";
            }else if(m==7){
                return "July";
            }else if(m==8){
                return "August";
            }else if(m==9){
                return "September";
            }else if(m==10){
                return "October";
            }else if(m==11){
                return "November";
            }else if(m==12){
                return "December";
            }
        }

        //Convert number into month name for table data
        for(mon of month){
            let res = mon.innerText;
            let result = res.split(',')[0];
            let monthName = getMonth(result);
            result = monthName.concat(',',res.split(',')[1]);
            mon.innerText = result;
        }

        //Convert number into month name for table header
        let munthNumber = timePeriod.innerText;
        let monthName = getMonth(munthNumber);
        timePeriod.innerText = monthName;
    });
</script>
@endpush