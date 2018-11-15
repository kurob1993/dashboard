@extends('layout.app')

@section('menu_active')
    @php($active = 'RAKORDIR')
@endsection

@section('style')
<link href="{{ url('public/plugins/DataTables/css/data-table.css') }}" rel="stylesheet" />
<style type="text/css">
@media (min-width: 768px) {
  .modal-xl {
    width: 90%;
   max-width:1200px;
  }
}
.fa-folder-open:hover {
    color: #428bca;
}
.pdfobject-container { height: 500px;}
.pdfobject { border: 1px solid #666; }
</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('public/plugins/DataTables/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/DataTables/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript" src="{{ url('public/plugins/pdfjs/build/pdf.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#pdf').hide();

        $('#example').DataTable( {
            "dom": 'lfr<"toolbar">tip',
               initComplete: function(){
                  $("div.toolbar").html('<button class="btn btn-primary" onclick="back()">Kembali</button>');           
               },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "columnDefs": [ {
                "targets": 0,
                "orderable": false
            } ],
            // "sDom": 'tipr', 
            "language": {
                "search": "Cari:",
                "lengthMenu": "",
                // "lengthMenu": "Buka _MENU_ ",
                "info": "",
                // "info": "Buka _START_ s.d _END_ dari _TOTAL_ data",
                "paginate": {
                    "first":      "Pertama",
                    "last":       "Terakhir",
                    "next":       "Lanjut",
                    "previous":   "Kembali"
                },
            },
            "ajax": {
                "url" : "{{ url('rakordir/show_materi/') }}/{{ $tanggal }}",
                "type" : "POST",
                "data" : { 'cari' : "{{ $cari }}" },
                "beforeSend": function (request) {
                    request.setRequestHeader("X-CSRF-Token", "{{csrf_token()}}");
                }
            },
            "columns": [
                {   "data": "agenda_no",
                    render: function ( data, type, row, index) {
                        return index.row+1;
                    }
                },
                { "data": "no_dokument"},
                { "data": "datetime"},
                { "data": "agenda_no"},
                { "data": "judul" },
                { "data": "presenter" },
                { "data": "file_path" , 
                   render: function ( data, type, row ) {
                    var del = '';
                    var ex;
                    var fa;
                    var data = row.rakordir_files;
                    for (let index = 0; index < data.length; index++) {
                        
                        if(data[index]){
                            ex = data[index].file_path.substr(-3, 3);
                            if(ex === 'pdf' || ex === 'PDF'){
                                fa = 'fa-file-pdf-o';
                                del += '<a data-toggle="modal" href="#modal-id" class="text-danger m-r-5" '+
                                        'style="margin:0px 2px 2px 0px" onclick="pdf(`'+data[index].file_path+'`)">'+
                                    '<i class="fa '+fa+' fa-2x"></i>'+
                                    '</a>';
                            }else{
                                fa = 'fa-file-text-o';
                                url = "{{ url('/public/storage/') }}/"+data[index].file_path;
                                del += '<a href="'+url+'" target="_blank" class="text-danger m-r-5" style="margin:0px 2px 2px 0px">'+
                                    '<i class="fa '+fa+' fa-2x"></i>'+
                                    '</a>';
                            }
                        }
                    }
                    return del;
                  }
                }
            ]
        });

    });
    function back() {
        var backdrop = "{{ $backdrop }}";
        if(backdrop){
            window.location.href="{{ url('rakordir/') }}";
        }else{
            window.location.href="{{ url('rakordir/file') }}";
        }
        
    }
    function pdf(file) {
        var ex = file.substr(-3, 3);
        var url;
        var html;
        if(ex === 'pdf' || ex === 'PDF'){
            url = "{{ url('public/plugins/pdfjs/web/viewer.html?file=') }}"+"{{ url('/public/storage/') }}/"+file;
            html = "<iframe src='"+url+"' style='width: 100%; height:80vh'></iframe>";
        }else{
            url = "{{ url('/public/storage/') }}/"+file;
            html = "<h5 class='text-center'><a href='"+url+"' target='_blank'>Kilik disini untuk unduh file.</a></h5>"
        }
        $('#example1').html(html);
    }
</script>
@endsection
@section('content')
    <h1 class="page-header">Dashboard Operation Excellence </h1>
    <section id="content">
        @component('component.panel')
            @slot('title')
                <span class="fa fa-file"></span>
                Materi Rakordir             
            @endslot

            @if($pertanggal || $perbulan)
            <form class="form-horizontal" action="{{ url('rakordir/file') }}" method="get">
                <div class="form-group">
                    
                    <div class="col-sm-6">
                        <label for="cari">CARI DATA : </label>
                        <div class="input-group">
                            <input type="text" name="cari" class="form-control" id="cari" autocomplete="off" value="">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </span>
                        </div>
                    </div>
                </form>
                <form>
                    <div class="col-sm-6">
                        <label for="tahun"> PILIH TAHUN :</label>
                        <div class="input-group">
                            <select name="tahun" id="tahun" class="form-control">
                                @foreach ($selecTahun as $item)
                                    @if ( \Carbon\Carbon::parse($item->date)->format('Y') == $tahun)
                                        <option selected value="{{ \Carbon\Carbon::parse($item->date)->format('Y') }}"> {{ \Carbon\Carbon::parse($item->date)->format('Y') }} </option>
                                    @else
                                        <option value="{{ \Carbon\Carbon::parse($item->date)->format('Y') }}"> {{ \Carbon\Carbon::parse($item->date)->format('Y') }} </option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Pilih</button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
            @endif

            @if($perbulan)
            <div class="panel panel-default">
                <div class="panel-body" style="border: 1px solid grey;box-shadow: 2px 2px 1px grey;border-radius: 4px;">
                    @foreach($data as $key => $value)
                        <div class="col-md-2 col-sm-3 col-xs-6 m-t-5 m-b-5"> 
                            <a href="{{ url('rakordir/file') }}/{{ \Carbon\Carbon::parse($value->date)->format('m-Y') }}" style="text-decoration:none" data-toggle="modal" 
                                href='#modal-id'>
                                <span class="text-warning">
                                    <li class="fa fa-folder-open fa-5x m-b-5"></li><br>
                                    {{ \Carbon\Carbon::parse($value->date)->format('F-Y') }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{ $data->links() }}
            </div>
            @endif

            @if($pertanggal)
            <div class="panel panel-default">
                <div class="panel-body" style="border: 1px solid grey;box-shadow: 2px 2px 1px grey;border-radius: 4px;">
                    @foreach($data as $key => $value)
                        <div class="col-md-2 col-sm-3 col-xs-6 m-t-5 m-b-5"> 
                            <a href="{{ url('rakordir/file') }}/{{ \Carbon\Carbon::parse($value->date)->format('Y-m-d') }}" style="text-decoration:none" data-toggle="modal" 
                                href='#modal-id'>
                                <span class="text-warning">
                                    <li class="fa fa-folder-open fa-5x m-b-5"></li><br>
                                    {{ \Carbon\Carbon::parse($value->date)->format('d-M-Y') }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{ $data->links() }}
            </div>
            @endif

            @if($tanggal)
            <table id="example" class="table table-responsive table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width=" 20%">NO DOKUMENT</th>
                        <th width=" 10%">TANGGAL</th>
                        <th width=" 12%">AGENDA KE</th>
                        <th>JUDUL</th>
                        <th>PRESENTASI OLEH</th>
                        <th width="15%">FILE</th>
                    </tr>
                </thead>
            </table>
            @endif
        @endcomponent
    </section>
    
    <div class="modal fade" id="modal-id">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">-</h4>
                </div>
                <div class="modal-body">
                    <div id="example1"></div>
                </div>
            </div>
        </div>
    </div>
@endsection