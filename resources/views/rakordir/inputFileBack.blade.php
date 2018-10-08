@extends('layout.app')

@section('menu_active')
    @php($active = 'RAKORDIR')
@endsection

@section('style')
<link href="{{ url('public/plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ url('public/plugins/Dropzone/dropzone.css') }}">
<style type="text/css">

</style>
@endsection

@section('script')
<script src="{{ url('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('public/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}" charset="UTF-8"></script>
<script src="{{ url('public/plugins/Dropzone/dropzone.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tanggal').datepicker({
            language: 'id',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        Dropzone.options.frmTarget = {
            autoProcessQueue: false,
            maxFiles: 1,
            url: '{{ url('rakordir/upload') }}',
            init: function () {

                var myDropzone = this;

                // Update selector to match your button
                $("#button").click(function (e) {
                    e.preventDefault();
                    var tempet = $('#tempat').val();
                    var judul = $('#judul').val();
                    var date = $('#tanggal').val();

                    if( tempet !== '' && judul !== '' && date !== '' ){
                        myDropzone.processQueue();
                    }else{
                        alert('Data masih belum lengkap');
                    }
                    
                });

                this.on('sending', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    var data = $('#frmTarget').serializeArray();
                    var form = $('#formData').serializeArray();

                    $.each(form, function(key, el) {
                        formData.append(el.name, el.value);
                    });

                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                    window.location.href = "{{ url('rakordir/file') }}";
                });
                
            }
        }

    });
    function test() {
        var form = $('#formData').serializeArray();
         console.log(form);           
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

            <form class="form-horizontal" id="formData">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tempat">Tempat:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat" placeholder="Tempat" name="tempat" id="tempat">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">Judul:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="judul" placeholder="Judul" name="judul" id="judul">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="Judul">Tanggal:</label>
                    <div class="col-sm-10">
                        <input type="text" name="tanggal" class="form-control" id="tanggal" autocomplete="off" value="">
                    </div>
                </div>
            </form>
            <form class="dropzone" id="frmTarget" style="border: 2px dashed blue">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

            <button type="submit" id="button" class="btn btn-primary m-t-20">Submit</button>
        @endcomponent
    </section>

@endsection