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
    $(document).ready(function() {
       $('#child').hide(); 
    });
    function project(projectType) {
        $.get('{{ url('project') }}/'+projectType, function(data, textStatus, xhr) {
            $('#project').find('option').remove();
            $('#project').append('<option value="" selected>Pilih Project</option>');
            for (var i = 0; i < data.length; i++) {
                $('#project').append('<option value="'+data[i].project_id+'">'+data[i].project_name+'</option>')
            }
        });
    }
    function projectChild(project_id) {
        var text = $('#project option:selected').text();
        $.get('{{ url('projectChild') }}/'+project_id, function(data, textStatus, xhr) {
            if(data.length == 0){
                $('#child').hide();
                chart(project_id,text);
                $('#linkTOeis').val('https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&pmoid=19&projectid=0&projectidx='+project_id+'&statusc=1&subsid=0');
            }else{
                $('#child').show();
            }
            $('#projectchild').find('option').remove();
            $('#projectchild').append('<option value="" selected>Pilih Project</option>');
            for (var i = 0; i < data.length; i++) {
                $('#projectchild').append('<option value="'+data[i].project_id+'">'+data[i].project_name+'</option>')
            }
        });
    }
    function chart(project_id,text) {
        $.get('{{ url('project_chart') }}/'+project_id, function(data, textStatus, xhr) {
            $('#linkTOeis').val('https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&pmoid=19&projectid=0&projectidx='+project_id+'&statusc=1&subsid=0');
            FusionCharts.ready(function() {
              var compChart = new FusionCharts({
                type: 'msspline',
                renderAt: 'chart-container',
                width: '100%',
                height: '400',
                dataFormat: 'json',
                dataSource: {
                  "chart": {
                    "caption": text+'<br>'+data[3].title,
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
                    "yAxisMaxValue": "100",
                    "labelDisplay": "rotate"
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
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>

            <h4 class="panel-title"><span class="fa fa-dashboard"></span> FLOW</h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" target="_blank" action="https://sso.krakatausteel.com/scm/dboard/from_dashboard.php" method="POST">
                <div class="form-group">
                    <label class="col-md-2 control-label">Project Type : </label>
                    <div class="col-md-3">
                        <select class="form-control" onchange="project($(this).val())">
                            <option value="" selected>Pilih Type</option>
                            @foreach($project_type as $key => $value)
                                <option value="{{$value->projecttype_id}}" >
                                    {{$value->projecttype_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                            <input type="hidden" name="link" id="linkTOeis" value="https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&statusc=1">
                            <input type="hidden" name="username" value="{{ session()->get('username') }}">
                            <input type="submit" value="Link To EIS" class="btn btn-sm btn-primary">
                        {{-- <a id="linkTOeis" target="_blank" href="https://sso.krakatausteel.com/scm/dboard/content.php?page=pmo&statusc=1" class="btn btn-sm btn-primary"> Link To EIS</a> --}}
                    </div>
                </div>
            </form>
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-2 control-label">Project : </label>
                    <div class="col-md-3" style="margin-bottom: 10px">
                        <select id="project" class="form-control" onchange="projectChild($(this).val())">
                        </select>
                    </div>
                    <div class="col-md-5" id="child">
                        <select id="projectchild" class="form-control" onchange="chart($(this).val(),$('#projectchild option:selected').text());">
                        </select>
                    </div>
                </div>
            </form>

            <div id="chart-container"></div>
        </div>
    </div>
@endsection