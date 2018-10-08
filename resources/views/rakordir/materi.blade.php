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
<script type="text/javascript" src="{{ url('public/plugins/PDFObject/pdfobject.min.js') }}"></script>

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
            // "sDom": 'tipr', 
            "language": {
                "search": "Cari:",
                "lengthMenu": "Buka _MENU_ ",
                "info": "Buka _START_ s.d _END_ dari _TOTAL_ data",
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
                "beforeSend": function (request) {
                    request.setRequestHeader("X-CSRF-Token", "{{csrf_token()}}");
                }
            },
            "columns": [
                {   "data": "agenda_no",
                    render: function ( data, type, row, index) {
                        console.log(index.row+1);
                        return index.row+1;
                    }
                },
                { "data": "no_dokument"},
                { "data": "date"},
                { "data": "agenda_no"},
                { "data": "judul" },
                { "data": "file_path" , 
                   render: function ( data, type, row ) {
                    var del = '<a data-toggle="modal" href="#modal-id" class="text-danger" style="margin:0px 2px 2px 0px" onclick="pdf(`'+data+'`)"><i class="fa fa-file-pdf-o fa-2x"></i></a>';
                    return del;
                  }
                }
            ]
        });

    });
    function back() {
        window.location.href="{{ url('rakordir/file') }}";
    }
    function pdf(file) {
        PDFObject.embed("{{ url('public/storage') }}/"+file, "#example1");
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
            @if(!$tanggal)
            <form class="form-horizontal" action="{{ url('rakordir/file') }}" method="get">
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" name="cari" class="form-control" id="cari" autocomplete="off" value="">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="panel panel-default">
                <div class="panel-body" style="border: 1px solid grey;box-shadow: 2px 2px 1px grey;border-radius: 4px;">
                    @foreach($data as $key => $value)
                        <div class="col-md-2 col-sm-3 col-xs-6 m-t-5 m-b-5"> 
                            <a href="{{ url('rakordir/file') }}/{{ $value->date }}" style="text-decoration:none" data-toggle="modal" 
                                href='#modal-id'>
                                <span class="text-warning">
                                    <li class="fa fa-folder-open fa-5x m-b-5"></li><br>
                                    {{ \Carbon\Carbon::parse($value->date)->format('d-m-Y') }}
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
                        <th width="10%">AKSI</th>
                    </tr>
                </thead>
            </table>
            @endif
        @endcomponent
    </section>
    <div class="modal fade" id="modal-id">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="example1"></div>
                </div>
            </div>
        </div>
    </div>
@endsection