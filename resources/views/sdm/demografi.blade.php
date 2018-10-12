@extends('layout.app')

@section('menu_active')
    @php($active = 'SDM')
@endsection

@section('style')
<style type="text/css">

</style>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
@endsection

@section('content')
	<h1 class="page-header">Dashboard Operation Excellence </h1>
	<section>
        <div class="p-10" >
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#status">STATUS</a></li>
                <li><a data-toggle="tab" href="#golongan">GOLONGAN</a></li>
                <li><a data-toggle="tab" href="#pendidikan">PENDIDIKAN</a></li>
                <li><a data-toggle="tab" href="#usia">USIA</a></li>
                <li class="pull-right m-r-10">
                    <form class="form-inline text-center m-t-3" action="" method="get">
                        <div class="form-group">
                            <a data-toggle="tab" href="#" style="color:black">TAHUN : </a>
                            <div class="input-group">
                                <select class="form-control" name="tahun">
                                    @foreach($tahun as $key => $value)
                                        @if($value->tahun == $select_tahun)
                                            <option value="{{ $value->tahun }}" selected>{{ $value->tahun }}</option>
                                        @else
                                            <option value="{{ $value->tahun }}">{{ $value->tahun }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary">Pilih</button>
                                </span>
                            </div>
                            </h4>
                        </div>
                    </form>
                </li>
            </ul>

            <div class="tab-content" style="">
                <div id="status" class="tab-pane fade in active">
                    @include('sdm.tabStatus')
                </div>
                <div id="golongan" class="tab-pane fade">
                    @include('sdm.tabGolongan')
                </div>
                <div id="pendidikan" class="tab-pane fade">
                    @include('sdm.tabPendidikan')
                </div>
                <div id="usia" class="tab-pane fade">
                    @include('sdm.tabUsia')
                </div>
            </div>
        </div>
	</section>
@endsection