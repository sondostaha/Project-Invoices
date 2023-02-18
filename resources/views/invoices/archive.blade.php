@extends('layouts.master')
@section('title')
ارشيف الفواتير
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

	@if (session()->has('delete_invoice'))

		<script>
			window.onload = function(){
			notif({
				msg="تم استعاده الفاتوره بنجاح"
				type="success"
			})
			}
		</script>
									
	@endif
				<!-- row -->
				<div class="row">
					<!--div-->
				
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								
									<a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
											class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
								
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">رقم الفاتوره</th>
												<th class="border-bottom-0">تريخ الفاتوره</th>
												<th class="border-bottom-0">تاريخ الاستحقاق</th>
												<th class="border-bottom-0">المنتج</th>
												<th class="border-bottom-0">القسم</th>
												<th class="border-bottom-0">الخصم</th>
												<th class="border-bottom-0">نسبه الضريبه</th>
												<th class="border-bottom-0">الاجمالي</th>
												<th class="border-bottom-0">الحاله</th>
												<th class="border-bottom-0">ملاحظات</th>
												<th class="border-bottom-0">العمليات</th>
												<th class="border-bottom-0"></th>
												
											</tr>
										</thead>
										<tbody>
											<?php $i=0 ?>
											@foreach ($invoices as $invoice)
												<?php $i++?>
											
											<tr>
												<td>{{$i}}</td>
												<td>{{$invoice->invoices_number}}</td>
												<td>{{$invoice->invoice_date}}</td>
												<td>{{$invoice->due_date}}</td>
												<td>{{$invoice->product}}</td>
												<td>
													<a  href="{{route('invoicesDetails',$invoice->id)}}">
														{{$invoice->section->section_name}}
													</a>
												</td>
												<td>{{$invoice->discount}}</td>
												<td>{{$invoice->rate_vat}}</td>
												<td>{{$invoice->total}}</td>

												<td>
													@if($invoice->value_status== 1)
													<span class="text-success">{{$invoice->status}}</span>
													
													@elseif($invoice->value_status== 2)
													<span class="text-danger">{{$invoice->status}}</span>
													
													@else
													<span class="text-warning">{{$invoice->status}}</span>
												</td>
													@endif

												<td>{{$invoice->note}}</td>

												<td>
													<div class="dropdown">
														<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
														data-toggle="dropdown" id="dropdownMenuButton" type="button"> العمليات <i class="fas fa-caret-down ml-1"></i></button>
														<div  class="dropdown-menu tx-13">
															<a class="dropdown-item" href="{{url('edit_invoice')}}/{{$invoice->id}}">تعديل الفاتوره</a>

															<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
																data-toggle="modal" data-target="#delete_invoice"><i
																	class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
																الفاتورة</a>

																
	

															<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
																data-toggle="modal" data-target="#Transfer_invoice"><i
																	class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp; استعاده الفاتوره 
																</a>

																
														</div>
													</div>
													
												</td>
												
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->

						<!--div-->
								<!--  استاعده الفاتوره المتارشفه -->
				<div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">الغاء ارشفه الفاتوره </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<form action="{{route('archive.update','test')}}" method="post">
								{{ method_field('patch') }}
								{{ csrf_field() }}
						</div>
						<div class="modal-body">
							هل انت متاكد من عملية الغاء الارشفة ؟
							<input type="hidden" name="invoice_id" id="invoice_id" value="">
							

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
							<button type="submit" class="btn btn-success">تاكيد</button>
						</div>
						</form>
					</div>
				</div>
			</div>


				<!-- delete -->
				<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">حذف الارشيف</h5>
							<button type="button" class="close" data-dismiss="modal" a ria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						
						<form action="{{route('archive.destroy','test')}}" method="post">

							@method('delete')
							
							{{ csrf_field() }}

						</div>
							<div class="modal-body">
								<p class="text-center">
									<input type="hidden" name="invoice_id" id="invoice_id" value="">
								<h6 style="color:red"> هل انت متاكد من عملية حذف الارشيف ؟</h6>
								</p>
							</div>
								
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
								<button type="submit" class="btn btn-danger">تاكيد</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>

						
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

<script>
	$('#delete_invoice').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var invoice_id = button.data('invoice_id')
		var modal = $(this)
		modal.find('.modal-body #invoice_id').val(invoice_id);
		
	})
</script>

<script>
	$('#Transfer_invoice').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var invoice_id = button.data('invoice_id')
		var modal = $(this)
		modal.find('.modal-body #invoice_id').val(invoice_id);
		
	})
</script>


@endsection