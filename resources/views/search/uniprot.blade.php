@extends('layouts.app')
@section('css')

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
	<h1>Uniprot</h1>
	<ul>
	@foreach($uniprot as $uniprot)
		<li>{{ $uniprot->uniprot }}</li>
	@endforeach
	</ul>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
