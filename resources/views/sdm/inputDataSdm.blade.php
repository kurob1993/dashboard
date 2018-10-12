@extends('layout.app')

@section('menu_active')
    @php($active = 'SDM')
@endsection

@section('style')
<link rel="stylesheet" href="{{ url('/public/plugins/select2/dist/css/select2.min.css') }}">
<style type="text/css">

</style>
@endsection

@section('script')
<script src="{{ url('/public/plugins/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#berdasarkan').select2();
	});

    function dataBerdasarkan(data){
        
        var url = '';
        switch (data) {
            case 'demografi':
                url = "{{ url('/sdm/input_data_sdm/berdasarkan/demografi') }}";
                break;
        
            case 'kpi':
                url = "{{ url('/sdm/input_data_sdm/berdasarkan/kpi') }}";
                break;
        
            default:
                break;
        }
        $('#berdasarkan').val([]).trigger('change');
        $('#berdasarkan').select2({
            ajax: {
                url: url,
                dataType: 'json'
            }
        });
    }
</script>
@endsection

@section('content')
	<h1 class="page-header">Dashboard Operation Excellence </h1>
	<section>
		@component('component.panel')
			@slot('title')
				<span class="fa fa-users"></span>
				Input Data SDM                
            @endslot

            @if (\Session::has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('message') !!}</li>
                    </ul>
                </div>
            @endif

            <form action="{{ url('/sdm/input_data_sdm/upload') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tahun">Data:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="data" id="data" onchange="dataBerdasarkan($(this).val())" required>
                            <option value=""> - </option>
                            @foreach ($data as $key => $item)
                                @if ($key == old('data'))
                                    <option value="{{ $key }}" selected>{{ $item }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>  

                <div class="form-group">
                    <label class="control-label col-sm-2" for="tahun">Tahun:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tahun" id="tahun" required>
                            <option value=""> - </option>
                            @for($i=0; $i < 5; $i++) { 
                                @if (date('Y')-$i == old('tahun'))
                                    <option value="{{ date('Y')-$i }}" selected>{{ date('Y')-$i }}</option>
                                @else
                                    <option value="{{ date('Y')-$i }}">{{ date('Y')-$i }}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                </div>  

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Berdasarkan">Berdasarkan:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="berdasarkan" id="berdasarkan">
                        </select>
                    </div>
                </div> 

                <div class="form-group">
                    <label class="control-label col-sm-2" for="file">File:</label>
                    <div class="col-sm-10">
                        <input type="file" name="file" id="fileToUpload" class="form-control" id="file" required>
                    </div>
                </div>  
                <div class="form-group">
                    <label class="control-label col-sm-2" for="simpan"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Upload" name="submit" class="btn btn-primary" id="simpan" required>
                    </div>
                </div>                       
            </form>
		@endcomponent
	</section>
@endsection