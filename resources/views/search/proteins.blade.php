@extends('layouts.app')
@section('css')

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
	<h1>Protein</h1>
	<ul>
	@foreach($proteins as $p)
		<li>{{ $p->gene }}.{{ $p->protein }}: {{ $p->feature->name}}</li>
	@endforeach
	</ul>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
