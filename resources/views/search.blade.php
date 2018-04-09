@extends('layouts.app')
@section('css')

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
	<form class="form-control" method="get" action="/search">
		{{-- @csrf --}}
		<input type="text" name="sss">
		<button type="submit">tijiao</button>
	</form>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
