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

        <form id="blastform" method="post" action="{{ url('/tools/blast/run') }}">
        	{{ csrf_field() }}

	        <div class="col-md-12">
	            <h4>Program</h4>
	            <select id="program" name="program" class="form-control">
	            	<option value="blastp">BLASTP</option>
	            	<option value="tblastn">TBLASTN</option>
	            </select>
	        </div>
	        <div class="col-md-12">
	            <h4>
	            	Query Sequence
					<button id="example" type="button" class="pull-right button button-tiny button-primary">Example</button>
	            </h4>
	            <textarea class="input-hg form-control" class="reset" rows="5" name="seq" id="seq"></textarea>
	        </div>
	        <div class="col-md-12">
	            <h4>Expect (e-value) Threshold:
	                <small>
	                    <input id="evalue" type="text" name="evalue" value="1e-5" style="width:6%; display:inline;" class="form-control" autocomplete="on"></input>
	                    e-value should be like 0.1,0.01... or 1/10,1/100... or 1e-3,1e-5....
	                </small>
	            </h4>
			</div>
			{{-- <div class="col-md-12">
				<h4>Output Format:</h4>
            	<select id="outfmt" name="outfmt" class="form-control">
                    <option value="0" selected="selected">(0) Pairwise</option>
                    <option value="1">(1) Query-anchored showing identities</option>
                    <option value="2">(2) Query-anchored no identities</option>
                    <option value="3">(3) Flat query-anchored, show identities</option>
                    <option value="4">(4) Flat query-anchored, no identities</option>
                    <option value="5">(5) XML Blast output</option>
                    <option value="6">(6) Tabular</option>
                    <option value="7">(7) Tabular with comment lines</option>
                    <option value="8">(8) Text ASN.1</option>
                    <option value="9">(9) Binary ASN.1</option>
                    <option value="10">(10) Comma-separated values</option>
                    <option value="11">(11) BLAST archive format (ASN.1)</option>
                </select>
			</div> --}}

			<div class="col-md-12 text-center">
	            <br>
	            <button id="submit" class="button button-rounded button-primary" type="submit">BLAST</button>
	            <button type="submit" style="display: none">BLAST</button>
	            <p class="text-left">
	            	<small>* Reference:
	            		<a href="https://www.ncbi.nlm.nih.gov/entrez/query.fcgi?db=PubMed&cmd=Retrieve&list_uids=10890397&dopt=Citation" target="_blank">Zheng Zhang, Scott Schwartz, Lukas Wagner, and Webb Miller (2000), "A greedy algorithm for aligning DNA sequences", J Comput Biol 2000; 7(1-2):203-14.</a>
	            	</small>
	            </p>
	        </div>
        </form>
    </div>
</div>
@endsection
@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layer/layer.js') }}"></script>

<script>
	$('#example').click(function(){
		$('#seq').html('');
		name = $(this).val();
		prog = $('#program').val();
		if(prog == 'blastp'){
			$('#seq').html(">A0A0A0LTV1\nMSTSELACAYAALALHDDGIAITAEKIAAVVAAAGLCVESYWPSLFAKLAEKRNIGDLLLNVGCGGGAAASVAVAAPTASAAAAPAIEEKREEPKEESDDDMGFSLFD");
		} else if(prog == 'tblastn'){
			$('#seq').html(">A0A0A0LTV1\nATGTCTACCAGTGAACTCGCGTGCGCGTACGCCGCCCTGGCTCTTCACGATGATGGAATCGCAATCACTGCGGAAAAGATTGCAGCCGTTGTAGCAGCTGCGGGGCTCTGTGTGGAATCTTACTGGCCTAGCTTGTTTGCTAAATTGGCCGAGAAGAGGAACATTGGGGACCTTCTTCTTAATGTTGGCTGTGGAGGTGGCGCTGCGGCTTCTGTGGCTGTAGCTGCTCCTACCGCCAGTGCTGCTGCCGCTCCTGCCATCGAGGAAAAGAGGGAGGAGCCAAAGGAGGAGAGCGATGATGACATGGGATTCAGCTTATTCGATTAA");
		}
	});

	$('#blastform').submit(function(e) {
		if($('#seq').val() == ''){
			layer.msg('Sequence is empty!');
			e.preventDefault();
		}
	})
</script>
@endsection
