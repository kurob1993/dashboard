@extends('layout.app')

@section('menu_active')
    @php($active = '')
@endsection

@section('style')
<link href="{{ url('plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
<style type="text/css">
    .bahan-baku {
        position: absolute;
        top: 24%;
        left: 13%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .platon {
        position: absolute;
        top: 42%;
        left: 13%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .open-rolling {
        position: absolute;
        top: 24%;
        left: 23%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .wip {
        position: absolute;
        top: 24%;
        left: 33%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .produksi {
        position: absolute;
        top: 13%;
        left: 42%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .produksi-today {
        position: absolute;
        top: 24%;
        left: 42%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .pa {
        position: absolute;
        top: 46%;
        left: 42%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .stock-fg {
        position: absolute;
        top: 24%;
        left: 50.5%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .cargo {
        position: absolute;
        top: 24%;
        left: 59.5%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .penjualan {
        position: absolute;
        top: 60%;
        left: 59%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .rts {
        position: absolute;
        top: 24%;
        left: 69%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .shipmen {
        position: absolute;
        top: 13%;
        left: 83%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .shipmen-today {
        position: absolute;
        top: 24%;
        left: 83%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .margin {
        position: absolute;
        top: 13%;
        left: 94%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    .gap-harga {
        position: absolute;
        top: 34%;
        left: 94%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }
    /*.child1 {
        position: absolute;
        top: 38%;
        left: 30%;
        transform: translate(-50%, -50%);
        color: black;
        font-weight: 500;
    }*/
    .child2 {
        /*border:1px solid black;*/
        position: absolute;
        top: 32%;
        left: 35%;
        transform: translate(-99%, -1%);
        color: black;
        font-weight: 300;
        text-align: right;
    }
    .freeStock {
        /*border:1px solid black;*/
        font-size: 74%;
        position: absolute;
        top: 32%;
        left: 56.5%;
        transform: translate(-1%, -99%,-1%);
        color: black;
        font-weight: 300;
        text-align: left;
    }
    .notrts {
        /*border:1px solid black;*/
        /*font-size: 80%;*/
        position: absolute;
        top: 32%;
        left: 65.5%;
        transform: translate(-1%, -99%,-1%);
        color: black;
        font-weight: 300;
        text-align: left;
    }
    .cir {
        /*border:1px solid black;*/
        /*font-size: 74%;*/
        position: absolute;
        top: 8%;
        left: 54.5%;
        transform: translate(-1%, -99%,-1%);
        color: black;
        font-weight: 300;
        text-align: right;
    }
    @media screen and (max-width: 1050px) {
        .nilai {
            font-size: 75%;
        }
        .child2 {
            top: 32%;
            left: 35%;
        } 
        .freeStock {
             top: 32%;
            left: 56.5%;
            font-size: 74%;
        }
        .notrts {
            font-size: 74%;
            top: 32%;
            left: 65.5%;
        }
    }
    @media screen and (max-width: 800px) {
      
        .child2 {
            top: 32%;
            left: 35%;
        }
        .freeStock {
             top: 32%;
            left: 56.5%;
        }
        .notrts {
            top: 32%;
            left: 65.5%;
        }
    }
    @media screen and (max-width: 768px) {
        .nilai {
            font-size: 40%;
        }
        .child2 {
            top: 32%;
            left: 35%;
        }
        .freeStock {
            top: 32%;
            left: 56.5%;
            font-size: 39%;
        }
        .notrts {
            font-size: 55%;
            top: 32%;
            left: 65.5%;
        }
    }
    @media screen and (max-width: 600px) {
      
        .child2 {
            top: 32%;
            left: 35%;
        }
        .freeStock {
            top: 32%;
            left: 56.5%;
            font-size: 29%;
        }
        .notrts {
            font-size: 45%;
            top: 32%;
            left: 65.5%;
        }
    }
    @media screen and (max-width: 400px) {
      
        .child2 {
            top: 32%;
            left: 35%;
        }
        .freeStock {
            top: 32%;
            left: 56.5%;
            font-size: 20%;
        }
        .notrts {
            font-size: 30%;
            top: 32%;
            left: 65.5%;
        }
    }
    .gambar{
        position: relative;
        text-align: center;
        color: white;
    }
    .gambar2{
        position: relative;
        text-align: center;
        color: white;
    }

</style>
@endsection

@section('script')

<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/fusioncharts.charts.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/fusioncharts/js/themes/fusioncharts.theme.carbon.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/number_js/numeral.js') }}"></script>
<script type="text/javascript" src="{{ url('js/html2canvas.js') }}"></script>
<script src="{{ url('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">


    $(document).ready(function(){
        $('#ks_produk option[value=HR]').attr('selected','selected');
        $('[data-toggle="tooltip"]').tooltip();
        $('#date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate :"{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y')}}",
        });

        var ks_produk = $('#ks_produk').val();
        var date = $('#date').val();
        // console.log(date);
        getData(ks_produk,date);

    });

    // $('#date').change(function () {
    //     var ks_produk = $('#ks_produk').val();
    //     var date    = $(this).val();
    //     // getData(ks_produk,date);
    // });
   

    function getChart(group) {
        var x = '';
        if(group == '1'){
            x = 'Bahan Baku';
        }
        if(group == '2'){
            x = 'Open Rolling';
        }
        if(group == '3'){
            x = 'Produksi';
        }
        if(group == '6'){
            x = 'WIP';
        }
        if(group == '5'){
            x = 'Stock FG';
        }
        $.get('{{ url('chart') }}', {produk: $('#ks_produk').val(),group: group}, function(data, textStatus, xhr) {
            // console.log(data);
            FusionCharts.ready(function() {
              var oilResChart = new FusionCharts({
                type: 'column2d',
                renderAt: 'chart-container',
                width: '100%',
                height: '400',
                dataFormat: 'json',
                dataSource: {
                  "chart": {
                    "caption": x,
                    "subcaption": "",
                    "yaxisname": "",
                    "yaxismaxvalue": "10",
                    "rotatevalues": "1",
                    "placevaluesinside": "0",
                    "valuefontcolor": "074868",
                    "plotgradientcolor": "",
                    "showcanvasborder": "1",
                    "numdivlines": "5",
                    // "showyaxisvalues": "0",
                    "palettecolors": "#1790E1",
                    "canvasborderthickness": "1",
                    "canvasbordercolor": "#074868",
                    "canvasborderalpha": "30",
                    "basefontcolor": "#074868",
                    "divlinecolor": "#074868",
                    "divlinealpha": "10",
                    "divlinedashed": "0",
                    "theme": "zune"
                  },
                  "data": data.chart,
                  "trendlines": [
                        {
                            "line": [
                                {
                                    "startvalue": Math.round(data.avg),
                                    "color": "#1aaf5d",
                                    "valueOnRight": "1",
                                    "tooltext": "Quarterly sales target was $startDataValue",
                                    "displayvalue": "AVG - "+Math.round(data.avg)
                                }
                            ]
                        }
                    ]
                }
              }).render();
            });
        });
    }
    function getData(ks_produk,date) {
        $('.img').find('img').remove();
        $('.gambar div').html("");
        $.get('{{ url('data_produk') }}', {produk: ks_produk, tanggal:date}, function(data, textStatus, xhr) {
            $('.img').append('<img src="{{ asset('img/data_.png') }}" class="gambar2 img img-responsive">');

            var last_update     = data.last_update
            var data_produk     = data.produk;
            var data_child1     = data.child1;
            var data_child2     = data.child2;

            
            var data_total      = data.data_total;
            var im              = data.im;
            var ip              = data.ip;
            var is              = data.is;
            var cir             = data.cir;
            var data_stock_fg   = data.stockFG_val;
            var data_cargo      = data.cargo_val;
            var fd_memo_dinas   = data.fd_memo;
            var full_pay        = data.full_pay;
            var lcso            = data.lcso;
            var hold            = data.hold;
            var data_rts        = data.rts;
            var not_rts_sum     = 0;

            // var kontribusi_margin  = data.kontribusi_margin;
            var revenue  = data.revenue;

            $('#ttl_shipment').html(numeral(data.ttl_shipment).format('0,0'));
            $('#ttl_revenue').html('$'+numeral(data.ttl_revenue).format('$0,0.00'));

            $('#last_update').html(last_update);
            // $('.margin').html(kontribusi_margin);
            $('.gap-harga').html(revenue);
            
            // console.log(data_produk);
            $('.bahan-baku').html('0');
            $('.open-rolling').html('0');
            $('.wip').html('0');
            $('.produksi-today').html('0');
            $('.stock-fg').html('0');
            $('.shipmen-today').html('0');
            $('.child1').html('');
            $('.child2').html('');
            $('.freeStock').html('');
            $('.cargo').html('0');
            $('.cir').html('');
            $('.rts').html('0');
            $('.notrts').html('');
            $('.produksi').html('0');
            $('.shipmen').html('0');

            //data total
            for (i = 0; i < data_total.length; i++) {
                if(data_total[i].group == '3'){
                    // console.log(data_total[i].current_value);
                    $('.produksi').html(numeral(data_total[i].current_value).format('0,0'));
                }
                if(data_total[i].group == '4'){
                    $('.shipmen').html(numeral(data_total[i].current_value).format('0,0'));
                }
            }
            
            //detaile WIP
            for (i = 0; i < data_child2.length; i++) {
                var xx = data_child2[i].child2+' : '+numeral(data_child2[i].sum).format('0,0')+' <br>';
                $('.child2').append(xx);
            }
            for (i = 0; i < data_child1.length; i++) {
                $('.child2').append(data_child1[i].child1+' : '+numeral(data_child1[i].sum).format('0,0')+' <br>');
            }

            //flow data
            for (i = 0; i < data_produk.length; i++) { 
                if(data_produk[i].group == '1'){
                    $('.bahan-baku').html( numeral(data_produk[i].sum).format('0,0') );
                }
                if(data_produk[i].group == '2'){
                    $('.open-rolling').html( numeral(data_produk[i].sum).format('0,0') );
                }
                if(data_produk[i].group == '3'){
                    $('.produksi-today').html( numeral(data_produk[i].sum).format('0,0') );
                }
                if(data_produk[i].group == '4'){
                    $('.shipmen-today').html( numeral(data_produk[i].sum).format('0,0') );
                }
                if(data_produk[i].group == '6'){
                    $('.wip').html( numeral(data_produk[i].sum).format('0,0') );
                }

            }

            $('.freeStock').append('Free Stock : <br>'+numeral((im+ip+is)/1000).format('0,0')+' <br>');
            $('.freeStock').append('IM : '+numeral(im/1000).format('0,0')+' <br>');
            $('.freeStock').append('IP : '+numeral(ip/1000).format('0,0')+' <br>');
            $('.freeStock').append('IS : '+numeral(is/1000).format('0,0')+' <br>');

            $('.cir').html('CIR : '+numeral(cir/1000).format('0,0'));
            $('.stock-fg').html( numeral(data_stock_fg/1000).format('0,0') );
            $('.cargo').html(numeral(data_cargo/1000).format('0,0'));
            $('.rts').html(numeral(data_rts/1000).format('0,0'));

            $('.notrts').append('FD Memo Dinas'+' : '+numeral(fd_memo_dinas/1000).format('0,0')+"<br>");
            $('.notrts').append('Waiting For Full Pay'+' : '+numeral(full_pay/1000).format('0,0')+"<br>");
            $('.notrts').append('LC/SO Expired'+' : '+numeral(lcso/1000).format('0,0')+"<br>");
            $('.notrts').append('Hold'+' : '+numeral(hold/1000).format('0,0')+"<br>");

            var notrts = Number(fd_memo_dinas)+Number(full_pay)+Number(lcso)+Number(hold);
            var other = Number(data_cargo)-Number(notrts);
            $('.notrts').append('Other'+' : '+numeral(other/1000).format('0,0')+"<br>");

        });
    }
    function help(img,key) {
        $("#help").fadeOut(function(){
            $('#help').attr('src',img);
            $("#help").fadeIn("slow");
        });
        
        $('.btn_help').removeClass('btn-primary');
        $('.btn_help').removeClass('btn-warning');
        
        $('.btn_help').addClass('btn-primary');
        $('#btn_help'+key).addClass('btn-warning');
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

        <h4 class="panel-title"><span class="fa fa-dashboard"></span> FLOW</h4>
    </div>
    <div class="panel-body">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>NOTE : </strong><br>
            <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-4">
                    LAST UPDATE : <span id="last_update">{{ $kemarin }}</span> 22:00 WIB
                </div>
                <div class="col-sm-4">
                    <strong>Total All Product Shipment : </strong> 
                    <strong id="ttl_shipment"></strong>
                </div>
                <div class="col-sm-4">
                    <strong>Total All Product Revenue : </strong>
                    <strong id="ttl_revenue"></strong>
                </div>
            </div>
            </div>
        </div>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-md-1 control-label">Date : </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" name="tanggal" class="form-control" id="date" 
                                autocomplete="off" value="{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" onclick="getData( $('#ks_produk').val(),$('#date').val() )">Select</button>
                        </span>
                    </div>
                </div>

                <label class="col-md-2 control-label">Product Type : </label>
                <div class="col-md-4">
                    <select name="ks_produk" id="ks_produk" class="form-control" onchange="getData($(this).val(),$('#date').val())">
                        <option value="" selected>Pilih Produk</option>
                        @foreach($produk as $value)
                            <option value="{{ $value->produk }}">{{ $value->produk }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="col-md-1 control-label">Help : </label>
                <div class="col-md-1">
                    <a class="btn btn-sm btn-primary" data-toggle="modal" href='#modal-help'>
                        <span class="fa fa-question-circle fa-1x"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="gambar">
            <span class="img"></span>
            <a data-toggle="modal" href='#modal-id' onclick="getChart('1');">
                <div class="bahan-baku nilai"></div>
            </a>
            {{-- <div class="platon nilai">xx$</div> --}}
            <a data-toggle="modal" href='#modal-id' onclick="getChart('2');">
                <div class="open-rolling nilai"></div>
            </a>
            <a data-toggle="modal" href='#modal-id' onclick="getChart('6');">
                <div class="wip nilai"></div>
            </a>
            <a data-toggle="modal" href='#modal-id' >
                <div class="produksi nilai" data-toggle="tooltip" data-placement="top" title="Accumulation"></div>
            </a>
            <!-- <a data-toggle="modal" href='#modal-id' onclick="getChart('3');">
                <div class="produksi-today nilai"></div>
            </a> -->

            <a href="{{ url('/produksi') }}">
                <div class="produksi-today nilai" data-toggle="tooltip" data-placement="bottom" title="Today"></div>
            </a>

            {{-- <div class="pa nilai">x%</div> --}}

            <a data-toggle="modal" href='#modal-id' onclick="getChart('5');">
                <div class="stock-fg nilai"></div>
            </a>

            <div class="cargo nilai"></div>
            {{-- <div class="penjualan nilai"></div> --}}
            <div class="rts nilai"></div>
            <div class="shipmen nilai" class="shipmen-today nilai" data-toggle="tooltip" data-placement="top" title="Accumulation"></div>

            <a href="{{ url('/shipment') }}">
                <div class="shipmen-today nilai" data-toggle="tooltip" data-placement="bottom" title="Today"></div>
            </a>
            
            {{-- <div class="margin nilai"></div> --}}
            <div class="gap-harga nilai"></div>
            <div class="child2 nilai"></div>
            <div class="freeStock nilai"></div>
            <div class="cir nilai"></div>
            <div class="notrts nilai"></div>
            {{-- <div class="child1 nilai"></div> --}}
            
        </div>
    </div>
</div>

<div class="modal fade" id="modal-id">
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
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-help">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body">
                <div class="text-center" style="margin-bottom: 10px">                   
                    @foreach($help as $key => $value )
                        <a id="btn_help{{$key+1}}" class="btn_help btn btn-primary btn-icon btn-circle" onclick="help('{{url('/img/help/dashboard') }}/{{$value}}','{{$key+1}}')" >
                            <strong>{{$key+1}}</strong>
                        </a>
                    @endforeach
                </div>
                <img id="help" src="{{url('/img/help/dashboard/help1.png') }}" class="img img-responsive">
            </div>
            <div class="modal-footer">
               {{--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection