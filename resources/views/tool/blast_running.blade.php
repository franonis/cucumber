@extends('layouts.app')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('/layer/skin/default/layer.css') }}">
@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
    <div class="row">
    	<h2>BLAST</h2>
        <hr>
        @include('partials.errors')

		<h3>You job is running, please check it later! </h3>
		<h4>Your job ID is: <a href="{{ url('/tools/blast/') .'/'.$job }}">{{$job}}</a></h4>

     </div>
</div>
@endsection
@section('footer')
  @include('partials.footer')
@endsection
