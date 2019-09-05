@extends('layout.app')

@section('menu_active')
    @php($active = 'SDM')
@endsection

@section('style')
{{-- easyui start--}}
<link href="{{ url('plugins/jquery-easyui/themes/bootstrap/easyui.css') }}" rel="stylesheet" />
<link href="{{ url('plugins/jquery-easyui/themes/icon.css') }}" rel="stylesheet" />
{{-- easyui end--}}
@endsection

@section('script')
{{-- easyui start--}}
<script src="{{ url('plugins/jquery-easyui/jquery.easyui.min.js') }}"></script>
{{-- easyui end--}}

<script type="text/javascript">
	$(document).ready(function(){
		PK();
		$( window ).resize(function() {
		    $('#dg').treegrid('resize');
		});
	});
	
	function PK() {
	    $('#dg').treegrid({
	      //url : '{{ url('laporanpk/treegrid') }}'
	      url : '{{ url('sdm/organisasi/show') }}'
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
				Struktur Organisasi
			@endslot

			<div id="divdg">
                <table id="dg" title="" class="easyui-treegrid table-responsive" style="height: 500px"
                        data-options="
                            {{-- url: '{{ url('/laporanpk/treegrid') }}', --}}
                            method: 'get',
                            rownumbers: false,
                            pagination: false,
                            pageSize: 2,
                            pageList: [2,10,20],
                            idField: 'id',
                            treeField: 'OBJ',
                            onLoadSuccess:function(data){
                              
                            } 
                        ">
                    <thead>
                        <tr>
                            <th field="OBJ" width="20%">ID</th>
                            <th field="organisasi" width="30%">ORGANISASI</th>
                            <th field="name" width="40%">NAMA</th>
                            <th field="gol" width="10%">GOLONGAN</th>
                        </tr>
                    </thead>
                </table>
            </div>		
		@endcomponent
		<div style="margin-bottom: 10px"></div>
	</section>
@endsection
