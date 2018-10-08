<div class="panel panel-inverse" >
	<div class="panel-heading">
		<div class="panel-heading-btn">
	  		<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
		</div>
		<h4 class="panel-title text-white"> {{ $title }} </h4>
	</div>

	<div class="panel-body p-5">
		{{ $slot }}
	</div>
</div>