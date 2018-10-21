@extends('layout.app')

@section('menu_active')
    @php($active = 'RAKORDIR')
@endsection

@section('style')
<link href="{{ url('public/plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
<style type="text/css">

</style>
@endsection

@section('script')
<script src="{{ url('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('public/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tanggal').datepicker({
            language: 'id',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

    });
    function back() {
        window.location.href = '{{ url('rakordir/input_file') }}';
    }
</script>
@endsection
@section('content')
    <h1 class="page-header">Dashboard Operation Excellence </h1>
    <section>
        @component('component.panel')
            @slot('title')
                <span class="fa fa-file"></span>
                Input File Rakordir             
            @endslot

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" id="formData" method="post" action="{{ url('rakordir/upload') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">Tanggal:</label>
                    <div class="col-sm-10">
                        <input type="text" name="tanggal" class="form-control" id="tanggal" autocomplete="off" value="{{ old('tanggal') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="tempat">NO Dokumen:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_dokument" placeholder="No Dokument" name="no_dokument" id="tempat" value="{{ old('no_dokument') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">Agenda Ke:</label>
                    <div class="col-sm-10">
                        <select class="form-control" required name="agenda_no">
                            <option value=""> - </option>
                            @for ($i=0; $i < 10 ; $i++)
                                @if( old('agenda_no') == $i+1 )
                                    <option value="{{ $i+1 }}" selected> {{ $i+1 }} </option>
                                @else
                                    <option value="{{ $i+1 }}"> {{ $i+1 }} </option>
                                @endif
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">Judul:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="judul" placeholder="Judul" name="judul" id="judul" value="{{ old('judul') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">Presentasi oleh:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="presenter" placeholder="Presentasi oleh" name="presenter" id="judul" value="{{ old('judul') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">File:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="file" placeholder="File" name="file" id="file" value="{{ old('file') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="simpan"></label>
                    <div class="col-sm-10">
                         <button type="submit" id="button" class="btn btn-primary" id="simpan">
                            <span class="fa fa-save"></span>
                            Simpan
                             
                         </button>
                         <a type="submit" id="button" class="btn btn-danger" id="batal" href="javascript:void(0)" onclick="back()">
                            <span class="fa fa-times "></span>
                            Batal
                             
                         </a>
                    </div>
                </div>
               
            </form>
            
        @endcomponent
    </section>

@endsection