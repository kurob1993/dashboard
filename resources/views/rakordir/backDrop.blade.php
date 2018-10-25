@extends('layout.app')

@section('menu_active')
    @php($active = 'RAKORDIR')
@endsection

@section('style')
<link href="{{ url('public/plugins/DataTables/css/data-table.css') }}" rel="stylesheet" />
<style type="text/css">

@font-face {
    font-family: OceanSansStd;
    src: url("{{ url('/public/fonts/OceanSansStd-BoldExt.otf') }}");
}

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
                    var del = '';
                    var ex;
                    var fa;
                    for (let index = 0; index < data.length; index++) {
                        
                        if(data[index]){
                            ex = data[index].substr(-3, 3);
                            if(ex === 'pdf' || ex === 'PDF'){
                                fa = 'fa-file-pdf-o';
                            }else{
                                fa = 'fa-file-text-o';
                            }
                            del += '<a data-toggle="modal" href="#modal-id" class="text-danger" '+
                                        'style="margin:0px 2px 2px 0px" onclick="pdf(`'+data[index]+'`)">'+
                                    '<i class="fa '+fa+' fa-2x"></i>'+
                                    '</a>';
                            console.log(data[index]);
                            
                        }
                    }
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
    <section id="content" style="">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-center">
                    <img src="{{ url('public/img/krakatausteel-logo.png') }}" alt="logo ks" width="200px" >
                </div>
                <div class="text-center m-t-15" style="background-color : red;font-family: OceanSansStd;border-radius: 4px;">
                    <span style="color: white;font-size:18px">RAPAT KOORDINASI DIREKSI PT KRAKATAUSTEEL (PERSERO) Tbk.</span>
                </div>
                <div class="text-center m-b-15 m-t-15">
                    <span style="color: black;font-size:22px;font-family: OceanSansStd;">MEETING SCHEDULE</span>
                </div>
                <div class="">
                    <table class="table" style="width:100%;color: black;font-size:13px;border-top:1px solid #e2e7eb;">
                        <thead>
                            <tr>
                                <th width="10%">NO</th>
                                <th>TIME</th>
                                <th>AGENDA</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->agenda_no }}</td>
                                    <td>{{ $item->mulai }} - {{ $item->keluar }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>
                                        <a href="{{ url('rakordir/file') }}/{{ $item->date }}" class="fa fa-arrow-right fa-lg"></a>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="p-5" style="background-color : blue;font-family: OceanSansStd;border-radius: 4px;">
                    <h4 style="color: white;"> {{ $lastDate }}</h4>
                </div>
            </div>
        </div>
    </section>
@endsection