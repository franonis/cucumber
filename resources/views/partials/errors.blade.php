{{-- errors are not allow to preceed, should return this back --}}
@if(isset($errors))
	@foreach($errors as $error)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-remove"></i></button>
			<strong>Error:</strong> {!! $error !!}
		</div>
	@endforeach
@endif

{{-- @if(null !== session('errors'))
	@foreach(session('errors') as $error)
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-remove"></i></button>
			<strong>Error:</strong> {!! $error !!}
		</div>
	@endforeach
@endif --}}

@if(null !== session('warnings'))
	@foreach(session('warnings') as $warning)
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-remove"></i></button>
			<strong>Warning:</strong> {!! $warning !!}
		</div>
	@endforeach
@endif

@if(null !== session('infos'))
	@foreach(session('infos') as $info)
		<div class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-remove"></i></button>
			<strong>Info:</strong> {!! $info !!}
		</div>
	@endforeach
@endif

@if(null !== session('successes'))
	@foreach(session('successes') as $success)
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-remove"></i></button>
			<strong>Success:</strong> {!! $success !!}
		</div>
	@endforeach
@endif