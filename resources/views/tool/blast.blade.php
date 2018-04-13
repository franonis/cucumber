@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/layer/skin/default/layer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/awesome-bootstrap-checkbox.css') }}">
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

        <form id="blastform" method="post" action="{{ url('tools/blast/dispatch') }}">
        	{{ csrf_field() }}

	        <div class="col-md-12">
	            <h4>Program</h4>
	            <select id="program" name="program" class="form-control"></select>
	        </div>
	        <div class="col-md-12">
	            <h4>Query Sequence
	                <small>Examples
	                    <select id="example">
	                        <option>--select an example--</option>
	                    </select>
	                </small>
	            </h4>
	            <textarea class="input-hg form-control" class="reset" rows="5" name="seq" id="seq"
					data-toggle="tooltip" data-placement="bottom"
					title="Your job will be put to queue if more than
						{{ config('blast.min_sequence_number_to_queue') }} sequences were put in"
	            	></textarea>
	        </div>
	        <div class="col-md-12">
	            <h4>Expect (e-value) Threshold:
	                <small>
	                    <input id="evalue" type="text" name="evalue" value="1e-5" style="width:6%; display:inline;" class="form-control" autocomplete="on"></input>
	                    e-value should be like 0.1,0.01... or 1/10,1/100... or 1e-3,1e-5....
	                </small>
	            </h4>
			</div>
			<div class="col-md-12">
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
			</div>
			<div class="col-md-12">
				<h4>Job Name:
	                <input id="job_name" type="text" name="job_name"
	                	style="width:45%; display:inline;" class="form-control"
	                	placeholder="Optional. Only numbers, letters and underlines allowed!"
						data-toggle="tooltip" data-placement="bottom"
						title="Only numbers, letters and underlines allowed. '{{ auth()->user()->name .'_'}}' will be prepended to the name you set automatically.">
	                </input>
	            </h4>
			</div>
			<div class="col-md-12 text-center">
	            <br>
	            <button id="submit" class="button button-rounded button-primary" type="button">BLAST</button>
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
<script src="{{ asset('vendor/layer/layer.js') }}"></script>

<script>
	var config = {!! json_encode(config('blast')) !!};
	// Set species select options
	$('#species').html('');
	$.each(config.blast_settings, function (i, setting) {
		$('#species').append('<option value='+ setting.value +'>' + setting.name + '</option>')
	});
	setDB($('#species option:first').val());
	$('#species').change(function(){
		setDB($(this).val());
		setProgram($('#species option:selected').val(), $('#database option:selected').val());
	});

	// Set database select options
	function setDB (species) {
		$.each(config.blast_settings, function(i,setting){
			if(setting.value == species) {
				$('#database').html('');
				$.each(setting.database, function (j, db){
					$('#database').append('<option value='+ db.dbname +'>' + db.name + '</option>')
				});
			}
		});
	}
	setProgram($('#species').val(), $('#database option:first').val());
	$('#database').change(function(){
		setProgram($('#species option:selected').val(), $('#database option:selected').val());
	});

	// Set program
	function setProgram (species, database) {
		$.each(config.blast_settings, function(i, setting){
			if(setting.value == species){
				$.each(setting.database, function(j, db){
					if(db.dbname == database) {
						$('#program').html('');
						$.each(db.programs, function (k,p){
							$('#program').append('<option value="'+ config.blast_programs[p].name +'">'+ config.blast_programs[p].title +'</option>');
						})
					}
				});
			}
		});
	}

	// set example
	$.each(config.blast_example, function(i, e){
		$('#example').append('<option value="'+ e.name +'">'+ e.name +'</option>')
	});

	$('#example').change(function(){
		$('#seq').html('');
		name = $(this).val();
		$.each(config.blast_example, function(i,e){
			if(e.name == name) {
				$('#seq').html(e.fasta);
			}
		});
	});

	$('#submit').on('click', function(){
		seq = $('#seq').val();
		$('#submit').html('Validate Sequence...<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Validating...</span>');
		$.post('{{ url('tools/blast/sequence/validation') }}',
				{seq:seq, _token: '{{csrf_token()}}'},
					function(rep){
						if(undefined !== rep.error){
							layer.msg(rep.error);
							$('#submit').text('BLAST');
							$('#seq').focus();
							return false;
						}else{
							$('#submit').html('Validating Job Name...<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Validating...</span>');
							if($('#job_name').val()){
								$.getJSON('{{ url('tools/blast/validate/jobname') }}/' + $('#job_name').val(),function (resp) {
									if(resp.exists){
										layer.msg('Job name exists already!');
										$('#job_name').focus();
										$('#submit').html('BLAST');
										return false;
									}
									else {
										$('#submit').html('BLASTing...<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">BLASTing...</span>');
										$('button[type="submit"]').click();
									}
								});
							}
							else {
								$('#submit').html('BLASTing...<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">BLASTing...</span>');
								$('button[type="submit"]').click();
							}
						}
					});
		});

	$('#job_name').keyup(function(){
		job_name = $(this).val();
		name = job_name.replace(/[^\d\w\_]+/g,'_');
		name = name.replace(/\_+/g,'_');
		if(name!=job_name){
			$(this).val(name);
		}
	});

</script>
@endsection
