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
                    <h5 class="mb-0 text-white text-center">Invoice Collection</h5>
                </div>
            </div>
            <form method="POST" action="{{ url('invoicecollectionhomeshow') }}">
                @csrf
                <div class="p-4 row">
                    <div class="col-sm-3">
                        <label for="" class="">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-control form-control-sm select2" style="width: 145%;">
                            <option selected>Select a Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }} | {{ $customer->mobile1 }} | {{ $customer->ac_no }} | {{ $customer->id }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <br/>
                        <center><button type="submit" class="btn btn-sm btn-info">Show Data</button></center>
                    </div>
                </div>
    
            </form>

            {{-- <div class="QA_table m-3 border border-bottom-0">
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
                        <tr>
                            <td>1347</td>
                            <td>Others</td>
                            <td>12-02-2024</td>
                            <td><input type="text" disabled value="400.00" class="form-control"></td>
                            <td><input type="text" disabled value="0.00" class="form-control"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="number" value="0" class="form-control"></td>
                            <td><input type="number" value="0" class="form-control"></td>
                            <td><input type="number" value="0" class="form-control"></td>
                            <td><input type="number" value="0" class="form-control"></td>
                            <td><input type="number" value="0" class="form-control"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th colspan="3" class="text-end">Total Amount</th>
                            <td><input type="text" disabled value="0" class="form-control"></td>
                            <td><input type="text" disabled value="0" class="form-control"></td>
                            <td><input type="text" disabled value="0" class="form-control"></td>
                            <td><input type="text" disabled value="0" class="form-control"></td>
                            <td><input type="text" disabled value="0" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
                                        <input class="form-check-input" type="radio" name="send_options" id="cash" value="option1" onchange="toggleChequeFields()">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="cheque">Cheque</label>
                                        <input class="form-check-input" type="radio" name="send_options" id="cheque" value="option2" onchange="toggleChequeFields()">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="directdiposit">Direct Diposit</label>
                                        <input class="form-check-input" type="radio" name="send_options" id="directdiposit" value="option3" onchange="toggleChequeFields()">
                                    </div>
                                </div>
                            </td>
                            <th scope="col">Money Receipt No</th>
                            <td><input type="text" class="form-control form-control-sm"></td>
                        </tr>
                        <tr>
                            <th>Collection Date</th>
                            <td>
                                <div class="d-flex justify-content-between gap-3">
                                    <select name="day" id="day" class="form-select form-select-sm">
                                        <option value="">Day</option>
                                        @foreach (range(1, 31) as $day )
                                            <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                                        @endforeach
                                    </select>
                                    <select name="month" id="month" class="form-select form-select-sm">
                                        <option value="">Month</option>
                                        @foreach (range(1,12) as $month)
                                            <option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                                        @endforeach
                                    </select>
                                    <select name="year" id="year" class="form-select form-select-sm">
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
                            <td><input type="text" class="form-control form-control-sm" id="chequeNo" disabled></td>
                            <th>Cheque Date</th>
                            <td>
                                <div class="d-flex justify-content-between gap-3">
                                    <select name="day" id="cday" class="form-select form-select-sm form-control" disabled>
                                        <option value="">Day</option>
                                        @foreach (range(1, 31) as $day )
                                            <option {{$dates->day == $day?'selected':''}} value="{{ $day  }}">{{ $day  }}</option>
                                        @endforeach
                                    </select>
                                    <select name="month" id="cmonth" class="form-select form-select-sm form-control" disabled>
                                        <option value="">Month</option>
                                        @foreach (range(1,12) as $month)
                                            <option {{ $dates->month == $month?'selected':'' }} value="{{ date("M", mktime(0, 0, 0, $month, 1)) }}">{{ date("M", mktime(0, 0, 0, $month, 1)) }}</option>
                                        @endforeach
                                    </select>
                                    <select name="year" id="cyear" class="form-select form-select-sm form-control" disabled>
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
                            <td colspan="3"><textarea name="" id="" rows="3" class="form-control"></textarea></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="3" class="py-3"><input type="checkbox">SMS Notification</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <button class="btn btn-sm btn-info m-2 mb-3">Submit</button>
                <button class="btn btn-sm btn-info m-2 mb-3">Submit & Print</button>
            </div> --}}
        </div>
        
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                
            });
        });

        function toggleChequeFields() {
            var chequeRadio = document.getElementById('cheque');
            var chequeNoInput = document.getElementById('chequeNo');
            var chequeDateDay = document.getElementById('cday');
            var chequeDateMonth = document.getElementById('cmonth');
            var chequeDateYear = document.getElementById('cyear');

            if (chequeRadio.checked) {
                chequeNoInput.disabled = false;
                chequeDateDay.disabled = false;
                chequeDateMonth.disabled = false;
                chequeDateYear.disabled = false;
            }
            else {
                chequeNoInput.disabled = true;
                chequeDateDay.disabled = true;
                chequeDateMonth.disabled = true;
                chequeDateYear.disabled = true;
            }
        }


    </script>

{{-- <script language='javascript'>
    function getAmount(IndexVal)
    {
          var NetBill=document.MyForm.elements["txtNetBill["+IndexVal+"]"].value;
          var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+IndexVal+"]"].value;
          var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
          
          var amt = new NumberFormat(Amount);
          amt.setPlaces(2);
          amt.setSeparators(false);
          var pamount =parseFloat(amt.toFormatted());

          if(document.MyForm.elements["chkAccept["+IndexVal+"]"].checked)
          {
                document.MyForm.elements["txtAmount["+IndexVal+"]"].value=pamount;
                calculateTotalAmount();
          }
          else
          {
                document.MyForm.elements["txtAmount["+IndexVal+"]"].value=0;
                calculateTotalAmount();
                document.MyForm.elements["txtDiscount["+IndexVal+"]"].value=0;
                calculateTotalAmount1();
                document.MyForm.elements["txtVat["+IndexVal+"]"].value=0;
                calculateTotalAmount2();
                document.MyForm.elements["txtAit["+IndexVal+"]"].value=0;
                calculateTotalAmount3();
                document.MyForm.elements["txtDownTime["+IndexVal+"]"].value=0;
                calculateTotalAmount4();
          }
          //calculateait();
    }
    function calculateTotalAmount()
    {
          var Index=parseInt(document.MyForm.hidIndex.value);
          var TotalAmount=0;

          for (var i=0;i<Index;i++)
          {
                if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                {
                      if(!isNaN(document.MyForm.elements["txtAmount["+i+"]"].value))
                            TotalAmount=TotalAmount+parseFloat(document.MyForm.elements["txtAmount["+i+"]"].value);
                      else
                            document.MyForm.elements["txtAmount["+i+"]"].value='0';
                }
          }
          var tamt = new NumberFormat(TotalAmount);
          tamt.setPlaces(2);
          tamt.setSeparators(false);
          var ptamount =parseFloat(tamt.toFormatted());
          document.MyForm.txtTotalAmount.value=ptamount;
    }
    
    function calculateTotalAmount1()
    {
          var Index1=parseInt(document.MyForm.hidIndex.value);
          var TotalAmount1=0;
          for (var i=0;i<Index1;i++)
          {
               
                if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                {
                  //  getAmount(i);
                      if(!isNaN(document.MyForm.elements["txtAmount["+i+"]"].value)){
                            TotalAmount1=TotalAmount1+parseFloat(document.MyForm.elements["txtDiscount["+i+"]"].value);
                            
                              var NetBill=document.MyForm.elements["txtNetBill["+i+"]"].value;
                              var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+i+"]"].value;
                              var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                              
                              var dis=document.MyForm.elements["txtDiscount["+i+"]"].value;
                              if(dis==''){
                                   dis=parseFloat(0);	
                              }else{
                                   dis=parseFloat(dis);
                                  }
                              var vat=document.MyForm.elements["txtVat["+i+"]"].value;
                              if(vat==''){
                                   vat=parseFloat(0);	
                              }else{
                                   vat=parseFloat(vat);
                                  }									
                              var ait=document.MyForm.elements["txtAit["+i+"]"].value;
                              if(ait==''){
                                   ait=parseFloat(0);	
                              }else{
                                   ait=parseFloat(ait);
                                  }
                              var down=document.MyForm.elements["txtDownTime["+i+"]"].value;
                              if(down==''){
                                   down=parseFloat(0);	
                              }else{
                                   down=parseFloat(down);
                                  }	
                              
                              var tamt=Amount-(dis+vat+ait+down);
                              document.MyForm.elements["txtAmount["+i+"]"].value=tamt;
                      }else
                            document.MyForm.elements["txtDiscount["+i+"]"].value='0';
                      
                }
          }
          
          var tamt1 = new NumberFormat(TotalAmount1);
          //var tamtT = new NumberFormat(tam);
          //alert(tam);
          tamt1.setPlaces(2);
          tamt1.setSeparators(false);
          var ptamount1 =parseFloat(tamt1.toFormatted());
          document.MyForm.txtTotalDiscount.value=ptamount1;
          calculateTotalAmount();
          //alert(Index1);
          //getAmount(Index1);
      
    }
    
    function calculateTotalAmount2()
    {
          var Index1=parseInt(document.MyForm.hidIndex.value);
          var TotalAmount1=0;
          for (var i=0;i<Index1;i++)
          {
               
                if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                {
                  //  getAmount(i);
                      if(!isNaN(document.MyForm.elements["txtAmount["+i+"]"].value)){
                            TotalAmount1=TotalAmount1+parseFloat(document.MyForm.elements["txtVat["+i+"]"].value);
                            
                              var NetBill=document.MyForm.elements["txtNetBill["+i+"]"].value;
                              var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+i+"]"].value;
                              var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                              
                              var dis=document.MyForm.elements["txtDiscount["+i+"]"].value;
                              if(dis==''){
                                   dis=parseFloat(0);	
                              }else{
                                   dis=parseFloat(dis);
                                  }
                              var vat=document.MyForm.elements["txtVat["+i+"]"].value;
                              if(vat==''){
                                   vat=parseFloat(0);	
                              }else{
                                   vat=parseFloat(vat);
                                  }									
                              var ait=document.MyForm.elements["txtAit["+i+"]"].value;
                              if(ait==''){
                                   ait=parseFloat(0);	
                              }else{
                                   ait=parseFloat(ait);
                                  }
                              var down=document.MyForm.elements["txtDownTime["+i+"]"].value;
                              if(down==''){
                                   down=parseFloat(0);	
                              }else{
                                   down=parseFloat(down);
                                  }	
                              
                              var tamt=Amount-(dis+vat+ait+down);
                              document.MyForm.elements["txtAmount["+i+"]"].value=tamt;
                      }else
                            document.MyForm.elements["txtVat["+i+"]"].value='0';
                      
                }
          }
          
          var tamt1 = new NumberFormat(TotalAmount1);
          //var tamtT = new NumberFormat(tam);
          //alert(tam);
          tamt1.setPlaces(2);
          tamt1.setSeparators(false);
          var ptamount1 =parseFloat(tamt1.toFormatted());
          document.MyForm.txtTotalVat.value=ptamount1;
          calculateTotalAmount();
          //alert(Index1);
          //getAmount(Index1);
      
    }
    
    function calculateTotalAmount3()
    {
          var Index1=parseInt(document.MyForm.hidIndex.value);
          var TotalAmount1=0;
          for (var i=0;i<Index1;i++)
          {
               
                if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                {
                  //  getAmount(i);
                      if(!isNaN(document.MyForm.elements["txtAmount["+i+"]"].value)){
                            TotalAmount1=TotalAmount1+parseFloat(document.MyForm.elements["txtAit["+i+"]"].value);
                            
                              var NetBill=document.MyForm.elements["txtNetBill["+i+"]"].value;
                              var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+i+"]"].value;
                              var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                              
                              var dis=document.MyForm.elements["txtDiscount["+i+"]"].value;
                              if(dis==''){
                                   dis=parseFloat(0);	
                              }else{
                                   dis=parseFloat(dis);
                                  }
                              var vat=document.MyForm.elements["txtVat["+i+"]"].value;
                              if(vat==''){
                                   vat=parseFloat(0);	
                              }else{
                                   vat=parseFloat(vat);
                                  }									
                              var ait=document.MyForm.elements["txtAit["+i+"]"].value;
                              if(ait==''){
                                   ait=parseFloat(0);	
                              }else{
                                   ait=parseFloat(ait);
                                  }
                              var down=document.MyForm.elements["txtDownTime["+i+"]"].value;
                              if(down==''){
                                   down=parseFloat(0);	
                              }else{
                                   down=parseFloat(down);
                                  }	
                              
                              var tamt=Amount-(dis+vat+ait+down);
                              document.MyForm.elements["txtAmount["+i+"]"].value=tamt;
                      }else
                            document.MyForm.elements["txtAit["+i+"]"].value='0';
                      
                }
          }
          
          var tamt1 = new NumberFormat(TotalAmount1);
          //var tamtT = new NumberFormat(tam);
          //alert(tam);
          tamt1.setPlaces(2);
          tamt1.setSeparators(false);
          var ptamount1 =parseFloat(tamt1.toFormatted());
          document.MyForm.txtTotalAit.value=ptamount1;
          calculateTotalAmount();
          //alert(Index1);
          //getAmount(Index1);
      
    }

    function calculateTotalAmount4()
    {
          var Index1=parseInt(document.MyForm.hidIndex.value);
          var TotalAmount1=0;
          for (var i=0;i<Index1;i++)
          {
               
                if(document.MyForm.elements["chkAccept["+i+"]"].checked)
                {
                  //  getAmount(i);
                      if(!isNaN(document.MyForm.elements["txtAmount["+i+"]"].value)){
                            TotalAmount1=TotalAmount1+parseFloat(document.MyForm.elements["txtDownTime["+i+"]"].value);
                            
                              var NetBill=document.MyForm.elements["txtNetBill["+i+"]"].value;
                              var ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+i+"]"].value;
                              var Amount=parseFloat(NetBill)-parseFloat(ReceivedAmount);
                              
                              var dis=document.MyForm.elements["txtDiscount["+i+"]"].value;
                              if(dis==''){
                                   dis=parseFloat(0);	
                              }else{
                                   dis=parseFloat(dis);
                                  }
                              var vat=document.MyForm.elements["txtVat["+i+"]"].value;
                              if(vat==''){
                                   vat=parseFloat(0);	
                              }else{
                                   vat=parseFloat(vat);
                                  }									
                              var ait=document.MyForm.elements["txtAit["+i+"]"].value;
                              if(ait==''){
                                   ait=parseFloat(0);	
                              }else{
                                   ait=parseFloat(ait);
                                  }
                              var down=document.MyForm.elements["txtDownTime["+i+"]"].value;
                              if(down==''){
                                   down=parseFloat(0);	
                              }else{
                                   down=parseFloat(down);
                                  }	
                              
                              var tamt=Amount-(dis+vat+ait+down);
                              document.MyForm.elements["txtAmount["+i+"]"].value=tamt;
                      }else
                            document.MyForm.elements["txtDownTime["+i+"]"].value='0';
                      
                }
          }
          
          var tamt1 = new NumberFormat(TotalAmount1);
          //var tamtT = new NumberFormat(tam);
          //alert(tam);
          tamt1.setPlaces(2);
          tamt1.setSeparators(false);
          var ptamount1 =parseFloat(tamt1.toFormatted());
          document.MyForm.txtTotalDownTime.value=ptamount1;
          calculateTotalAmount();
          //alert(Index1);
          //getAmount(Index1);
      
    }

    
    function checkReceiveType(val)
    {
          //alert(val);
          document.MyForm.elements["rdoReceiveType"].value=val
          if(val=='C' || val=='D')
          {
                
                document.MyForm.txtChequeNo.disabled=true;
                document.MyForm.cboChequeDay.disabled=true;
                document.MyForm.cboChequeMonth.disabled=true;
                document.MyForm.cboChequeYear.disabled=true;
          }
          else
          {
                
                document.MyForm.txtChequeNo.disabled=false;
                document.MyForm.cboChequeDay.disabled=false;
                document.MyForm.cboChequeMonth.disabled=false;
                document.MyForm.cboChequeYear.disabled=false;
          }
    }
    
    function sendValue()
    {
				var Index=parseInt(document.MyForm.hidIndex.value);
				var NetBill;
				var ReceivedAmount;
				var Amount;
				var PossibleMaxAmount;
				//alert("working");
				if(document.MyForm.elements["rdoReceiveType"].value=='')
				{
					alert("Please Enter Received Type")
					return;
				}
				
				var Flag=true;
				for (var i=0;i<Index;i++)
				{
					if(document.MyForm.elements["chkAccept["+i+"]"].checked)
					{
						NetBill=document.MyForm.elements["txtNetBill["+i+"]"].value;
						ReceivedAmount=document.MyForm.elements["txtReceivedAmount["+i+"]"].value;
						Amount=parseFloat(document.MyForm.elements["txtAmount["+i+"]"].value);
						PossibleMaxAmount=parseFloat(NetBill)-parseFloat(ReceivedAmount);

						if(Amount>PossibleMaxAmount || Amount<=0 || isNaN(Amount))
						{
								alert ("Please Enter Valid Amount.");
								document.MyForm.elements["txtAmount["+i+"]"].focus();
								return;
						}
						Flag=false;
					}
				}
				if(Flag)
				{
					alert("Please Select At List One Invoice.");
					return;
				}

				$.ajax({
			        type: "POST",
			        url: "invoice_collection_save.php",
			        data: $('#modal_form').serialize(),

			    }).done(function(msg) {
			        alert(msg);
			        //$('#test').html(msg);
			        viewdata();
			    }).fail(function() {
			        alert("error");

			    });
    }
    
</script> --}}
@endsection