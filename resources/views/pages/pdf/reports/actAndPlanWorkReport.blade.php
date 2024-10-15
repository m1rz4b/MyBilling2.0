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
                <h2 class="mb-0" style="color: black; text-align: center;">Actual And Planned Work Times</h2>
            </div>
        </div>

        @if ($attendanceData)
        <h4 class="text-center">Millennium Computers and Networking</h4>
        <p class="text-center fw-bold text-dark">Actual And Planned Work Times ({{$selectedFromDate}} to {{$selectedToDate}})</p>
        <p class="text-center fw-bold text-dark">Employee: {{$selectedEmployee}}</p>
        <div class="QA_table px-3">
            <div>
                @php
                    $count  = 1;
                    $tw = 0;
                    $td = 0;
                    $tt = 0;
                    $work = 0;
                    $do = 0;
                    $total = 0;
                @endphp
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Planned In</th>
                            <th>Actual In</th>
                            <th>Planned Out</th>
                            <th>Actual Out</th>
                            <th>Planned Work</th>
                            <th>Actual Work</th>
                            <th>Difference</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($attendanceData as $attendance)
                        <tr>
                            <td>{{ $attendance->empdate }}</td>
                            <td>{{ date('g:i a', strtotime($plannedin)) }}</td>
                            <td>{{ date('g:i a', strtotime($attendance->min_checktime)) }}</td>
                            <td>{{ date('g:i a', strtotime($plannedout)) }}</td>
                            <td>{{ date('g:i a', strtotime($attendance->max_checktime)) }}</td>
                            <td>
                                @php
                                    $work=(strtotime($plannedout)-strtotime($plannedin));  
                                    $tw=$tw+$work;	
                                    $hours2 = floor($work / 60 / 60);
                                    $minutes2 = round(($work - ($hours2 * 60 * 60)) / 60);
                                    echo $hours2.' H, '.$minutes2 .' M';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $do=(strtotime($attendance->max_checktime)-strtotime($attendance->min_checktime)); 
                                    $td=$td+$do;
                                    $hours = floor($do / 60 / 60);
                                    $minutes = round(($do - ($hours * 60 * 60)) / 60);
                                    echo $hours.' H, '.$minutes .' M';
                                @endphp
                            </td>
                            <td>
                                @php
                                    $total=$work-$do;
                                    $tt=$tt+$total;
                                    if($total < 0){
                                        $a_total = -$total;
                                        $hours1 = floor($a_total / 60 / 60);
                                        $minutes1 = round(($a_total - ($hours1 * 60 * 60)) / 60); 
                                        echo $hours1.' H, '.$minutes1 .' M (Over time)';
                                    }
                                    else{
                                        $a_total=$total;
                                        $hours1      = floor($a_total / 60 / 60);
                                        $minutes1    = round(($a_total - ($hours1 * 60 * 60)) / 60); 
                                        echo $hours1.' H, '.$minutes1 .' M (Less Work)';		 
                                    }
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {!! $attendanceData->links() !!} --}}
            </div>
        </div>
        @endif
    </div>
</div>

@push('select2')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            
        });
    });
</script>

@endpush