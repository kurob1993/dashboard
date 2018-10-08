@extends('layout.app')

@section('menu_active')
    @php($active = 'Project')
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
    function getData(thn) {
        $.get('{{ url('budget') }}/'+thn, function(data, textStatus, xhr) {
            
            $('#chart').find('div').remove();
            // $('#chart_usd').find('div').remove();

            $.each(data.label, function(index, val) {
                 $('#chart').append('<div id="chart-container_IDR'+index+'" width="100%">FusionCharts will render here</div>')
                 chart("IDR",val,index,data.anggaran_idr[index],data.title[index],data.realisasi_idr[index],data.deviasi_idr[index]);
            });
            // $.each(data.label, function(index, val) {
            //      $('#chart_usd').append('<div id="chart-container_USD'+index+'" width="100%">FusionCharts will render here</div>')
            //      chart("USD",val,index,data.anggaran_usd[index],data.title[index]);
            // });
        });
    }
    function chart(curr,category,index,anggaran,title,realisasi_idr,deviasi_idr) {
        console.log(realisasi_idr);
            FusionCharts.ready(function() {
              var compChart = new FusionCharts({
                type: 'mscolumn2d',
                renderAt: 'chart-container_'+curr+index,
                width: '100%',
                height: '400',
                dataFormat: 'json',
                dataSource: {
                  "chart": {
                    "caption": title[0].title,
                    "paletteColors": "#008ee4,#f8bd19,#33bdda,#e44a00,#6baa01,#583e78",
                    "baseFontColor": "#333333",
                    "baseFontSize" : "9",
                    "baseFont": "Helvetica Neue,Arial",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0",
                    "showBorder": "0",
                    "bgColor": "#ffffff",
                    "showShadow": "0",
                    "canvasBgColor": "#ffffff",
                    "canvasBorderAlpha": "0",
                    "divlineAlpha": "100",
                    "divlineColor": "#999999",
                    "divlineThickness": "1",
                    "divLineDashed": "1",
                    "divLineDashLen": "1",
                    "usePlotGradientColor": "0",
                    "showplotborder": "0",
                    "valueFontColor": "#000000",
                    "placeValuesInside": "0",
                    "showHoverEffect": "1",
                    "rotateValues": "1",
                    "showXAxisLine": "1",
                    "xAxisLineThickness": "1",
                    "xAxisLineColor": "#999999",
                    "showAlternateHGridColor": "0",
                    "legendBgAlpha": "0",
                    "legendBorderAlpha": "0",
                    "legendShadow": "0",
                    "legendItemFontSize": "10",
                    "legendItemFontColor": "#666666",
                    "labelDisplay": "rotate",
                    "slantLabels": "1",
                  },

                  "categories": [{
                    "category": category
                  }],
                  "dataset": [{
                    "seriesname": "Anggaran ("+curr+")",
                    "data": anggaran
                  },{
                    "seriesname": "Realisasi ("+curr+")",
                    "data": realisasi_idr
                  },{
                    "seriesname": "Deviasi ("+curr+")",
                    "data": deviasi_idr
                  }]
                }

              }).render();
            });

    }
</script>
@endsection

@section('content')
<!-- begin page-header -->
<h1 class="page-header">Dashboard Operation Excellence </h1>
<!-- end page-header -->
    
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                    <i class="fa fa-expand"></i>
                </a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse">
                    <i class="fa fa-minus"></i>
                </a>
            </div>
            <h4 class="panel-title"><span class="fa fa-dashboard"></span> Realisasi Serapan Anggaran | RKAP <span id="thn">-</span> (TOTAL S/D)</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" target="_blank" action="https://sso.krakatausteel.com/scm/dboard/from_dashboard.php" method="POST">
                <div class="form-group">
                    <label class="col-md-2 control-label">Tahun : </label>
                    <div class="col-md-4">
                        <select name="ks_produk" id="ks_produk" class="form-control" onchange="getData($(this).val());$('#thn').html($(this).val());$('#linkTOeis').val('https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&pmoid=6&yy='+$(this).val())">
                            <option value="" selected>Pilih Tahun</option>
                            @foreach($pmo_kurs as $value)
                                <option value="{{ $value->kurs_tahun }}">{{ $value->kurs_tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">

                        <input type="hidden" name="link" id="linkTOeis" value="https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&pmoid=6&mt=2">
                        <input type="hidden" name="username" value="{{ session()->get('username') }}">
                        <input type="submit" value="Link To EIS" class="btn btn-sm btn-primary">

                        {{-- <a target="_blank" href="https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&pmoid=6&mt=2" class="btn btn-sm btn-primary"> Link To EIS</a> --}}
                    </div>
                </div>
            </form>
            <div class="row">
                <div id="chart" class="col-lg-12"></div>
                {{-- <div id="chart_usd" class="col-lg-6"></div> --}}
            </div>
        </div>
    </div>
@endsection