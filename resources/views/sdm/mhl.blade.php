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
                <li class="disabled"><a>BULAN : </a></li>
                <li class="active"><a data-toggle="tab" href="#bulan01">01 - 02</a></li>
                <li><a data-toggle="tab" href="#bulan02">03 - 04</a></li>
                <li><a data-toggle="tab" href="#bulan03">05 - 06</a></li>
                <li><a data-toggle="tab" href="#bulan04">07 - 08</a></li>
                <li><a data-toggle="tab" href="#bulan05">09 - 10</a></li>
                <li><a data-toggle="tab" href="#bulan06">11 - 12</a></li>
                <li class="pull-right m-r-10">
                    <form class="form-inline text-center m-t-3" action="" method="get">
                        <div class="form-group m-l-5">
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
                <div id="bulan01" class="tab-pane fade in active">
                  @include('sdm.tabMhlBln01')
                </div>
                <div id="bulan02" class="tab-pane fade">
                    @include('sdm.tabMhlBln02')
                </div>
                <div id="bulan03" class="tab-pane fade">
                    @include('sdm.tabMhlBln03')
                </div>
                <div id="bulan04" class="tab-pane fade">
                    @include('sdm.tabMhlBln04')
                </div>
                <div id="bulan05" class="tab-pane fade">
                    @include('sdm.tabMhlBln05')
                </div>
                <div id="bulan06" class="tab-pane fade">
                    @include('sdm.tabMhlBln06')
                </div>
            </div>
        </div>
	</section>
@endsection