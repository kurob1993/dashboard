@extends('layout.app')

@section('menu_active')
    @php($active = 'SDM')
@endsection

@section('style')
<style>
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
                <li class="active" title="PENCAPAIAN KPI PERUSAHAAN">
                    <a data-toggle="tab" href="#tab01">{{ substr('PENCAPAIAN KPI PERUSAHAAN', 0, 15) }}...</a>
                </li>
                <li class="" title="DIREKTORAT SDM & PU">
                    <a data-toggle="tab" href="#tab02"> {{ substr('DIREKTORAT SDM & PU', 0, 15) }}...</a>
                </li>
                <li class="" title="SUBDIT HUMAN CAPITAL MANAGEMENT">
                    <a data-toggle="tab" href="#tab03"> {{ substr('SUBDIT HUMAN CAPITAL MANAGEMENT', 0, 15) }}...</a>
                </li>
                <li class="" title="DIVISI PERFORMANCE MGT & CORPORATE CULTURE">
                    <a data-toggle="tab" href="#tab04"> {{ substr('DIVISI PERFORMANCE MGT & CORPORATE CULTURE', 0, 15) }}...</a>
                </li>
                <li class="pull-right m-r-10">
                    <form class="form-inline text-center m-t-5" action="" method="get">

                        <div class="form-group m-l-5">

                            <div class="input-group m-b-5">
                                <span class="input-group-addon">Bulan : </span>
                                <select class="form-control" name="bulan">
                                    @foreach($bulan as $key => $value)
                                        @if($value['bulan'] == $select_bulan)
                                            <option value="{{ $value['bulan'] }}" selected>{{ $value['nama'] }}</option>
                                        @else
                                            <option value="{{ $value['bulan'] }}">{{ $value['nama'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group m-b-5">
                                <span class="input-group-addon">Tahun : </span>
                                <select class="form-control" name="tahun">
                                    @foreach($tahun as $key => $value)
                                        @if($value->tahun == $select_tahun)
                                            <option value="{{ $value->tahun }}" selected>{{ $value->tahun }}</option>
                                        @else
                                            <option value="{{ $value->tahun }}">{{ $value->tahun }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary m-b-5">Pilih</button>
                        </div>
                    </form>
                </li>
            </ul>

            <div class="tab-content" style="">
                <div id="tab01" class="tab-pane fade in active">
                    @include('sdm.tabKpiPerusahaan')
                </div>
            </div>
        </div>
	</section>
@endsection