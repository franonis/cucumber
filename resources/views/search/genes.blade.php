@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/layer/skin/default/layer.css') }}">
@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
    <div class="panel panel-info">
        <div class="panel-heading"><h4>Gene search result</h4></div>
    	<div class="panel-body">
    		<div class="row">
	        		@if(!empty($warnings))
	        			<div class="col-md-12">
	        				<br>
	        				@include('partials.errors')
	        			</div>
	        		@endif
	                <div class="col-md-12">
	                    <div class="row text-right">
            				<button class="button button-border button-rounded button-tiny" onclick="refreshIframe()">
            					Reload <i class="fa fa-refresh fa-spin fa-fw"> </i>
            				</button>
	                    </div>
	                    <iframe id="jbrowse" style="border: 1px solid #e7e7e7"
	                    	src="{{ $gene['jbrowse'] }}" width="100%" height="300">
	                    </iframe>
	                    <p class="pull-right">* You may right click on the protein to view details.</p>
	                </div>
	            </div>
				<blockquote>Gene information</blockquote>
	            <div class="col-md-12">
	            	<dl>
	            		<dt>Gene ID</dt>
	            		<dd>{{ $gene['name'] }}</dd>
	            		<dt>Location</dt>
	            		<dd>{{ $gene['chr']. ':' . $gene['start'] . '-' . $gene['end'] . ' (' . $gene['strand'] . ')' }}. <a href="{{ url('http://cmb.bnu.edu.cn:8088/search/cucumber/feature/name') . '/' . $gene['name'] }}" target="cugr">View More Details</a></dd>
	            		<dt>Proteins</dt>
						<dl>
							<div class="col-md-12">
								<div class="checkbox col-sm-3">
								  <label class="text-primary"><input id="selectall" type="checkbox" > Select All</label>
								</div>
		            			@foreach($gene['proteins'] as $p)
		            			<div class="checkbox col-sm-3">
								  <label>
								    <input name="proteins" type="checkbox" value="{{ $gene['name'] . '.' . $p }}">
								    {{ $gene['name'] . '.' . $p }}
								  </label>
								</div>
            					@endforeach
            				</div>
            				<div class="text-center">
            					<button id="compare" class="btn btn-default">Compare Proteins</button>
            				</div>
	            		</dl>
	            		<dt>AS Events</dt>
	            		<dl>
	            			<div class="table-responsive">
		            			<table class="table">
		            				<thead>
		            					<tr>
		            						<th>event</th>
		            						<th>chr</th>
		            						<th>loc</th>
		            					</tr>
		            				</thead>
		            				<tbody>
		            					@foreach($gene['events'] as $e)
		            					<tr>
		            						<td>{{ $e->event }}</td>
		            						<td>{{ $e->chr }}</td>
		            						<td>{{ $e->loc }}</td>
		            					</tr>
		            					@endforeach
		            				</tbody>
		            			</table>
		            		</div>
	            		</dl>
	            	</dl>
		        </div>
    		</div>
	    </div>
    </div>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layer/layer.js') }}"></script>
<script type="text/javascript">
	$('#selectall').click(function () {
		checked = $(this).prop('checked');
		$('input[name="proteins"]').prop('checked', checked);
	});

	$('#compare').click(function () {
		var proteins = [];
		$('input[name="proteins"]').each(function(idx, dom){
			if($(dom).prop('checked')){
				p = $(dom).val();
				proteins.push(p);
			}
		});
		if(proteins.length == 0){
			layer.msg('No protein selected!');
			return;
		}
		window.location.href = '{{ url('/proteins/compare/') }}?proteins=' + proteins.join(',');
	});
</script>
@endsection
