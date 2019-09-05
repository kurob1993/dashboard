@extends('layout.app')

@section('menu_active')
    @php($active = 'Operational')
@endsection

@section('style')
<style type="text/css">
</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('plugins/number_js/numeral.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.charts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/themes/fusioncharts.theme.carbon.js') }}"></script>

<script type="text/javascript">
    setInterval(blink_text, 1500);
    function blink_text() {
        $('.blink').fadeOut(500);
        $('.blink').fadeIn(500);
    }
    setInterval(data, 15000);
    function data(plant = null ) {
        $.get("{{ url('last_prod/show/HSM') }}",function(data){
            $('#hsm').find('tr').remove();
            for (var i = 0; i < data.length; i++) {
                if(data[i].ANLAGE == 'FM' || data[i].ANLAGE == 'HSPM' || data[i].ANLAGE == 'SHL1' || data[i].ANLAGE == 'SHL2'){

                    if(data[i].DIFF <= 10 ){
                        var warna = "text-success ";
                    }else if(data[i].DIFF <= 15 ){
                        var warna = "text-warning  blink";
                    }else{
                        var warna = "text-danger ";
                    }

                    $('#hsm').append('<tr>'+
                        '<td>'+
                            data[i].BEREICH+
                            ' <button class="btn btn-xs btn-danger" onclick="chart(`'+data[i].BEREICH+'`,`'+data[i].ANLAGE+'`)" >'+
                                '<span class="fa fa-bar-chart"></span>'+
                            '</button> '+
                        '</td>'+
                        '<td>'+data[i].ANLAGE+'</td>'+
                        '<td align="center">'+
                            '<span class="fa fa-circle '+warna+' fa-2x"></span>'+
                        '</td>'+
                        '<td>'+data[i].DIFF_VALUE+'</td>'+
                        '<td>'+data[i].LAST_PROD+'</td>'+
                        '<td align="right">'+numeral(data[i].GEWINPUT_TOTAL).format('0,0')+'</td>'+
                        '<td align="right">'+numeral(data[i].GEWOUTPUT_TOTAL).format('0,0')+'</td>'+
                        '<td align="right">'+numeral(data[i].SCRAPWEIGHT_TOTAL).format('0,0')+'</td>'+
                        '<td align="right">'+numeral( (data[i].GEWOUTPUT_TOTAL/data[i].GEWINPUT_TOTAL)*100 ).format('0,0')+'%</td>'+
                    '</tr>');
                }
            }
        });

        $.get("{{ url('last_prod/show/CRM') }}",function(data){
            $('#crm').find('tr').remove();
            for (var i = 0; i < data.length; i++) {
                if(data[i].DIFF <= 10 ){
                    var warna = "text-success ";
                }else if(data[i].DIFF <= 15 ){
                    var warna = "text-warning  blink";
                }else{
                    var warna = "text-danger ";
                }
                $('#crm').append('<tr>'+
                    '<td>'+
                        data[i].BEREICH+
                        ' <button class="btn btn-xs btn-danger" onclick="chart(`'+data[i].BEREICH+'`,`'+data[i].ANLAGE+'`)" >'+
                            '<span class="fa fa-bar-chart"></span>'+
                        '</button> '+
                    '</td>'+
                    '<td>'+data[i].ANLAGE+'</td>'+
                    '<td align="center">'+
                        '<span class="fa fa-circle '+warna+' fa-2x"></span>'+
                    '</td>'+
                    '<td>'+data[i].DIFF_VALUE+'</td>'+
                    '<td>'+data[i].LAST_PROD+'</td>'+
                    '<td align="right">'+numeral(data[i].GEWINPUT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral(data[i].GEWOUTPUT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral(data[i].SCRAPWEIGHT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral( (data[i].GEWOUTPUT_TOTAL/data[i].GEWINPUT_TOTAL)*100 ).format('0,0')+'%</td>'+
                '</tr>');
            }
        });

        $.get("{{ url('last_prod/show/SSP1') }}",function(data){
            $('#ssp1').find('tr').remove();
            for (var i = 0; i < data.length; i++) {
                if(data[i].DIFF <= 10 ){
                    var warna = "text-success ";
                }else if(data[i].DIFF <= 15 ){
                    var warna = "text-warning  blink";
                }else{
                    var warna = "text-danger ";
                }
                $('#ssp1').append('<tr>'+
                    '<td>'+
                        data[i].BEREICH+
                        ' <button class="btn btn-xs btn-danger" onclick="chart(`'+data[i].BEREICH+'`,`'+data[i].ANLAGE+'`)" >'+
                            '<span class="fa fa-bar-chart"></span>'+
                        '</button> '+
                    '</td>'+
                    '<td>'+data[i].ANLAGE+'</td>'+
                    '<td align="center">'+
                        '<span class="fa fa-circle '+warna+' fa-2x"></span>'+
                    '</td>'+
                    '<td>'+data[i].DIFF_VALUE+'</td>'+
                    '<td>'+data[i].LAST_PROD+'</td>'+
                    '<td align="right">'+numeral(data[i].GEWINPUT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral(data[i].GEWOUTPUT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral(data[i].SCRAPWEIGHT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral( (data[i].GEWOUTPUT_TOTAL/data[i].GEWINPUT_TOTAL)*100 ).format('0,0')+'%</td>'+
                '</tr>');
            }
        });

        $.get("{{ url('last_prod/show/SSP2') }}",function(data){
            $('#ssp2').find('tr').remove();
            for (var i = 0; i < data.length; i++) {
                  if(data[i].DIFF <= 10 ){
                      var warna = "text-success ";
                  }else if(data[i].DIFF <= 15 ){
                      var warna = "text-warning  blink";
                  }else{
                      var warna = "text-danger ";
                  }
                $('#ssp2').append('<tr>'+
                    '<td>'+
                        data[i].BEREICH+
                        ' <button class="btn btn-xs btn-danger" onclick="chart(`'+data[i].BEREICH+'`,`'+data[i].ANLAGE+'`)" >'+
                            '<span class="fa fa-bar-chart"></span>'+
                        '</button> '+
                    '</td>'+
                    '<td>'+data[i].ANLAGE+'</td>'+
                    '<td align="center">'+
                        '<span class="fa fa-circle '+warna+' fa-2x"></span>'+
                    '</td>'+
                    '<td>'+data[i].DIFF_VALUE+'</td>'+
                    '<td>'+data[i].LAST_PROD+'</td>'+
                    '<td align="right">'+numeral(data[i].GEWINPUT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral(data[i].GEWOUTPUT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral(data[i].SCRAPWEIGHT_TOTAL).format('0,0')+'</td>'+
                    '<td align="right">'+numeral( (data[i].GEWOUTPUT_TOTAL/data[i].GEWINPUT_TOTAL)*100 ).format('0,0')+'%</td>'+
                '</tr>');
            }
        });
    }

    function chart(plant,line) {
        $.get("{{ url('last_prod/chart') }}/"+plant+"/"+line,function(data){
            $('#chart').modal('show');
            FusionCharts.ready(function() {
                chartObj = new FusionCharts({
                    swfUrl      : "msstepline",
                    width       : "100%",
                    height      : "400",
                    dataFormat  : 'json',
                    renderAt    : 'chart-container',
                    dataSource  : {
                        "chart": {
                            "caption": "",
                            "labelDisplay": "rotate",
                            "slantLabels": "1",
                            "yaxisname": "",
                            "showvalues": "0",
                            "showalternatevgridcolor": "1",
                            "bgalpha": "45",
                            "bgcolor": "DFDFDF",
                            "numdivlines": "4",
                            "showalternatehgridcolor": "1",
                            "outcnvbasefont": "Verdana",
                            "outcnvbasefontsize": "12",
                            "canvasborderthickness": "1",
                            "canvasbordercolor": "CDCDCD",
                            "anchorradius": "4",
                            "anchorsides": "16",
                            "anchorbgcolor": "FFFFFF",
                            "anchorbordercolor": "6F6F6F",
                            "alternatevgridalpha": "10",
                            "alternatehgridcolor": "FAE4E9",
                            "alternatehgridalpha": "40",
                            "alternatevgridcolor": "CFCFCF",
                            "linethickness": "2",
                            "anchorborderthickness": "2",
                            "linedashgap": "5",
                            "divlinealpha": "5",
                            "canvasborderalpha": "60",
                            "outcnvbasefontcolor": "43302E",
                            "legendbordercolor": "6C1121",
                            "legendborderalpha": "40",
                            "legendborderthickness": "2",
                            "bordercolor": "CDCDCD",
                            "borderalpha": "70",
                            "showborder": "0"
                        },
                        "categories": [
                            {
                                "category": data.category
                            }
                        ],
                        "dataset": [
                            {
                                "seriesname": plant+" - "+line,
                                "anchorbordercolor": "B50F27",
                                "color": "BB2644",
                                "data": data.data
                            }
                        ]
                    }
                }).render();

            });
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
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>

        <h4 class="panel-title"><span class="fa fa-recycle"></span> DETAIL PRODUCTION</h4>
    </div>
    <div class="panel-body">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>HOT STRIP MILL (HSM)</strong>

            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>PLANT</th>
                                <th>LINE</th>
                                <th>STATUS</th>
                                <th>LOST TIME</th>
                                <th>LAST PRODUCTION</th>

                                <th class="text-right">RAW MATERIAL (TON)</th>
                                <th class="text-right">PRODUCT (TON)</th>
                                <th class="text-right">SCRAP (TON)</th>
                                <th class="text-right">YIELD</th>
                            </tr>
                        </thead>
                        <tbody id="hsm">
                            @foreach($HSM as $key => $value)
                                @if($value->ANLAGE == 'FM' OR $value->ANLAGE == 'HSPM' OR $value->ANLAGE == 'SHL1' OR $value->ANLAGE == 'SHL2' )
                                    <tr>
                                        <td>
                                            {{$value->BEREICH}}
                                            <button class="btn btn-xs btn-danger" onclick="chart('{{$value->BEREICH}}','{{$value->ANLAGE}}')" >
                                                <span class="fa fa-bar-chart"></span>
                                            </button>
                                        </td>
                                        <td>{{$value->ANLAGE}}</td>
                                        <td class="text-center">
                                            @if($value->DIFF <= 10)
                                                <span class="fa fa-circle text-success fa-2x"></span>
                                            @elseif($value->DIFF <= 15)
                                              <span class="fa fa-circle text-warning blink fa-2x"></span>
                                            @else
                                                <span class="fa fa-circle text-danger blinkD fa-2x"></span>
                                            @endif
                                        </td>
                                        <td>{{$value->DIFF_VALUE}}</td>
                                        <td>{{$value->LAST_PROD}}</td>

                                        <td align="right">{{ number_format($value->GEWINPUT_TOTAL) }}</td>
                                        <td align="right">{{ number_format($value->GEWOUTPUT_TOTAL) }}</td>
                                        <td align="right">{{ number_format($value->SCRAPWEIGHT_TOTAL) }}</td>
                                        <td align="right">{{ number_format( ($value->GEWOUTPUT_TOTAL/$value->GEWINPUT_TOTAL)*100,2) }}%</td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">COLD ROLLING MILL (CRM)</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>PLANT</th>
                                <th>LINE</th>
                                <th>STATUS</th>
                                <th>LOST TIME</th>
                                <th>LAST PRODUCTION</th>

                                <th class="text-right">RAW MATERIAL (TON)</th>
                                <th class="text-right">PRODUCT (TON)</th>
                                <th class="text-right">SCRAP (TON)</th>
                                <th class="text-right">YIELD</th>
                            </tr>
                        </thead>
                        <tbody id="crm">
                            @foreach($CRM as $key => $value)
                                <tr>
                                    <td>
                                        {{$value->BEREICH}}
                                        <button class="btn btn-xs btn-danger" onclick="chart('{{$value->BEREICH}}','{{$value->ANLAGE}}')" >
                                            <span class="fa fa-bar-chart"></span>
                                        </button>
                                    </td>
                                    <td>
                                        {{$value->ANLAGE}}
                                    </td>
                                    <td align="center">
                                        @if($value->DIFF <= 10)
                                            <span class="fa fa-circle text-success fa-2x"></span>
                                        @elseif($value->DIFF <= 15)
                                          <span class="fa fa-circle text-warning blink fa-2x"></span>
                                        @else
                                            <span class="fa fa-circle text-danger blinkD fa-2x"></span>
                                        @endif
                                    </td>
                                    <td>{{$value->DIFF_VALUE}}</td>
                                    <td>{{$value->LAST_PROD}}</td>

                                    <td align="right">{{ number_format($value->GEWINPUT_TOTAL) }}</td>
                                    <td align="right">{{ number_format($value->GEWOUTPUT_TOTAL) }}</td>
                                    <td align="right">{{ number_format($value->SCRAPWEIGHT_TOTAL) }}</td>
                                    <td align="right">{{ number_format( ($value->GEWOUTPUT_TOTAL/$value->GEWINPUT_TOTAL)*100,2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">STEEL MAKING (SSP1 &amp; SSP2)</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>PLANT</th>
                                <th>LINE</th>
                                <th>STATUS</th>
                                <th>LOST TIME</th>
                                <th>LAST PRODUCTION</th>

                                <th class="text-right">RAW MATERIAL (TON)</th>
                                <th class="text-right">PRODUCT (TON)</th>
                                <th class="text-right">SCRAP (TON)</th>
                                <th class="text-right">YIELD</th>
                            </tr>
                        </thead>
                        <tbody id="ssp1">
                            @foreach($SSP1 as $key => $value)
                                <tr>
                                    <td>
                                        {{$value->BEREICH}}
                                        <button class="btn btn-xs btn-danger" onclick="chart('{{$value->BEREICH}}','{{$value->ANLAGE}}')" >
                                            <span class="fa fa-bar-chart"></span>
                                        </button>
                                    </td>
                                    <td>{{$value->ANLAGE}}</td>
                                    <td align="center">
                                        @if($value->DIFF <= 10)
                                            <span class="fa fa-circle text-success fa-2x"></span>
                                        @elseif($value->DIFF <= 15)
                                          <span class="fa fa-circle text-warning blink fa-2x"></span>
                                        @else
                                            <span class="fa fa-circle text-danger blinkD fa-2x"></span>
                                        @endif
                                    </td>
                                    <td>{{$value->DIFF_VALUE}}</td>
                                    <td>{{$value->LAST_PROD}}</td>

                                    <td align="right">{{ number_format($value->GEWINPUT_TOTAL) }}</td>
                                    <td align="right">{{ number_format($value->GEWOUTPUT_TOTAL) }}</td>
                                    <td align="right">{{ number_format($value->SCRAPWEIGHT_TOTAL) }}</td>
                                    <td align="right">{{ number_format( ($value->GEWOUTPUT_TOTAL/$value->GEWINPUT_TOTAL)*100,2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>PLANT</th>
                                <th>LINE</th>
                                <th>STATUS</th>
                                <th>LOST TIME</th>
                                <th>LAST PRODUCTION</th>

                                <th class="text-right">RAW MATERIAL (TON)</th>
                                <th class="text-right">PRODUCT (TON)</th>
                                <th class="text-right">SCRAP (TON)</th>
                                <th class="text-right">YIELD</th>
                            </tr>
                        </thead>
                        <tbody id="ssp2">
                            @foreach($SSP2 as $key => $value)
                                <tr>
                                    <td>
                                        {{$value->BEREICH}}
                                        <button class="btn btn-xs btn-danger" onclick="chart('{{$value->BEREICH}}','{{$value->ANLAGE}}')" >
                                            <span class="fa fa-bar-chart"></span>
                                        </button>
                                    </td>
                                    <td>{{$value->ANLAGE}}</td>
                                    <td align="center">
                                        @if($value->DIFF <= 10)
                                            <span class="fa fa-circle text-success fa-2x"></span>
                                        @elseif($value->DIFF <= 15)
                                          <span class="fa fa-circle text-warning blink fa-2x"></span>
                                        @else
                                            <span class="fa fa-circle text-danger blinkD fa-2x"></span>
                                        @endif
                                    </td>
                                    <td>{{$value->DIFF_VALUE}}</td>
                                    <td>{{$value->LAST_PROD}}</td>

                                    <td align="right">{{ number_format($value->GEWINPUT_TOTAL) }}</td>
                                    <td align="right">{{ number_format($value->GEWOUTPUT_TOTAL) }}</td>
                                    <td align="right">{{ number_format($value->SCRAPWEIGHT_TOTAL) }}</td>
                                    <td align="right">{{ number_format( ($value->GEWOUTPUT_TOTAL/$value->GEWINPUT_TOTAL)*100,2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="chart">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Chart</h4>
            </div>
            <div class="modal-body">
                <div id="chart-container">FusionCharts will render here</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
