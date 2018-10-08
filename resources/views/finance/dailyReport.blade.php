@extends('layout.app')

@section('menu_active')
    @php($active = 'Finance')
@endsection

@section('style')
<link href="{{ url('public/plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
<style type="text/css">

</style>
@endsection

@section('script')

<script type="text/javascript" src="{{ url('public/plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/number_js/numeral.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/fusioncharts/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/fusioncharts/js/fusioncharts.powercharts.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/fusioncharts/js/themes/fusioncharts.theme.fint.js?cacheBust=56') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate :"{{ date('d/m/Y') }}",
        }).datepicker("update", "{{ date('d/m/Y') }}");
        var kemarin = moment("{{ date('Y-m-d') }}").subtract(1, 'days').format("DD-MM-YYYY");
        $('#last_update').html( kemarin );
    });

    function dailyReport(tgl = '') {
        if(tgl !== '' ){
            var tgl = moment(tgl, "DD-MM-YYYY").format("YYYY-MM-DD");
        }
        $.get("{{ url('/daily_report/show') }}/"+tgl,function(data) {
            for (var i = 0; i < data.length; i++) {
                var tag_name = data[i].TAG_NAME;
                switch ( tag_name ) {
                    case 'HUTANG_LC_IDR':
                        var hutnagLC_idr  = data[i].VALUE;
                        var kurs_lc_usd   = data[i].KURS_USD;
                        var tglLC = moment(data[i].TANGGAL).format("DD-MM-YYYY");
                        $('#tglLC').html(tglLC);
                        break;

                    case 'HUTANG_LC_USD':
                        var hutnagLC_usd = data[i].VALUE;
                        break;

                    case 'HUTANG_KMK_IDR':
                        var hutnagKMK_idr =data[i].VALUE;
                        var kurs_kmk_usd   = data[i].KURS_USD;

                        var tglKMK = moment(data[i].TANGGAL).format("DD-MM-YYYY");
                        $('#tglKMK').html(tglKMK);
                        break;
                        
                    case 'HUTANG_KMK_USD':
                        var hutnagKMK_usd = data[i].VALUE;
                        break;

                    case 'SALDO_BANK_IDR':
                        var saldo_bank_idr = numeral(data[i].VALUE).format('0,0.00');

                        var tglKas = moment(data[i].TANGGAL).format("DD-MM-YYYY");
                        $('#tglkas').html(tglKas);
                        break;
                    case 'SALDO_BANK_USD':
                        var saldo_bank_usd = numeral(data[i].VALUE).format('0,0.00');
                        break;
                    case 'SALDO_BANK_EUR':
                        var saldo_bank_eur = numeral(data[i].VALUE).format('0,0.00');
                        break;
                }
            }
            var LC_EQ_IDR = numeral( hutnagLC_idr+(kurs_lc_usd*hutnagLC_usd) ).format('0,0');
            var LC_EQ_USD = numeral( hutnagLC_usd+(hutnagLC_idr/kurs_lc_usd) ).format('0,0');

            var KMK_EQ_IDR = numeral( hutnagKMK_idr+(kurs_kmk_usd*hutnagKMK_usd) ).format('0,0.00');
            var KMK_EQ_USD = numeral( hutnagKMK_usd+(hutnagKMK_idr/kurs_kmk_usd) ).format('0,0.00');

            $('#hutang_lc').find('tr').remove();
            $('#saldo_bank').find('tr').remove();

            $('#hutang_lc').append(
              '<tr>'+
                '<td>'+
                  '<button class="btn btn-xs btn-warning" data-toggle="modal" href="#modal-id" onclick="hutang_lc();">'+
                    '<i class="fa fa-bar-chart"></i>'+
                  '</button> '+
                  'Hutang LC'+
                '</td>'+
                '<td class="text-right">'+ LC_EQ_IDR +'</td>'+
                '<td class="text-right">'+ LC_EQ_USD +'</td>'+
              '</tr>'+
              '<tr>'+
                '<td>'+
                  '<button class="btn btn-xs btn-warning" data-toggle="modal" href="#modal-id" onclick="hutang_kmk();">'+
                    '<i class="fa fa-bar-chart"></i>'+
                  '</button> '+
                  'Hutang Non LC (KMK)</td>'+
                '<td class="text-right">'+KMK_EQ_IDR+'</td>'+
                '<td class="text-right">'+KMK_EQ_USD+'</td>'+
              '</tr>'
            );
            $('#saldo_bank').append(
              '<tr>'+
                '<td>SO Kas/Bank</td>'+
                '<td class="text-right">'+saldo_bank_idr+'</td>'+
                '<td class="text-right">'+saldo_bank_usd+'</td>'+
                '<td class="text-right">'+saldo_bank_eur+'</td>'+
              '</tr>'
            );

        });
        $.get("{{ url('/daily_report/show/cash') }}/"+tgl,function(data) {
            for (var i = 0; i < data.length; i++) {
                var tag_name = data[i].TAG_NAME;
                switch ( tag_name ) {
                    case 'CASH_IDR':
                        var cashReceipt_idr = numeral(data[i].VALUE).format('0,0.00');
                        var awalBulan       = moment(data[i].TANGGAL).format("MM-YYYY");
                        var tglCASH         = moment(data[i].TANGGAL).format("DD-MM-YYYY");
                        
                        $('#tglCASH').html('01-'+awalBulan+' s.d '+tglCASH);
                        break;
                    case 'CASH_USD':
                        var cashReceipt_usd = numeral(data[i].VALUE).format('0,0.00');
                        break;
                    // case 'CASH_EUR':
                    //     var cashReceipt_eur = numeral(data[i].VALUE).format('0,0.00');
                    //     break;
                }
            }
            $('#cash').find('tr').remove();
            $('#cash').append(
              '<tr>'+
                '<td>Cash Receipt</td>'+
                '<td class="text-right">'+cashReceipt_idr+'</td>'+
                '<td class="text-right">'+cashReceipt_usd+'</td>'+
                //'<td class="text-right">'+cashReceipt_eur+'</td>'+
              '</tr>'
            );
        });
    }

    function kurs() {
      $('#title-chart').html('POSISI KURS');
        $.ajax({
            type    :"GET",
            url     :"{{ url('daily_report/chart/kurs') }}",
            dataType:"json",
            success :function(data){
              var category =  data.category;
              var dataset =  data.dataset;
              var caption =  data.caption;
              chart(category,dataset,caption,0);
            }
        });
    }
    function saldobank() {
      var date = $('#date').val();
      $('#title-chart').html('SALDO BANK');
        $.ajax({
            type    :"GET",
            url     :"{{ url('daily_report/chart/saldobank') }}/"+date,
            dataType:"json",
            success :function(data){
              var category =  data.category;
              var dataset =  data.dataset;
              var caption =  data.caption;
              chart(category,dataset,caption,0);
            }
        });
    }
    function cash() {
      var date = $('#date').val();
      $('#title-chart').html('CASH RECEIPT');
        $.ajax({
            type    :"GET",
            url     :"{{ url('daily_report/chart/cash') }}/"+date,
            dataType:"json",
            success :function(data){
              var category =  data.category;
              var dataset =  data.dataset;
              var caption =  data.caption;
              chart(category,dataset,caption,0);
            }
        });
    }
    function hutang_lc() {
      var date = $('#date').val();
      $('#title-chart').html('HUTANG LC');
        $.ajax({
            type    :"GET",
            url     :"{{ url('daily_report/chart/hutang_lc') }}/"+date,
            dataType:"json",
            success :function(data){
              var category =  data.category;
              var dataset =  data.dataset;
              var caption =  data.caption;
              chart(category,dataset,caption,0);
            }
        });
    }
    function chart(category,dataset,caption,showValues=1) {
      FusionCharts.ready(function(){
            var fusioncharts = new FusionCharts({
                type: 'multiaxisline',
                renderAt: 'chart-container',
                width: '100%',
                height: '350',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption":caption,
                        "subcaption": "",
                        "xAxisName": "",
                        "showValues": showValues,
                        "theme": "fint"
                    },
                    "categories": [{
                        "category": category
                    }],
                    "axis": dataset
                }
            }
        );fusioncharts.render();
      });
    }
</script>
@endsection

@section('content')
<!-- begin page-header -->
<h1 class="page-header">Dashboard Operation Excellence </h1>
<!-- end page-header -->
    <section>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>

                <h4 class="panel-title"><span class="fa fa-money"></span> Daily Liquidity</h4>
            </div>
            <div class="panel-body">
              <div class="alert alert-info">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong>NOTE : </strong> LAST UPDATE : <span id="last_update"></span> 22:00 WIB <br>
              </div>
                <table>
                    <tr>
                        <td><label style="margin-right: 20px"> Date : </label></td>
                        <td><input type="text" name="tanggal" class="form-control" id="date" onchange="dailyReport( $(this).val() )"></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    @component('component.panel')
      @slot('title')
        <span class="fa fa-money"></span>
        FASILITAS CASH & NON CASH LOAN
      @endslot
      <div class="table-responsive">
        <table class="table table-responsive table-bordered table-hover" style="width: 100%;">
            <thead>
                <tr class="bg-primary">
                    <th class="text-white">Posisi Hutang per <span id="tglLC"></span></th>
                    <th class="text-white text-right">Total Eq. IDR</th>
                    <th class="text-white text-right">Total Eq. USD</th>
                </tr>
            </thead>
            <tbody id="hutang_lc">
            </tbody>
        </table>
      </div>
    @endcomponent

    @component('component.panel')
      @slot('title')
        <span class="fa fa-money"></span>
        POSISI CASH & COLLECTION
      @endslot
      <div class="table-responsive">

        <table class="table table-bordered table-hover" style="width: 100%">
            <thead>
                <tr class="bg-primary">
                    <th class="text-white">
                      <button class="btn btn-xs btn-warning" data-toggle="modal" href='#modal-id' 
                      onclick="cash();">
                        <i class="fa fa-bar-chart"></i>
                      </button>
                      Cash Receipt <span id="tglCASH"></span>
                    </th>
                    <th class="text-white text-right">Total Eq. IDR</th>
                    <th class="text-white text-right">Total Eq. USD</th>
                    {{-- <th class="text-right">EUR</th> --}}
                </tr>
            </thead>
            <tbody id="cash">
            </tbody>
        </table>
        <table class="table table-bordered table-hover" style="width: 100%">
            <thead>
                <tr class="bg-primary">
                    <th class="text-white">
                      <button class="btn btn-xs btn-warning" data-toggle="modal" href='#modal-id' 
                      onclick="saldobank();">
                        <i class="fa fa-bar-chart"></i>
                      </button>
                      Saldo Bank <span id="tglkas"></span>
                    </th>
                    <th class="text-white text-right">IDR</th>
                    <th class="text-white text-right">USD</th>
                    <th class="text-white text-right">EUR</th>
                </tr>
            </thead>
            <tbody id="saldo_bank">
            </tbody>
        </table>

      </div>
    @endcomponent

    @component('component.panel')
      @slot('title')
        <button class="btn btn-xs btn-warning" data-toggle="modal" href='#modal-id' onclick="kurs();">
          <i class="fa fa-bar-chart"></i>
        </button>
        POSISI KURS
      @endslot
      <div class="table-responsive">
        <table class="table table-bordered table-hover" style="width: 100%">
            <thead>
                <tr class="bg-primary">
                    <th class="text-white">TANGGAL</th>
                    <th class="text-white">MATA UANG</th>
                    <th class="text-white text-right">NILAI</th>
                </tr>
            </thead>
            <tbody id="body_posisi_kurs">
              @foreach($kurs as $key => $value)
                <tr>
                  <td>{{ $value->TANGGAL }}</td>
                  <td>{{ $value->MATA_UANG }}</td>
                  <td class="text-right">{{ number_format($value->KURS_TENGAH,2) }}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    @endcomponent
    
    <section>
      <div class="modal fade" id="modal-id">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="title-chart"></h4>
            </div>
            <div class="modal-body">
                <div id="chart-container">FusionCharts will render here</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
