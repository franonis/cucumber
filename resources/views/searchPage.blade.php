@extends('layouts.app')
@section('css')
<style type="text/css">
    mark {
        padding: 0 !important;
        background-color: yellow;
    }
    .sequence {
        word-break: break-word !important;
    }
</style>
@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
    <div class="row">
        <h2>Specified Feature Search</h2>
        <hr/>
        @include('partials.errors')
        <div id="species" class="col-md-12">
            <h4>1. Choose The Type of Data:</h4>
                <form action="demo-form.php" method="get">
                	<div class="col-md-5">
	                    <select name="datatype" class="form-control">
	                        <option value="geneid">GeneID</option>
	                        <option value="proteinID">ProteinID</option>
	                        <option value="location">Location</option>
	                        <option value="uniprot">Uniprot</option>
	                    </select>
	                </div>
                </form>
        </div>

        <div class="col-md-12">
            <h4>2. Input the Target:</h4>
                <input type="text" name="feature" class="form-control" placeholder="e.g. Csa4G338980"  autocomplete="on" style="width:200px; display:inline-block !important" required>&nbsp;&nbsp;
                <small>Example:
                    <a href="{{ url('search/gene/Csa6G088160') }}">Csa4G338980</a>
                </small>
            </div>
        <div class="col-md-3">
            <br/>
            <button id="search" class="button button-rounded button-primary" type="button">Search</button>
        </div>
    </div>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
