@extends('layout.app')

@section('menu_active')
	@php($active = 'Data Master')
@endsection

@section('style')
<style type="text/css">
	
</style>
@endsection

@section('script')
<script type="text/javascript">
	
</script>
@endsection

@section('content')
<!-- begin page-header -->
<h1 class="page-header">Dashboard Operation Excellence</h1>
<!-- end page-header -->

<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Navigation</h4>
	</div>
	<div class="panel-body">
		<div>
			<button class="btn btn-primary" id="tambah" data-toggle="modal" href='#modal-id'>
				<span class="fa fa-plus"></span>
				Tambah
			</button>
		</div>
		{{-- <form action="/upload" method="post" enctype="multipart/form-data">
			<input type="file" name="file">
			<input type="submit" name="kirim" value="kirim">
			{{ csrf_field() }}
		</form> --}}
	</div>
</div>

<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Navigation</h4>
	</div>
	<div class="panel-body">
		
	</div>
</div>

<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" action="{{ url('simpan_rkp') }}">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tahun : </label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" 
                            		placeholder="Tahun" max="2018" required
                            		name="tahun" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Target : </label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" 
                            		placeholder="Tahun" required
                            		name="target" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Submit : </label>
                        <div class="col-md-10">
                        	<button class="btn btn-primary" type="submit">
                        		<span class="fa fa-send"></span>
                        		Kirim
                        	</button>
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

@endsection