@extends('layout.app')

@section('menu_active')
	@php($active = 'Logistic')
@endsection

@section('style')
<style type="text/css">

</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('public/plugins/fusioncharts/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/fusioncharts/js/fusioncharts.charts.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/fusioncharts/js/themes/fusioncharts.theme.carbon.js') }}"></script>
<script type="text/javascript">
	getData();

	function getData() {
        $.get('{{ url('preqbln') }}',  function(datanya, textStatus, xhr) {

		//var data_produk = data.produk;
		 FusionCharts.ready(function() {
			chartObj = new FusionCharts({
				type: "pie3d",  
				width: "100%", 
				height: "300",
				
				id: 'chart-mm1',	
				dataFormat: "json",			
				renderAt: 'chart-mm',
				dataSource : {
						"chart": {
							"caption": "PR TERBIT - MATERIAL BAHAN BAKU",
							"subCaption": "September 2017",
							"startingAngle": "120",
							"showLabels": "0",
							"showLegend": "1",
							"enableMultiSlicing": "0",
							"slicingDistance": "15",                
							"showPercentValues": "1",
							"showPercentInTooltip": "0",
							//"plotTooltext": "Age group : $label<br>Total visit : $datavalue",
							"theme": "fint"
						},
						"data": datanya.br
						
					}
			}).render();
			
			chartObj = new FusionCharts({
				type: "pie3d",  
				width: "100%", 
				height: "300",
				
				id: 'chart-js1',	
				dataFormat: "json",			
				renderAt: 'chart-js',
				dataSource : {
						"chart": {
							"caption": "PR TERBIT - JASA",
							"subCaption": "September 2017",
							"startingAngle": "120",
							"showLabels": "0",
							"showLegend": "1",
							"enableMultiSlicing": "0",
							"slicingDistance": "15",                
							"showPercentValues": "1",
							"showPercentInTooltip": "0",
							//"plotTooltext": "Age group : $label<br>Total visit : $datavalue",
							"theme": "fint"
						},
						"data": datanya.js
						
					}
			}).render();
			
			//=========================== Sampai dengan bulan berjalan ================================
			
			chartObj = new FusionCharts({
				type: "pie3d",  
				width: "100%", 
				height: "300",
				
				id: 'chart-bmm1',	
				dataFormat: "json",			
				renderAt: 'chart-bmm',
				dataSource : {
						"chart": {
							"caption": "PR TERBIT - MATERIAL BAHAN BAKU",
							"subCaption": "Sampai Dengan September 2017",
							"startingAngle": "120",
							"showLabels": "0",
							"showLegend": "1",
							"enableMultiSlicing": "0",
							"slicingDistance": "15",                
							"showPercentValues": "1",
							"showPercentInTooltip": "0",
							//"plotTooltext": "Age group : $label<br>Total visit : $datavalue",
							"theme": "fint"
						},
						"data": datanya.bbr
						
					}
			}).render();
			
			chartObj = new FusionCharts({
				type: "pie3d",  
				width: "100%", 
				height: "300",
				
				id: 'chart-bjs1',	
				dataFormat: "json",			
				renderAt: 'chart-bjs',
				dataSource : {
						"chart": {
							"caption": "PR TERBIT - JASA",
							"subCaption": "Sampai Dengan September 2017",
							"startingAngle": "120",
							"showLabels": "0",
							"showLegend": "1",
							"enableMultiSlicing": "0",
							"slicingDistance": "15",                
							"showPercentValues": "1",
							"showPercentInTooltip": "0",
							//"plotTooltext": "Age group : $label<br>Total visit : $datavalue",
							"theme": "fint"
						},
						"data": datanya.bjs
						
					}
			}).render();
			
		 });
		

        });
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

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Purchase Requisition Release </h4>
	</div>
	<div class="panel-body">
		<div class="col-md-6">
			<div id="chart-mm">FusionCharts will render here</div>
		</div>
		<div class="col-md-6">
			<div id="chart-js">FusionCharts will render here</div>
		</div>
	</div>
</div>

<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Purchase Requisition Release </h4>
	</div>
	<div class="panel-body">
		<div class="col-md-6">
			<div id="chart-bmm">FusionCharts will render here</div>
		</div>
		<div class="col-md-6">
			<div id="chart-bjs">FusionCharts will render here</div>
		</div>
	</div>
</div>

@endsection
