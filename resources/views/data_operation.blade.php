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
<h1 class="page-header">Dashboard Opration Excellence</h1>
<!-- end page-header -->

<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Data1</h4>
	</div>
	<div class="panel-body">
		<form action="/upload" method="post" enctype="multipart/form-data">
			<input type="file" name="file">
			<input type="submit" name="kirim" value="kirim">
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection