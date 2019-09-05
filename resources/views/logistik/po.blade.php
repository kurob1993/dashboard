@extends('layout.app')

@section('menu_active')
	@php($active = 'Logistic')
@endsection

@section('style')
<style type="text/css">

</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.charts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/themes/fusioncharts.theme.carbon.js') }}"></script>
<script type="text/javascript">
	getData('TTL');

	function getData(ks_produk) {
        $.get('{{ url('proddaily') }}', {produk: ks_produk}, function(data, textStatus, xhr) {

			var data_produk = data.produk;

            FusionCharts.ready(function() {
				chartObj = new FusionCharts({
					swfUrl		: "msline",
					width		: "100%",
					height		: "400",
					id			: 'shipmenthari',
					dataFormat	: 'json',
					renderAt	: 'chart-container',
					dataSource: {
						"chart": {
							"caption": "Daily Production",
							"numberprefix": "",
							"plotgradientcolor": "",
							"bgcolor": "FFFFFF",
							"showalternatehgridcolor": "0",
							"divlinecolor": "CCCCCC",
							"showvalues": "0",
							"showcanvasborder": "0",
							"canvasborderalpha": "0",
							"canvasbordercolor": "CCCCCC",
							"canvasborderthickness": "2",
							//"yaxismaxvalue": "30000",
							"captionpadding": "30",
							"linethickness": "3",
							//"yaxisvaluespadding": "15",
							"legendshadow": "0",
							"legendborderalpha": "0",
							"palettecolors": "#f8bd19,#008ee4,#33bdda,#e44a00,#6baa01,#583e78",
							"showborder": "0"
						},

						"categories": data.categories,
						"dataset": data.dataset
					}
				}).render();

				chartObj = new FusionCharts({
					swfUrl		: "msline",
					width		: "100%",
					height		: "400",
					id			: 'shipmentbln',
					dataFormat	: 'json',
					renderAt	: 'chart-accumulate',
					dataSource: {
						"chart": {
							"caption": "Accumulated Production",
							"numberprefix": "",
							"plotgradientcolor": "",
							"bgcolor": "FFFFFF",
							"showalternatehgridcolor": "0",
							"divlinecolor": "CCCCCC",
							"showvalues": "0",
							"showcanvasborder": "0",
							"canvasborderalpha": "0",
							"canvasbordercolor": "CCCCCC",
							"canvasborderthickness": "2",
							//"yaxismaxvalue": "30000",
							"captionpadding": "30",
							"linethickness": "3",
							//"yaxisvaluespadding": "15",
							"legendshadow": "0",
							"legendborderalpha": "0",
							"palettecolors": "#f8bd19,#008ee4,#33bdda,#e44a00,#6baa01,#583e78",
							"showborder": "0"
						},

						"categories": data.categoriesa,
						"dataset": data.dataseta
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

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Accumulated </h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label">Product Type : </label>
                <div class="col-md-4">
                    <select name="ks_produk" id="ks_produk" class="form-control" onchange="getData($(this).val())">
                        <option value="" selected>Pilih Produk</option>
						<option value="TTL" >Total</option>
						<option value="drp" >DRP</option>
						<option value="ssp" >SSP</option>
						<option value="hsm" >HSM</option>
						<option value="crc" >CRM-CRC</option>
						<option value="po" >CRM-PO</option>
						<option value="bsp" >BSP</option>
						<option value="wrm" >WRM</option>
                        <!--
						@foreach($produk as $value)
                            <option value="{{ $value->produk }}">{{ $value->ket }}</option>
                        @endforeach
						-->
                    </select>
                </div>
            </div>
        </form>
		<div id="chart-accumulate">FusionCharts will render here</div>
	</div>
</div>

<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Daily </h4>
	</div>
	<div class="panel-body">
		<div id="chart-container">FusionCharts will render here</div>
	</div>
</div>

@endsection
