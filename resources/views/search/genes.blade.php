@extends('layouts.app')
@section('css')

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
	                    	src="{{ $jbrowse }}" width="100%" height="300">
	                    </iframe>
	                    <p class="pull-right">* You may right click on the protein to view details.</p>
	                </div>
	            </div>
				<blockquote><p><strong>1</strong> Gene information</p></blockquote>
	            <div class="col-md-12 table-responsive">
		            <table id="featurestable" class="table table-hover">
		            	<thead>
		            		<tr>
		            			<th>Feature</th>
		            			<th>Type</th>
		            			<th>Location</th>
		            			<th>Strand</th>
		            			<th>Length</th>
		            			<th>JBrowse</th>
		            			<th>Annotation</th>
		            		</tr>
		            	</thead>
		            	<tbody>
		            		<tr></tr>
		            	</tbody>
		            </table>
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
@endsection
