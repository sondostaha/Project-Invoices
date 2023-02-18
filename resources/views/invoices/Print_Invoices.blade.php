@extends('layouts.master')

@section('title')
طباعه الفاتوره
@endsection
@section('css')
<style>
    @media print {
        #print_Button {
            display: none;
        }
    }

</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">صفحه</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معاينه طباعه الفاتوره</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">فاتوره تحصيل</h1>
										<div class="billed-from">
											<h6>فاتوره رقم {{$invoice->id}}</h6>
											<p>اسم المستدم: {{Auth::user()->name}}<br>
											البريد الالكتروني: {{Auth::user()->email}}</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
								
										<div class="col-md">
											<label class="tx-gray-600">معلومات الفاتوره </label>
											<p class="invoice-info-row"><span>رقم الفاتوره</span> <span>{{$invoice->invoices_number}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاصدار</span> <span>{{$invoice->invoice_date}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاستحقاق</span> <span>{{$invoice->due_date}}</span></p>
											<p class="invoice-info-row"><span>القسم</span> <span>{{$invoice->section->section_name}}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">#</th>
													<th class="wd-40p">المنتج</th>
													<th class="tx-center">مبلغ التحصيل</th>
													<th class="tx-right">مبل العموله </th>
													<th class="tx-right">الاجمالي</th>
												</tr>
											</thead>
											<tbody>
                                                <tr>
												<td >1</td>
	                                            <td >{{$invoice->product}}</td>
                                                <td class="tx-center">{{number_format($invoice->amount_collection,2)}}</td>
                                                <td class="tx-center">{{number_format($invoice->amount_commission,2)}}</td>
                                                @php
                                                $total =$invoice->amount_collection + $invoice->amount_commission
                                            @endphp
                                            <td class="tx-center">{{number_format($total,2)}}</td>

                                                </tr>
												
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<!-- invoice-notes -->
													</td>
													<td class="tx-right">الاجمالي </td>
													<td class="tx-right" colspan="2">{{$total}}</td>
												</tr>
												<tr>
													<td class="tx-right">نسبه الضريبه (5%)</td>
													<td class="tx-right" colspan="2">{{$invoice->value_vat}}</td>
												</tr>
												<tr>
													<td class="tx-right">الخصم</td>
													<td class="tx-right" colspan="2">{{$invoice->discount}}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبه</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">{{number_format($invoice->total,2)}}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									
									
									<a href="#" id="print_button" class="btn btn-danger float-left mt-3 mr-2" onclick="printDiv()">
										<i class="mdi mdi-printer ml-1"></i>طباعه
									</a>
                                </div>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>

@endsection