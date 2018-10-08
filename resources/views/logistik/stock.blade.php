
@extends('layout.app')

@section('menu_active')
	@php($active = 'Logistic')
@endsection

@section('style')
<link href="{{ url('public/plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
<style type="text/css">
</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
        $('#date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate :"{{ date('d/m/Y') }}",
        }).datepicker("update", "{{ date('d/m/Y') }}");
    });
	function show($tanggal) {
		$.get('{{ url('/logistic/show') }}/'+$tanggal,function(data){
			var date;
			$('#tbody').find('tr').remove();
			for (var i = 0; i < data.length; i++) {
				date = data[i].dateload.split(" ");
				$('#tbody').append('<tr>'+
					'<td>'+ (i+1) +'</td>'+
					'<td>'+data[i].deskripsi_kode+'</td>'+
					'<td style="text-align: right;">'+data[i].quantity+'</td>'+
					'<td>'+
						'<button class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-id" onclick="detail(`'+date[0]+'`,`'+data[i].deskripsi_kode+'`)">'+
							'<i class="fa fa-list"></i> Detail'+
						'</button>'+
					'</td>'+
				'</tr>');
			}	
			$('.last_update').html("<strong>Last Update : </strong>"+data[0].dateload);		
		})

	}
	function detail($date,$description) {
		$(".modal-title").html($description);
		$.get('{{ url('/logistic/detail') }}/'+$date+"/"+$description,function(data){
			$('.detail').find('tr').remove();
			for(i = 0; i < data.length; i++) {
				$('.detail').append('<tr><td>'+ (i+1) +'</td><td>'+data[i].deskripsi_kode+'</td><td>'+data[i].material+'</td><td>'+data[i].plant+'</td><td>'+data[i].sloc+'</td><td style="text-align: right;">'+data[i].quantity+'</td></tr>');
			}
		})

	}
	
</script>
@endsection

@section('content')
<!-- begin page-header -->
<h1 class="page-header">Dashboard Operation Excellence</h1>
<!-- end page-header -->

<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Stock </h4>
	</div>
	<div class="panel-body p-7">
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="last_update"><strong>Last Update : </strong> {{ $data[0]->dateload }} </span>
		</div>
		<div class="form-inline">
			<div class="form-group p-b-20">
				<label for="email">Date :</label>
				<input type="text" class="form-control" id="date" name="tanggal">
				<button class="btn btn-primary" onclick="show($('#date').val())">Cari</button>				
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				  <tr>
				    <th class="bg-primary text-white" width="5%">#</th>
				    <th class="bg-primary text-white" width="30%">DESCRIPTION</th>
				    <th class="bg-primary text-white" width="30%" style="text-align: right;">QUANTITY (Ton) </th>
				    <th class="bg-primary text-white" >Action </th>
				  </tr>
				</thead>
				<tbody id="tbody">
					@foreach($data as $key => $value)
					<tr>
						<td> {{ $key+1 }}</td>
						<td> {{ $value->deskripsi_kode }}</td>
						<td style="text-align: right;"> {{ $value->quantity }}</td>
						<td> <button class="btn btn-sm btn-primary" data-toggle="modal" href='#modal-id' onclick="detail( '{{ date("d-m-Y",strtotime($data[0]->dateload)) }}','{{ $value->deskripsi_kode }}')"><i class="fa fa-list"></i> Detail</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
        </div>
	</div>
</div>

<section>
	<div class="modal fade" id="modal-id">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">					
					<div class="table-responsive" style="height: 350px">
						<table class="table table-bordered">
							<thead>
							  <tr>
							    <th class="bg-primary text-white">#</th>
							    <th class="bg-primary text-white">DESCRIPTION</th>
							    <th class="bg-primary text-white">MATERIAL</th>
				    			<th class="bg-primary text-white">PLANT</th>
				    			<th class="bg-primary text-white">SLOC</th>
							    <th class="bg-primary text-white">QUANTITY (Ton) </th>
							  </tr>
							</thead>
							<tbody class="detail">
							</tbody>
						</table>
			        </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					{{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
				</div>
			</div>
		</div>
	</div>
</section>
@endsection