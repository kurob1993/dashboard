@extends('layout.app')

@section('menu_active')
	@php($active = 'Finance')
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
	getData('2018');
	
	function getData(thn) {
        $.get('{{ url('findaily') }}', {thn: thn}, function(data, textStatus, xhr) {
            
			var data_produk = data.produk;
			console.log(data);
            FusionCharts.ready(function() {
				chartObj = new FusionCharts({	
					swfUrl		: "msline",  
					width		: "100%", 
					height		: "400",
					id			: 'shipmenthari',	
					dataFormat	: 'json',			
					renderAt	: 'chart-accumulate',
					dataSource: {
						"chart": {
							// "caption": "Likuiditas " + data.thn,
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

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Monthly Liquidity </h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal">
            <div class="form-group">
				
                <label class="col-md-2 control-label"><strong>Likuiditas : <strong></label>
                <div class="col-md-4">
                    
					<select name="ks_produk" id="ks_produk" class="form-control" onchange="getData($(this).val())">
	                       
	                        @foreach($tahun as $value)
	                            <option value="{{ $value }}">{{ $value }}</option>
	                        @endforeach
	                    </select>
				
                </div>
				
            </div>
        </form>
		<div id="chart-accumulate">FusionCharts will render here</div>
	</div>
</div>


@endsection