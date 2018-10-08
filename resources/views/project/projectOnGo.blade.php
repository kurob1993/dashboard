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
    function chart(project_id,project_name) {
        $('#modal_title').html(project_name);
        $.get('{{ url('project_chart') }}/'+project_id, function(data, textStatus, xhr) {
            FusionCharts.ready(function() {
              var compChart = new FusionCharts({
                id: "mychart",
                type: 'msspline',
                renderAt: 'chart-container',
                width: '100%',
                height: '400',
                dataFormat: 'json',
                dataSource: {
                  "chart": {
                    "caption": data[3].title,
                    // "numberprefix": "$",
                    "plotgradientcolor": "",
                    "bgcolor": "FFFFFF",
                    "showalternatehgridcolor": "0",
                    "divlinecolor": "CCCCCC",
                    "showvalues": "0",
                    "showcanvasborder": "0",
                    "canvasborderalpha": "0",
                    "canvasbordercolor": "CCCCCC",
                    "canvasborderthickness": "1",
                    "captionpadding": "30",
                    "linethickness": "3",
                    "yaxisvaluespadding": "15",
                    "legendshadow": "0",
                    "legendborderalpha": "0",
                    "palettecolors": "#008ee4,#f8bd19,#33bdda,#e44a00,#6baa01,#583e78",
                    "showborder": "0",
                    "yAxisMaxValue": "100"
                  },

                  "categories": [{
                    "category": data[0].category
                  }],
                  "dataset": [{
                    "seriesname": "Plan Data",
                    "data": data[1].plan_data
                  },{
                    "seriesname": "Plan Actual",
                    "data": data[2].plan_actual
                  }]
                }

              }).render();
            });
        }
    )}
</script>
@endsection

@section('content')
<!-- begin page-header -->
<h1 class="page-header">Dashboard Operation Excellence </h1>
<!-- end page-header -->
    @foreach($project_type as $key => $value)

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
                <h4 class="panel-title"><span class="fa fa-dashboard"></span> {{$value->projecttype_name}}</h4>
            </div>
            <div class="panel-body">
             {{--    <img src="https://sso.krakatausteel.com/scm/dboard/pmo/pmo_indexgraphfull.php?var1=4&var2=2018-01-29&var3=1&light=3" class="img-responsive"> --}}
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Chart</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($project as $key => $valuea)

                        @if($valuea->projecttype_id == $value->projecttype_id)
                            <tr>
                                <td>
                                    <b>{{$valuea->project_name}} </b>
                                    @foreach($project_plan as $key => $valueb)
                                        @foreach($valueb as $key => $data)
                                            @if($data->project_id == $valuea->project_id)
                                                 - {{$data->plan_actual}} %
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($project_plan as $key => $valueb)
                                        @foreach($valueb as $key => $data)
                                            @if($data->project_id == $valuea->project_id)
                                                <button class="btn btn-sm btn-primary" onclick="chart({{$valuea->project_id}},'{{$valuea->project_name}}')" data-toggle="modal" href='#modal-id'>
                                                    <i class="fa fa-area-chart"></i> Lihat
                                                </button>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>

                            @foreach($pmo_projectChild as $key => $child)
                                @foreach($child as $key => $valChild)
                                    @if($valuea->project_id == $valChild->project_pid)
                                        <tr>
                                            <td> 
                                                <li class="text-primary fa fa-arrow-right"></li>
                                                <span class="text-primary">
                                                {{$valChild->project_name}}
                                                @foreach($pmo_projectPlanChild as $key => $valueb)
                                                    @foreach($valueb as $key => $data)
                                                        @if($data->project_id == $valChild->project_id)
                                                            - {{$data->plan_actual}} %
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                </span>
                                            </td>
                                            <td>
                                            @foreach($pmo_projectPlanChild as $key => $valueb)
                                                @foreach($valueb as $key => $data)
                                                    @if($data->project_id == $valChild->project_id)
                                                        <button class="btn btn-sm btn-primary" onclick="chart({{$valChild->project_id}},'{{$valuea->project_name}} | {{$valChild->project_name}}')" data-toggle="modal" href='#modal-id'>
                                                            <i class="fa fa-area-chart"></i> Lihat
                                                        </button>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="modal-id">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span id="modal_title"></span></h4>
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
@endsection