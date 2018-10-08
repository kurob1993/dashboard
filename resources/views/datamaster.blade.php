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
<h1 class="page-header">Dashboard Operation Excellence </h1>
<!-- end page-header -->

<div class="panel panel-inverse">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>

		<h4 class="panel-title"><span class="fa fa-dashboard"></span> Data</h4>
	</div>
	<div class="panel-body">
        <a href="{{ url('/getdatames') }}" class="btn btn-primary">GET DATA MES</a>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Produk</th>
                    <th>Tanggal</th>
                    <th>Tag Name</th>
                    <th>Child1</th>
                    <th>Child2</th>
                    <th>Vlaue</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->produk_id}}</td>
                    <td>{{$value->tanggal}}</td>
                    <td>{{$value->tag_name}}</td>
                    <td>{{$value->child1}}</td>
                    <td>{{$value->child2}}</td>
                    <td>{{$value->current_value}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
	</div>
</div>

@endsection