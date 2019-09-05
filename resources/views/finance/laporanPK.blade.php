@extends('layout.app')

@section('menu_active')
    @php($active = 'Finance')
@endsection

@section('style')
{{-- easyui start--}}
<link href="{{ url('plugins/jquery-easyui/themes/bootstrap/easyui.css') }}" rel="stylesheet" />
<link href="{{ url('plugins/jquery-easyui/themes/icon.css') }}" rel="stylesheet" />
{{-- easyui end--}}
<style type="text/css">
.datagrid-cell{
  font-size:11px;
}
</style>
@endsection

@section('script')
{{-- easyui start--}}
<script src="{{ url('plugins/jquery-easyui/jquery.easyui.min.js') }}"></script>
{{-- easyui end--}}

<script type="text/javascript">
$(document).ready(function() {
  PK();
});
$( window ).resize(function() {
    $('#dg').treegrid('resize');

});

function PK() {
    $('#dg').treegrid({
      url : '{{ url('/laporanpk/treegrid') }}'
    });
    $('#btnPK').prop('disabled', true);
    $('#btnCC').prop('disabled', false);
    $('#tag').html('PK');
}
function CC() {
    $('#dg').treegrid({
      url : '{{ url('/laporanpk/treegridcc') }}'
    });
    $('#btnPK').prop('disabled', false);
    $('#btnCC').prop('disabled', true);
    $('#tag').html('COST CENTER');
}
</script>
@endsection

@section('content')
<!-- begin page-header -->
<h1 class="page-header">Dashboard Operation Excellence </h1>
<!-- end page-header -->
    <section>
      <div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong>NOTE : </strong> LAST UPDATE : {{ $last_update }} <br>
      </div>
      <div class="panel panel-inverse" data-sortable-id="tree-view-1">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a> --}}
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
              </div>
              <span class="fa fa-dashboard"></span>
              <span>Report PK</span><br>
              <button id="btnPK" class="btn btn-xs btn-warning" style="margin-top: 5px" onclick="PK()">Base on PK</button>
              <button id="btnCC" class="btn btn-xs btn-danger" style="margin-top: 5px" onclick="CC()">Base on Cost Center</button>
          </div>
          <div class="panel-body p-5">
              {{-- <div id="jstree"></div> --}}
              <div id="divdg">
                <table id="dg" title="" class="easyui-treegrid table-responsive" style="height: 450px"
                        data-options="
                            {{-- url: '{{ url('/laporanpk/treegrid') }}', --}}
                            method: 'get',
                            rownumbers: false,
                            pagination: false,
                            pageSize: 2,
                            pageList: [2,10,20],
                            idField: 'id',
                            treeField: 'PK',
                            onLoadSuccess:function(data){
                              
                            } 
                        ">
                    <thead>
                        <tr>
                            <th field="PK" width="195"><span id="tag">PK</span></th>
                            <th field="DESCRIPTION" width="220">DESCRIPTION</th>
                            <th field="AR_DESCRIPTION" width="220">AR<br>DESCRIPTION</th>
                            <th field="APPROVAL_YEAR" width="50">APPR<br>YEAR</th>
                            <th field="PROGRAM_PLAN" width="120" align="right">PROGRAM<br>PLAN</th>
                            <th field="PROGRAM_BUDGET" width="110" align="right">PROGRAM<br>BUDGET</th>
                            <th field="APPR_REQ_PLAN" width="110" align="right">APPR_REQ<br>PLAN</th>
                            <th field="MRA_AVAIL_BUDGET" width="110" align="right">MRA_AVAIL<br>BUDGET</th>
                            <th field="ACTUAL" width="100" align="right">ACTUAL</th>
                            <th field="PERSEN" width="55">PERCENT</th>
                        </tr>
                    </thead>
                </table>
              </div>
          </div>
      </div>
    </section>
    <div style="margin-bottom: 25px"></div>
@endsection
