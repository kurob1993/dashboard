@extends('layout.app')

@section('menu_active')
    @php($active = 'Data Master')
@endsection

@section('style')
<link href="{{ url('plugins/DataTables/css/data-table.css') }}" rel="stylesheet" />
<style type="text/css">

</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('plugins/DataTables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('plugins/DataTables/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
    $('.alert').hide();$('#alert-update').hide(); 
    $('#example').DataTable( {
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "sDom": 'tipr', 
        "ajax": {
            "url" : "{{ url('user/show') }}",
            "type" : "POST",
            "beforeSend": function (request) {
                request.setRequestHeader("X-CSRF-Token", "{{csrf_token()}}");
            }
        },
        "columns": [
            { "data": "nik" },
            { "data": "name"},
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "pk" },
            { "data": "nik" , 
               render: function ( data, type, row ) {
                var del = '<button title="Delete" class="btn btn-sm btn-danger" style="margin:0px 2px 2px 0px" onclick="del(`'+data+'`)"> <i class="fa fa-trash"></i></button>';
                var edit = '<button title="Edit" class="btn btn-sm btn-success" data-toggle="modal" href="#modal-edit" style="margin:0px 2px 2px 0px" onclick="edit(`'+data+'`)"> <i class="fa fa-pencil"></i></button>';
                var user_access = '<button title="User Access" class="btn btn-sm btn-warning" data-toggle="modal" href="#modal-user_accecc" style="margin:0px 2px 2px 0px" onclick="access(`'+row.nik+'`,`'+row.name+'`)"> <i class="fa fa-wrench"></i></button>';
                return del+edit+user_access;
              }
            }
        ]
    });

    var oTable = $('#example').DataTable();    
    $('#cari').keypress(function(e) {
        if(e.which == 13) {
            oTable.search( $(this).val() ).draw();
        }
    });
    function del(nik) {
        var r = confirm("are you sure to delete ? ");
        if (r == true) {
            $.ajax({
                url: '{{ url('user/delete') }}',
                type: 'delete',
                data: {"nik" : nik},
                headers: {
                    "X-CSRF-Token" : "{{csrf_token()}}"
                },
                dataType: 'json',
                success: function (data) {
                    if(data.msg){
                        oTable.ajax.reload();
                    }
                }
            });
        }
    }
    function edit(nik) {
        $.ajax({
            url: '{{ url('user/get/') }}/'+nik,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('#nik').val(data[0].nik);
                $('#nik_hide').val(data[0].nik);
                $('#name').val(data[0].name);
                $('#jabatan').val(data[0].jabatan);
                $('#email').val(data[0].email);
                $('#pk').val(data[0].pk);
            }
        });
    }
    function save() {
        var form = $('#form').serializeArray();
        $.ajax({
            url: '{{ url('user/save') }}',
            type: 'post',
            data: form,
            headers: {
                "X-CSRF-Token" : "{{csrf_token()}}"
            },
            dataType: 'json',
            success: function (data) {
                console.info(data);
                $('.alert').show();
                if(data.msg == "success"){
                    $('.alert').hide();
                    $('#form')[0].reset();
                    $('.modal').modal('hide');
                    oTable.ajax.reload();
                    
                }else{
                    $('#alert-content').html(data.msg);
                }
                
            }
        });
    }
    function update() {
        var form = $('#form-update').serializeArray();
        $.ajax({
            url: '{{ url('user/update') }}',
            type: 'post',
            data: form,
            headers: {
                "X-CSRF-Token" : "{{csrf_token()}}"
            },
            dataType: 'json',
            success: function (data) {
                console.info(data);
                $('#alert-update').show();
                if(data.msg == "success"){
                    $('#alert-update').hide();
                    $('#form')[0].reset();
                    $('.modal').modal('hide');
                    oTable.ajax.reload();
                    
                }else{
                    $('#alert-update #alert-content').html(data.msg);
                }
                
            }
        });
    }
    function update_access() {
        var form = $('#form_user_access').serializeArray();
        $.ajax({
            url: '{{ url('user/update_useraccess') }}',
            type: 'post',
            data: form,
            headers: {
                "X-CSRF-Token" : "{{csrf_token()}}"
            },
            dataType: 'json',
            success: function (data) {
                if(data[0]){
                    alert(data[0]);
                    $('#modal-user_accecc').modal('hide');
                }
            }
        });
    }
    function access(nik,name) {
        $('#access-name').html(name);
        $.get('{{url('user/menu')}}/'+nik,function(data) {
            $('#form_user_access').html(data);
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

                <h4 class="panel-title"><span class="fa fa-dashboard"></span> User List</h4>
            </div>

            <div style="margin: 10px 10px 0px 10px">
                <div class="col-md-1" style="margin-bottom: 10px" >
                    <a class="btn btn-md btn-primary" data-toggle="modal" href='#modal-id'>
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
                <div class="col-md-4" style="margin-bottom: 10px">
                    <input type="text" name="cari" class="form-control col-md-4" id="cari" placeholder="Search Data">
                </div>
                <div class="col-md-7">
                    
                </div>
            </div>
            
            <div class="panel-body">
                <table id="example" class="table table-responsive table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th width="20%">NAME</th>
                            <th width="20%">POSITION</th>
                            <th width="20%">E-MAIL</th>
                            <th>PK</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add User</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">NIK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nik">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">NAME</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">POSITION</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="jabatan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">E-MAIL</label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email">
                                </div>
                            </div><div class="form-group">
                                <label class="col-md-3 control-label">PK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="pk">
                                </div>
                            </div>
                        </form>

                        <div class="alert alert-info">
                            <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                            <span id="alert-content"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="save();">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit User</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-update">
                            <div class="form-group">
                                <label class="col-md-3 control-label">NIK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nik" id="nik">
                                    <input type="hidden" class="form-control" name="nik_hide" id="nik_hide">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">NAME</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">POSITION</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="jabatan" id="jabatan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">E-MAIL</label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div><div class="form-group">
                                <label class="col-md-3 control-label">PK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="pk" id="pk">
                                </div>
                            </div>
                        </form>

                        <div class="alert alert-info" id="alert-update">
                            <button type="button" class="close" onclick="$('.alert').hide();">&times;</button>
                            <span id="alert-content"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="update();">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modal-user_accecc">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">User Access | <span id="access-name"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_user_access"></form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="update_access();">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
