@extends('layouts.app')
@section('css')
@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
    <div class="panel panel-info">
        <div class="panel-heading"><h4>Search Results</h4></div>
    	<div class="panel-body">
    		<h4>{{ $title }}</h4>
    		<ul>
			@foreach ($queries as $q)
				<li>
					<a href="{{ url($link_template).'/' .$q }}">{{ $q }}</a>
				</li>
			@endforeach
			</ul>
	    </div>
    </div>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
