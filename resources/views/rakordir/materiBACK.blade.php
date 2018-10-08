@extends('layout.app')

@section('menu_active')
    @php($active = 'RAKORDIR')
@endsection

@section('style')
<style type="text/css">
.fa-folder-open:hover {
    color: #428bca;
}
.pdfobject-container { height: 500px;}
.pdfobject { border: 1px solid #666; }
</style>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('public/plugins/PDFObject/pdfobject.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#pdf').hide();
    });
    function pdf(file) {
        PDFObject.embed("{{ url('public/storage') }}/"+file, "#example1");
        
        $('#pdf').show();
        // $('#content').hide();
    }
    function show() {
        var doc = new jsPDF();
         doc.output('{{ url('public/storage/files/rakordir/admin/2018-09-25/10e42WD9yzQTT9vQ6f0878hb9wFpXNt4bUo781nC.pdf') }}');
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
            <form class="form-horizontal" action="{{ url('rakordir/cari') }}" method="get">
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="input-group">
                            @if($isi)
                                <span class="input-group-btn">
                                    <a class="btn btn-primary" href="{{ url('rakordir/file') }}">
                                        <span class="fa fa-arrow-left"></span>
                                        Back
                                    </a>
                                </span>
                            @endif
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
                            @if($isi)
                                <center>
                                <a style="text-decoration:none" data-toggle="modal" href='#modal-id' data-toggle="modal" href='#modal-id' onclick="pdf('{{ $value->file_path }}')">
                                    <span class="text-danger">
                                        <li class="fa fa-file-pdf-o fa-5x m-b-5"></li><br>
                                        {{ $value->judul }}
                                    </span>
                                </a>
                                </center>
                            @else
                                <a href="{{ url('rakordir/file') }}/{{ $value->date }}" style="text-decoration:none" data-toggle="modal" href='#modal-id'>
                                    <span class="text-warning">
                                        <li class="fa fa-folder-open fa-5x m-b-5"></li><br>
                                        {{ \Carbon\Carbon::parse($value->date)->format('d-m-Y') }}
                                    </span>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endcomponent
    </section>

    <section id="pdf">
        @component('component.panel')
            @slot('title')
                <button class="btn btn-danger btn-sm">
                    <span class="fa fa-arrow-left"></span>
                    Kembali
                </button>          
            @endslot
            <div id="example1"></div>
        @endcomponent
    </section>

@endsection