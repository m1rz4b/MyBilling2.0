@extends('layouts.main')

@section('main-container')
    <style>
        .table th,
        .table td {
            padding: 0.25rem;
        }

        .select2-container .select2-selection--single {
            height: auto !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-top: .25rem !important;
            padding-bottom: .25rem !important;
            font-size: .875rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 3px !important;
            right: 3px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
        }
    </style>

    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible my-1" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
                <strong>Success !</strong> {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="main_content_iner">

        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white">Invoice Collection</h5>
                </div>
            </div>
                
            <form method="POST" action="{{ url('invoicecollectionhomeshow') }}">
                @csrf
                <div class="p-4 row">
                    <div class="col-sm-3">
                        <label for="" class="">Customer</label>
                        <select disabled name="client_Id" id="customer_id" class="form-control form-control-sm select2" style="width: 145%;">
                            
                            @foreach ($customers as $customer)
                                <option 
                                    value="{{ $customer->id }}"
                                    {{ ($customer->id == $cboDebtor) ? 'selected': '' }}
                                    >
                                            {{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}
                                            
                                </option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <br/>
                        {{-- <center><button type="submit" class="btn btn-sm btn-info">Show Data</button></center> --}}
                    </div>
                </div>
    
            </form>

            <form method="POST" action="{{ url('invoicecollectionhomestore') }}">
                @csrf

            @if ($invoices!=null)
            <div class="QA_table m-3 border border-bottom-0">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <td scope="col" colspan="11">Invoice List</td>
                        </tr>
                        <tr>
                            <th scope="col">Inv No.</th>
                            <th scope="col">Type & Service</th>
                            <th scope="col">Date</th>
                            <th scope="col">Net Bill</th>
                            <th scope="col">Received Amount</th>
                            <th scope="col">Accept</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Vat</th>
                            <th scope="col">AIT</th>
                            <th scope="col">Down Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            
                        @endphp
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>
                                <input type='hidden' name='txtInvoiceObjectID[{{ $i }}]' value='{{ $invoice->invoiceobjet_id }}'>
                                <input type='hidden' name='txtttotalamount[{{ $i }}]' value='{{ $invoice->total_bill }}'>
                                <input type='hidden' name='serv_id[{{ $i }}]' value='{{ $invoice->id }}'>
                                <input type='hidden' name='client_Id' value='{{ $cboDebtor }}'>
                                {{ $invoice->invoice_number }}
                            </td>
                            <td>{{ $invoice->syear }} {{ $invoice->srv_name }}</td>
                            <td>{{ $invoice->smonth }} <input type='hidden' name='smonth[{{ $i }}]' value='{{ $invoice->smonth }}' readonly></td>
                            <td>
                                <input type='text' class='form-control input-sm' id='txtNetBill[{{ $i }}]' name='txtNetBill[{{ $i }}]' style='text-align:right' value='{{ number_format($invoice->net_bill, 2, ".", "") }}' readonly>
                            </td>
                            <td>
                                <input type='text' class='form-control input-sm' id='txtReceivedAmount[{{ $i }}]' name='txtReceivedAmount[{{ $i }}]' style='text-align:right' value='{{ number_format($invoice->ReceivedAmount, 2, ".", "") }}' readonly>
                            </td>
                            <td>
                                <input type='checkbox' id='chkAccept[{{ $i }}]' name='chkAccept[{{ $i }}]' value='ON' onclick='getAmount({{ $i }})'>
                            </td>
                            <td>
                                <input type='number' id='txtAmount[{{ $i }}]' name='txtAmount[{{ $i }}]' class='form-control input-sm' style='text-align:right' onchange='calculateTotalAmount()' value='0'>
                            </td>
                            <td>
                                <input type='number' id='txtDiscount[{{ $i }}]' name='txtDiscount[{{ $i }}]' class='form-control input-sm' style='text-align:right' onchange='calculateTotalAmount1()' value='0'>
                            </td>
                            <td>
                                <input type='number' id='txtVat[{{ $i }}]' name='txtVat[{{ $i }}]' class='form-control input-sm' style='text-align:right' onchange='calculateTotalAmount2()' value='0'>
                            </td>
                            <td>
                                <input type='number' id='txtAit[{{ $i }}]' name='txtAit[{{ $i }}]' class='form-control input-sm' style='text-align:right' onchange='calculateTotalAmount3()' value='0'>
                            </td>
                            <td>
                                <input type='number' id='txtDownTime[{{ $i }}]' name='txtDownTime[{{ $i }}]' class='form-control input-sm' style='text-align:right' onchange='calculateTotalAmount4()' value='0'>
                            </td>                       </tr>
                        @php
                            $i++;
                            
                        @endphp
                        @endforeach
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th colspan="3" class="text-end">Total Amount</th>
                            <td><input type='text' class='form-control input-sm' size='12' style='text-align:right' id='txtTotalAmount' name='txtTotalAmount' readonly value='0'></td>
                            <td><input type='text' class='form-control input-sm' size='12' style='text-align:right' id='txtTotalDiscount' name='txtTotalDiscount' readonly value='0'></td>
                            <td><input type='text' class='form-control input-sm' size='12' style='text-align:right' id='txtTotalVat' name='txtTotalVat' readonly value='0'></td>
                            <td><input type='text' class='form-control input-sm' size='12' style='text-align:right' id='txtTotalAit' name='txtTotalAit' readonly value='0'></td>
                            <td><input type='text' class='form-control input-sm' size='12' style='text-align:right' id='txtTotalDownTime' name='txtTotalDownTime' readonly value='0'></td>
                        </tr>
                    </tbody>
                </table>
                <input type='hidden' id="hidIndex" name='hidIndex' value='{{ $i }}'>
            </div>
            @else
                
            @endif
            

            
                <div class="QA_table m-3 mt-5 border border-bottom-0">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <td scope="col" colspan="4">Received Detail</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="col">Receive Type</th>
                                <td>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="cash">Cash</label>
                                            <input class="form-check-input" type="radio" name="rdoReceiveType" id="rdoReceiveTypeCash" value="C" onclick="checkReceiveType(this.value)">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="cheque">Cheque</label>
                                            <input class="form-check-input" type="radio" name="rdoReceiveType" id="rdoReceiveTypeCheque" value="Q" onclick="checkReceiveType(this.value)">
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="directdiposit">Direct Diposit</label>
                                            <input class="form-check-input" type="radio" name="rdoReceiveType" id="rdoReceiveTypeDeposit" value="D" onclick="checkReceiveType(this.value)">
                                        </div>
                                    </div>
                                </td>
                                <th scope="col">Money Receipt No</th>
                                <td><input type="text" name="txtMoneyReceiptNo" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th>Collection Date</th>
                                <td>
                                    <div class="d-flex justify-content-between gap-3">
                                        <select name="cboVoucherDay" id="day" class="form-select form-select-sm">
                                            <option value="">Day</option>
                                            @foreach (range(1, 31) as $day )
                                                <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                                            @endforeach
                                        </select>
                                        <select name="cboVoucherMonth" id="month" class="form-select form-select-sm">
                                            <option value="">Month</option>
                                            @foreach (range(1,12) as $month)
                                                <option {{ $dates->month == $month?'selected':'' }} value="{{ $month }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                        <select name="cboVoucherYear" id="year" class="form-select form-select-sm">
                                            <option value="">Year</option>
                                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                                <option {{ $dates->year == $year?'selected':'' }} value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <th>Bank</th>
                                <td>
                                    <select name="" id="" class="form-select form-select-sm">
                                        <option value="">Select a Bank</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Cheque No</th>
                                <td><input type="text" class="form-control form-control-sm" name="txtChequeNo" id="txtChequeNo" disabled></td>
                                <th>Cheque Date</th>
                                <td>
                                    <div class="d-flex justify-content-between gap-3">
                                        <select name="cboChequeDay" id="cboChequeDay" class="form-select form-select-sm form-control" disabled>
                                            <option value="">Day</option>
                                            @foreach (range(1, 31) as $day )
                                                <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                                            @endforeach
                                        </select>
                                        <select name="cboChequeMonth" id="cboChequeMonth"class="form-select form-select-sm form-control" disabled>
                                            <option value="">Month</option>
                                            @foreach (range(1,12) as $month)
                                                <option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                        <select name="cboChequeYear" id="cboChequeYear"class="form-select form-select-sm form-control" disabled>
                                            <option value="">Year</option>
                                            @foreach (range(now()->year - 15, now()->year + 5) as $year)
                                                <option {{ $dates->year == $year?'selected':'' }} value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td colspan="3"><textarea name="txaRemarks" id="" rows="3" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="py-3"><input name="print" type="checkbox">Print</input></td>
                                <td colspan="3" class="py-3"><input name="sms" type="checkbox">SMS Notification</input></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <div class="text-center">
                    <input type="submit" class="btn btn-sm btn-info m-2 mb-3" ></input>
                    {{-- <button class="btn btn-sm btn-info m-2 mb-3">Submit & Print</button> --}}
                </div>
    
            </form>
        </div>
        
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
            
        });

        function getAmount(IndexVal)
        {
            
            var NetBill=document.getElementById("txtNetBill["+IndexVal+"]").value;
            //console.log(NetBill);
            var ReceivedAmount=document.getElementById("txtReceivedAmount["+IndexVal+"]").value;
            //console.log(ReceivedAmount);
            var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
            //console.log(Amount);
            // var amt = Amount;
            // //console.log(amt);
            // amt.setPlaces(2);
            // amt.setSeparators(false);
            var pamount = Amount;
            //console.log(pamount);

            if(document.getElementById("chkAccept["+IndexVal+"]").checked)
            {
                    document.getElementById("txtAmount["+IndexVal+"]").value=pamount;
                    calculateTotalAmount();
            }
            else
            {
                    document.getElementById("txtAmount["+IndexVal+"]").value=0;
                    calculateTotalAmount();
                    document.getElementById("txtDiscount["+IndexVal+"]").value=0;
                    calculateTotalAmount1();
                    document.getElementById("txtVat["+IndexVal+"]").value=0;
                    calculateTotalAmount2();
                    document.getElementById("txtAit["+IndexVal+"]").value=0;
                    calculateTotalAmount3();
                    document.getElementById("txtDownTime["+IndexVal+"]").value=0;
                    calculateTotalAmount4();
            }
            //calculateait();
        }

        function calculateTotalAmount()
        {
                var Index=parseInt(document.getElementById('hidIndex').value);
                //alert(Index);
                var TotalAmount=0;

                for (var i=0;i<Index;i++)
                {
                    if(document.getElementById("chkAccept["+i+"]").checked)
                    {
                            if(!isNaN(document.getElementById("txtAmount["+i+"]").value))
                                TotalAmount=TotalAmount+parseFloat(document.getElementById("txtAmount["+i+"]").value);
                            else
                                document.getElementById("txtAmount["+i+"]").value='0';
                    }
                }
                // var tamt = TotalAmount;
                // tamt.setPlaces(2);
                // tamt.setSeparators(false);
                var ptamount =TotalAmount;
                document.getElementById('txtTotalAmount').value=ptamount;
        }

        function calculateTotalAmount1()
        {
            var Index1=parseInt(document.getElementById('hidIndex').value);
            var TotalAmount1=0;
            for (var i=0;i<Index1;i++)
            {
                
                    if(document.getElementById("chkAccept["+i+"]").checked)
                    {
                    //  getAmount(i);
                        if(!isNaN(document.getElementById("txtAmount["+i+"]").value)){
                                TotalAmount1=TotalAmount1+parseFloat(document.getElementById("txtDiscount["+i+"]").value);
                                
                                var NetBill=document.getElementById("txtNetBill["+i+"]").value;
                                var ReceivedAmount=document.getElementById("txtReceivedAmount["+i+"]").value;
                                var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                                
                                var dis=document.getElementById("txtDiscount["+i+"]").value;
                                if(dis==''){
                                    dis=parseFloat(0);	
                                }else{
                                    dis=parseFloat(dis);
                                    }
                                var vat=document.getElementById("txtVat["+i+"]").value;
                                if(vat==''){
                                    vat=parseFloat(0);	
                                }else{
                                    vat=parseFloat(vat);
                                    }									
                                var ait=document.getElementById("txtAit["+i+"]").value;
                                if(ait==''){
                                    ait=parseFloat(0);	
                                }else{
                                    ait=parseFloat(ait);
                                    }
                                var down=document.getElementById("txtDownTime["+i+"]").value;
                                if(down==''){
                                    down=parseFloat(0);	
                                }else{
                                    down=parseFloat(down);
                                    }	
                                
                                var tamt=Amount-(dis+vat+ait+down);
                                document.getElementById("txtAmount["+i+"]").value=tamt;
                        }else
                                document.getElementById("txtDiscount["+i+"]").value='0';
                        
                    }
            }
            
            var tamt1 = TotalAmount1;
            //var tamtT = new NumberFormat(tam);
            //alert(tam);
            // tamt1.setPlaces(2);
            // tamt1.setSeparators(false);
            var ptamount1 =TotalAmount1;
            document.getElementById('txtTotalDiscount').value=ptamount1;
            calculateTotalAmount();
            //alert(Index1);
            //getAmount(Index1);
        
        }

        function calculateTotalAmount2()
        {
            var Index1=parseInt(document.getElementById('hidIndex').value);
            var TotalAmount1=0;
            for (var i=0;i<Index1;i++)
            {
                
                    if(document.getElementById("chkAccept["+i+"]").checked)
                    {
                    //  getAmount(i);
                        if(!isNaN(document.getElementById("txtAmount["+i+"]").value)){
                                TotalAmount1=TotalAmount1+parseFloat(document.getElementById("txtVat["+i+"]").value);
                                
                                var NetBill=document.getElementById("txtNetBill["+i+"]").value;
                                var ReceivedAmount=document.getElementById("txtReceivedAmount["+i+"]").value;
                                var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                                
                                var dis=document.getElementById("txtDiscount["+i+"]").value;
                                if(dis==''){
                                    dis=parseFloat(0);	
                                }else{
                                    dis=parseFloat(dis);
                                    }
                                var vat=document.getElementById("txtVat["+i+"]").value;
                                if(vat==''){
                                    vat=parseFloat(0);	
                                }else{
                                    vat=parseFloat(vat);
                                    }									
                                var ait=document.getElementById("txtAit["+i+"]").value;
                                if(ait==''){
                                    ait=parseFloat(0);	
                                }else{
                                    ait=parseFloat(ait);
                                    }
                                var down=document.getElementById("txtDownTime["+i+"]").value;
                                if(down==''){
                                    down=parseFloat(0);	
                                }else{
                                    down=parseFloat(down);
                                    }	
                                
                                var tamt=Amount-(dis+vat+ait+down);
                                document.getElementById("txtAmount["+i+"]").value=tamt;
                        }else
                                document.getElementById("txtVat["+i+"]").value='0';
                        
                    }
            }
            
            var tamt1 = TotalAmount1;
            //var tamtT = new NumberFormat(tam);
            //alert(tam);
            // tamt1.setPlaces(2);
            // tamt1.setSeparators(false);
            var ptamount1 =TotalAmount1;
            document.getElementById('txtTotalVat').value=ptamount1;
            calculateTotalAmount();
            //alert(Index1);
            //getAmount(Index1);
        
        }

        function calculateTotalAmount3()
        {
            var Index1=parseInt(document.getElementById('hidIndex').value);
            var TotalAmount1=0;
            for (var i=0;i<Index1;i++)
            {
                
                    if(document.getElementById("chkAccept["+i+"]").checked)
                    {
                    //  getAmount(i);
                        if(!isNaN(document.getElementById("txtAmount["+i+"]").value)){
                                TotalAmount1=TotalAmount1+parseFloat(document.getElementById("txtAit["+i+"]").value);
                                
                                var NetBill=document.getElementById("txtNetBill["+i+"]").value;
                                var ReceivedAmount=document.getElementById("txtReceivedAmount["+i+"]").value;
                                var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                                
                                var dis=document.getElementById("txtDiscount["+i+"]").value;
                                if(dis==''){
                                    dis=parseFloat(0);	
                                }else{
                                    dis=parseFloat(dis);
                                    }
                                var vat=document.getElementById("txtVat["+i+"]").value;
                                if(vat==''){
                                    vat=parseFloat(0);	
                                }else{
                                    vat=parseFloat(vat);
                                    }									
                                var ait=document.getElementById("txtAit["+i+"]").value;
                                if(ait==''){
                                    ait=parseFloat(0);	
                                }else{
                                    ait=parseFloat(ait);
                                    }
                                var down=document.getElementById("txtDownTime["+i+"]").value;
                                if(down==''){
                                    down=parseFloat(0);	
                                }else{
                                    down=parseFloat(down);
                                    }	
                                
                                var tamt=Amount-(dis+vat+ait+down);
                                document.getElementById("txtAmount["+i+"]").value=tamt;
                        }else
                                document.getElementById("txtAit["+i+"]").value='0';
                        
                    }
            }
            
            var tamt1 = TotalAmount1;
            //var tamtT = new NumberFormat(tam);
            //alert(tam);
            // tamt1.setPlaces(2);
            // tamt1.setSeparators(false);
            var ptamount1 =TotalAmount1;
            document.getElementById('txtTotalAit').value=ptamount1;
            calculateTotalAmount();
            //alert(Index1);
            //getAmount(Index1);
        
        }

        function calculateTotalAmount4()
        {
            var Index1=parseInt(document.getElementById('hidIndex').value);
            var TotalAmount1=0;
            for (var i=0;i<Index1;i++)
            {
                
                    if(document.getElementById("chkAccept["+i+"]").checked)
                    {
                    //  getAmount(i);
                        if(!isNaN(document.getElementById("txtAmount["+i+"]").value)){
                                TotalAmount1=TotalAmount1+parseFloat(document.getElementById("txtDownTime["+i+"]").value);
                                
                                var NetBill=document.getElementById("txtNetBill["+i+"]").value;
                                var ReceivedAmount=document.getElementById("txtReceivedAmount["+i+"]").value;
                                var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                                
                                var dis=document.getElementById("txtDiscount["+i+"]").value;
                                if(dis==''){
                                    dis=parseFloat(0);	
                                }else{
                                    dis=parseFloat(dis);
                                    }
                                var vat=document.getElementById("txtVat["+i+"]").value;
                                if(vat==''){
                                    vat=parseFloat(0);	
                                }else{
                                    vat=parseFloat(vat);
                                    }									
                                var ait=document.getElementById("txtAit["+i+"]").value;
                                if(ait==''){
                                    ait=parseFloat(0);	
                                }else{
                                    ait=parseFloat(ait);
                                    }
                                var down=document.getElementById("txtDownTime["+i+"]").value;
                                if(down==''){
                                    down=parseFloat(0);	
                                }else{
                                    down=parseFloat(down);
                                    }	
                                
                                var tamt=Amount-(dis+vat+ait+down);
                                document.getElementById("txtAmount["+i+"]").value=tamt;
                        }else
                                document.getElementById("txtDownTime["+i+"]").value='0';
                        
                    }
            }
            
            var tamt1 = TotalAmount1;
            //var tamtT = new NumberFormat(tam);
            //alert(tam);
            // tamt1.setPlaces(2);
            // tamt1.setSeparators(false);
            var ptamount1 =TotalAmount1;
            document.getElementById('txtTotalDownTime').value=ptamount1;
            calculateTotalAmount();
            //alert(Index1);
            //getAmount(Index1);
        
        }

        function checkReceiveType(val)
        {
            
            
            
            //alert(val);
            if(val=='C' || val=='D')
            {
                    
                    document.getElementById('txtChequeNo').disabled=true;
                    document.getElementById('cboChequeDay').disabled=true;
                    document.getElementById('cboChequeMonth').disabled=true;
                    document.getElementById('cboChequeYear').disabled=true;
            }
            else
            {
                    
                    document.getElementById('txtChequeNo').disabled=false;
                    document.getElementById('cboChequeDay').disabled=false;
                    document.getElementById('cboChequeMonth').disabled=false;
                    document.getElementById('cboChequeYear').disabled=false;
            }
        }

        
    </script>
        

        
    
    
    
    

    




    




    
@endsection