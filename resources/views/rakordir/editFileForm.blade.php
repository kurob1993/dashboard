@extends('layout.app')

@section('menu_active')
    @php($active = 'RAKORDIR')
@endsection

@section('style')
<link href="{{ url('plugins/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet" />
<style type="text/css">

</style>
@endsection

@section('script')
<script src="{{ url('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}" charset="UTF-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tanggal').datepicker({
            language: 'id',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        // document.querySelectorAll('input[type=number]')
        // .forEach(e => e.oninput = () => {
        //     // Always 2 digits
        //     if (e.value.length >= 2) e.value = e.value.slice(0, 2);
        //     // 0 on the left (doesn't work on FF)
        //     if (e.value.length === 1) e.value = '0' + e.value;
        //     // Avoiding letters on FF
        //     if (!e.value) e.value = '00';
        // });

    });
    function back() {
        window.location.href = '{{ url('rakordir/input_file') }}';
    }
    function batal(x,newIndex) {
        
        console.log(newIndex);
        
        $('#file'+newIndex).remove();
        $('.inputGroup'+x).show();
    }
    function addFile(x = null, oldFile = null , oldName = null){
        var index = parseInt($('#index').val());
        var newIndex = $('#index').val(index+1);
        var file;
        if(x){
            file    =   '<div class="input-group" id="file'+(index+1)+'">'+
                            '<input type="hidden" class="form-control" name="oldfile[]" value="'+oldFile+'">'+
                            '<input type="hidden" class="form-control" name="oldNameFile[]" value="'+oldName+'">'+
                            '<input type="file" class="form-control" placeholder="File" name="file[]" value="" required>'+
                            '<span class="input-group-btn">'+
                                '<button class="btn btn-danger" type="button" onclick="batal('+x+','+(index+1)+')">Batal</button>'+
                            '</span>'+
                            
                        '</div>';
            $('.file'+x).append(file);
            $('.inputGroup'+x).hide();
        }else{
            file = '<div class="col-md-8"><input type="file" class="form-control m-b-5" id="file'+newIndex+'" placeholder="File" name="file[]" value=""></div>';
            $('.addfile').append(file);
        }
    }
</script>
@endsection
@section('content')
    <h1 class="page-header">Dashboard Operation Excellence </h1>
    <section>
        @component('component.panel')
            @slot('title')
                <span class="fa fa-pencil-square-o"></span>
                Edit File Rakordir             
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
            @foreach ($data as $item)
                <form class="form-horizontal" id="formData" method="post" action="{{ url('rakordir/edit') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="control-label col-md-2" for="Judul">Tanggal:</label>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <input type="text" name="tanggal" placeholder="Tanggal" class="form-control" id="tanggal" autocomplete="off" value="{{ $item['date'] }}" required>
                                <input type="hidden" name="tanggal_val" class="form-control" value="{{ $item['date'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="tempat">No Dokumen:</label>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="no_dokument" placeholder="No Dokument" name="no_dokument" value="{{  $item['no_dokument'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Judul">Agenda Ke:</label>
                        <input type="hidden" name="agenda_no_val" class="form-control" value="{{ $item['agenda_no'] }}">
                        <div class="col-md-10">
                            <div class="col-md-5">
                                <select class="form-control" required name="agenda_no">
                                    <option value=""> .: Pilih Agenda :. </option>
                                    @for ($i=0; $i < 10 ; $i++)
                                        @if( $item['agenda_no'] == $i+1 )
                                            <option value="{{ $i+1 }}" selected> {{ $i+1 }} </option>
                                        @else
                                            <option value="{{ $i+1 }}"> {{ $i+1 }} </option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Judul">Jam:</label>
                        <div class="col-md-8">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" maxlength="2" class="form-control"  value="{{ $item['mulai'][0] }}" name="jam_mulai" required>
                                    <span class="input-group-addon" id="basic-addon1">:</span>
                                    <input type="text" maxlength="2" class="form-control"  value="{{ $item['mulai'][1] }}" name="menit_mulai" required>
                                </div>
                            </div>
    
                            <div class="col-md-2">
                                <input type="text" class="form-control text-center" value="s.d" readonly/>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" maxlength="2" class="form-control"  value="{{ $item['keluar'][0] }}" name="jam_keluar" required>
                                    <span class="input-group-addon" id="basic-addon1">:</span>
                                    <input type="text" maxlength="2" class="form-control"  value="{{ $item['keluar'][1] }}" name="menit_keluar" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-2" for="Judul">Judul:</label>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="judul" placeholder="Judul" name="judul" value="{{ $item['judul'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Judul">Presentasi oleh:</label>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="presenter" placeholder="Presentasi oleh" name="presenter" id="judul" value="{{ $item['presenter'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group file">
                        <label class="control-label col-md-2" for="Judul">File:</label>
                        <div class="col-md-10">
                            @foreach ($item['file_name'] as $key => $itemx)
                                @if ($itemx)
                                    <div class="col-md-12 m-b-5 file{{ $key+1 }}">
                                        <div class="input-group inputGroup{{ $key+1 }}">
                                            <input type="text" readonly class="form-control" value="{{ $itemx }}" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-warning" type="button" onclick="addFile('{{ $key+1 }}','{{ $item['file_path'][$key] }}','{{ $itemx }}') ">Edit</button>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            <div class="addfile"></div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary m-b-5" onclick="addFile()"> 
                                    <i class="fa fa-plus"></i>
                                    File Materi
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="simpan"></label>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <input type="hidden" id="index" value="{{ count($item['file_name'])-1 }}">
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
                    </div>
                
                </form>           
            @endforeach
        @endcomponent
    </section>

@endsection