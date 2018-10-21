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
                "url" : "{{ url('rakordir/show_upload') }}",
                "type" : "POST",
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
                { "data": "date"},
                { "data": "agenda_no"},
                { "data": "judul" },
                { "data": "presenter" },
                { "data": "file_path" , 
                   render: function ( data, type, row ) {
                    var del = '<a data-toggle="modal" href="#modal-id" class="text-danger" style="margin:0px 2px 2px 0px" onclick="pdf(`'+data+'`)"><i class="fa fa-file-pdf-o fa-2x"></i></a>';
                    return del;
                  }
                }
            ]
        });

    });
    function pdf(file) {
        var ex = file.substr(-3, 3);
        var url;
        var html;
        if(ex === 'pdf' || ex === 'PDF'){
            url = "{{ url('public/plugins/pdfjs/web/viewer.html?file=') }}"+"{{ url('/public/storage/') }}/"+file;
            html = "<iframe src='"+url+"' style='width: 100%; height:600px'></iframe>";
        }else{
            url = "{{ url('/public/storage/') }}/"+file;
            html = "<h5 class='text-center'><a href='"+url+"' target='_blank'>Kilik disini untuk unduh file.</a></h5>"
        }
        $('#example1').html(html);
    }
    function openForm() {
        window.location.href = '{{ url('rakordir/form_input') }}';
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

                <button class="btn btn-primary btn-sm" onclick="openForm()">Tambah</button>            
            @endslot
            
            <table id="example" class="table table-responsive table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width=" 20%">NO DOKUMENT</th>
                        <th width=" 10%">TANGGAL</th>
                        <th width=" 12%">AGENDA KE</th>
                        <th>JUDUL</th>
                        <th>PRESENTASI OLEH</th>
                        <th width="10%">AKSI</th>
                    </tr>
                </thead>
            </table>

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