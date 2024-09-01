
    <div class="main_content_iner mt-0">
        
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="">
                <div class="px-4 py-1 theme_bg_1">
                    <h5 class="mb-0 text-white text-center">Monthly Invoice</h5>
                </div>
            </div>
					<div class="px-4 py-1">
                    <h5 class="mb-0 text-center">Millennium Computers And Networking</h5>
					<h5 class="mb-0 text-center">Monthly Invoice</h5>
					<h5 class="mb-0 text-center">For The Month of {{ $invoiceMonth}} - {{ $invoiceYear}}</h5>
                </div>

            <div class="QA_table p-3 pb-0 table-responsive">
                @php
                    $count  = 1;
                @endphp

                <table class="table table-responsive">
                    <thead>
                        <tr>
						
				<th>SL.</th>
			  <th>Invoice No</th>
			  <th width="50px">Client ID</th>
			  <th width="50px">Client Name</th>
              <th>Service Name</th>
              <th width="50px">Mobile</th>
              <th width="50px">Address</th>
			  <th>Arrear</th>
			  <th>Bill Amount</th>			 
			  <th>Total Bill</th>
			  <th>Col Amt</th>
			  <th>Adj Amt</th>
              <th>Vat Adj</th>
              <th>AIT Adj</th>
			  <th>Discount</th>
              <th>DownTime Adj</th>
			  <th>Total Due</th>
			  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cust_invoices as $cust_invoice)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $cust_invoice->invoice_number }}</td>
                            <td>{{ $cust_invoice->user_id }}</td>
                            <td>{{ $cust_invoice->customer_name }}</td>
                            <td>{{ $cust_invoice->srv_name }}</td>
                            <td>{{ $cust_invoice->mobile1 }}</td>
                            <td>{{ $cust_invoice->present_address }}</td>
                            <td>{{ $cust_invoice->cur_arrear }}</td> 
                            <td>{{ $cust_invoice->total_bill }}</td>
							 <td>{{ $cust_invoice->total_bill + $cust_invoice->cur_arrear}}</td>
                            <td>{{ $cust_invoice->collection_amnt }}</td>
                            <td>{{ $cust_invoice->other_adjustment }}</td>
							<td>{{ $cust_invoice->vat_adjust_ment }}</td> 
							   <td>{{ $cust_invoice->ait_adjustment }}</td> 
							 <td>{{ $cust_invoice->discount_amnt }}</td>
							  <td>{{ $cust_invoice->downtimeadjust }}</td>
							   <td>{{ $cust_invoice->cur_arrear +  $cust_invoice->total_bill - $cust_invoice->collection_amnt - $cust_invoice->other_adjustment - $cust_invoice->vat_adjust_ment - $cust_invoice->ait_adjustment - $cust_invoice->discount_amnt - $cust_invoice->downtimeadjust}}</td> 
							   
	
	
                        </tr>
                        @endforeach               
                    </tbody>
                </table>
            </div>
        </div>

    </div>
