@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/proteincompare.css') }}">
@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div id="content" class="container-fluid content">
	<div class="row pca" id="pca"> <!-- protein compare area-->
		<h2 id="pca_title"></h2>
		<div class="col-md-12" id="pca_feature_checker"></div>
	</div>

</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/js/proteins.compare.js') }}"></script>
<script src="{{ asset('/node_modules/echarts/dist/echarts.min.js') }}"></script>
{{-- <script src="https://cdn.bootcss.com/echarts/4.0.4/echarts-en.js"></script> --}}
<script>
	var proteins = {!! json_encode($proteins) !!};
	var features = {!! json_encode($features) !!};
	renderPage(features, proteins);
</script>
@endsection
