@extends('layout.app')

@section('menu_active')
	@php($active = 'Operational')
@endsection

@section('style')
<style type="text/css">
	
</style>
<link href="{{ asset('') }}plugins/DataTables/css/data-table.css" rel="stylesheet" />
@endsection

@section('script')
<script type="text/javascript" src="{{ url('plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.charts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/themes/fusioncharts.theme.carbon.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/DataTables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/DataTables/js/dataTables.responsive.js') }}"></script>

<script type="text/javascript">
	var kemarin = moment("{{ date('Y-m-d') }}").subtract(1, 'days').format("DD-MM-YYYY");
    $('#last_update').html( kemarin );
	getData('1',{{ $now_bln }},{{ $now_thn }});

	$('#bln option[value='+{{ $now_bln }}+']').attr('selected','selected');
	$('#thn option[value='+{{ $now_thn }}+']').attr('selected','selected');
	function drawTable(datasrc){
		$('#accumulated').DataTable( {
			data: datasrc.atable,
			"searching": false,
			"lengthChange": false,
			"destroy" : true,
			"columns": [
				{ title: "Date" },
				{ title: "Production", render: $.fn.dataTable.render.number( ',', '.', 0 ) },
				{ title: "Target"  , render: $.fn.dataTable.render.number( ',', '.', 0 ) }
			]
		} );
		$('#daily').DataTable( {
			data: datasrc.dtable,
			"searching": false,
			"lengthChange": false,
			"destroy" : true,
			"columns": [
				{ title: "Date" },
				{ title: "Production", render: $.fn.dataTable.render.number( ',', '.', 0 ) },
				{ title: "Target"  , render: $.fn.dataTable.render.number( ',', '.', 0 ) }
			]
		} );
	}
	function getData(ks_produk,bln,thn) {
        $.get('{{ url('proddaily') }}', {produk: ks_produk, bulan: bln, tahun: thn}, function(data, textStatus, xhr) {
            
			var data_produk = data.produk;
			drawTable(data);
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

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Daily </h4>
	</div>
	<div class="panel-body">
		<div class="alert alert-info">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <strong>NOTE : </strong> LAST UPDATE : <span id="last_update"></span> 24:00 WIB <br>
	    </div>
		<form class="form-horizontal">
            <div class="form-group">
                <label class="col-md-2 control-label">Product Type : </label>
                <div class="col-md-4">
                    <select name="ks_produk" id="ks_produk" class="form-control" 
                    onchange="getData( $(this).val(),$('#bln').val(),$('#thn').val() )">
                        {{-- <option value="" selected>Pilih Produk</option>
						<option value="TTL" >Total</option>
						<option value="drp" >DRP</option>
						<option value="ssp" >SSP</option>
						<option value="hsm" >HSM</option>
						<option value="crc" >CRM-CRC</option>
						<option value="po" >CRM-PO</option>
						<option value="bsp" >BSP</option>
						<option value="wrm" >WRM</option> --}}
						@foreach($produk as $value)
                            <option value="{{ $value->id }}">{{ $value->ket }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                	<select name="bulan" id="bln" class="form-control" 
                	onchange="getData( $('#ks_produk').val(),$(this).val(),$('#thn').val() )">
                    	<option value="1" >Januari</option>
                    	<option value="2" >Februari</option>
                    	<option value="3" >Maret</option>
                    	<option value="4" >April</option>
                    	<option value="5" >Mei</option>
                    	<option value="6" >Juni</option>
                    	<option value="7" >Juli</option>
                    	<option value="8" >Agustus</option>
                    	<option value="9" >September</option>
                    	<option value="10" >Oktober</option>
                    	<option value="11" >November</option>
                    	<option value="12" >Desember</option>
                    </select>
                </div>
                <div class="col-md-2">
                	<select name="tahun" id="thn" class="form-control" 
                	onchange="getData( $('#ks_produk').val(),$('#bln').val(),$(this).val() )">
                    	@foreach($thn as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
		<div class="col-md-8">
			<div id="chart-container">FusionCharts will render here</div>
		</div>
		<div class="col-md-4">
			<table id="daily" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Production</th>
						<th>Target</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
						<th>Production</th>
						<th>Target</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Accumulated </h4>
	</div>
	<div class="panel-body">
		<div class="col-md-8">
			<div id="chart-accumulate">FusionCharts will render here</div>
		</div>
		<div class="col-md-4">
			<table id="accumulated" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Date</th>
						<th>Production</th>
						<th>Target</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Date</th>
						<th>Production</th>
						<th>Target</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection