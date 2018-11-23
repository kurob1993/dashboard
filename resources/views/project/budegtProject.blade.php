@extends('layout.app')

@section('menu_active')
    @php($active = 'Project')
@endsection

@section('style')
<link href="{{ url('public/plugins/DataTables/css/data-table.css') }}" rel="stylesheet" />
<style type="text/css">
    
</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('public/plugins/DataTables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/DataTables/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){ 
    $('#example').DataTable( {
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url" : "{{ url('budget_project/show') }}",
            "type" : "POST",
            "beforeSend": function (request) {
                request.setRequestHeader("X-CSRF-Token", "{{csrf_token()}}");
            }
        },
        "columnDefs": [
            {
                "targets": 4,
                "className": 'text-right'
            },
            {
                "targets": 5,
                "className": 'text-right'
            },
            {
                "targets": 6,
                "className": 'text-right'
            },
            // {
            //     "targets": 7,
            //     "className": 'text-right'
            // },
            // {
            //     "targets": 8,
            //     "className": 'text-right'
            // },
            {
                "targets": 0,
                "orderable": false
            }
        ],
        "columns": [
            { "data": "level"},
            { "data": "wbs_element"},
            // { "data": "im_position" },
            { "data": "description"},
            { "data": "progress_overall" },
            { "data": "im_budget_overall",
                render: function ( data, type, row ) {
                    return data.toString().replace(
                        /\B(?=(\d{3})+(?!\d))/g, "."
                    );
                }
            },
            { "data": "act_payment_total" ,
                render: function ( data, type, row ) {
                    return data.toString().replace(
                        /\B(?=(\d{3})+(?!\d))/g, "."
                    );
                }
            },
            // { "data": "wbs_budget_overall",
            //     render: function ( data, type, row ) {
            //         return data.toString().replace(
            //             /\B(?=(\d{3})+(?!\d))/g, "."
            //         );
            //     }
            // },
            { "data": "available_overall" ,
                render: function ( data, type, row ) {
                    return data.toString().replace(
                        /\B(?=(\d{3})+(?!\d))/g, "."
                    );
                }
            }
        ]
    });
});
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
            <h4 class="panel-title">
                <span class="fa fa-area-chart"></span> 
                Budget Project
            </h4>
        </div>
        <div class="panel-body">
            <table id="example" class="table table-responsive table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>WBS_Element</th>
                        {{-- <th>im_position</th> --}}
                        <th>Description</th>
                        <th>(%)</th>
                        <th>Budget Project</th>
                        <th>Cost Sudah Dibayar</th>
                        {{-- <th>wbs budget overall</th> --}}
                        
                        <th>Cost Committed to Completion</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection