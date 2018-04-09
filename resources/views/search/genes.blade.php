@extends('layouts.app')
@section('css')

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
	<h1>Genes</h1>
	<ul>
	@foreach($genes as $gene)
		<li>{{ $gene->gene }}: {{ $gene->feature->name }}</li>
	@endforeach
	</ul>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
