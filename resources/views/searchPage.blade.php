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
        <form action='/search' method="post">
            <h4>1. Choose The Type of Data:</h4>
            @csrf
        	<div class="col-md-12">
                <select name="type" class="form-control">
                    <option value="gene">GeneID</option>
                    <option value="protein">ProteinID</option>
                    <option value="location">Location</option>
                    <option value="uniprot">Uniprot</option>
                </select>
                <br>
            </div>

            <h4>2. Input the Target:</h4>
            <div class="col-md-12">
                <input type="text" name="query" class="form-control" placeholder="e.g. Csa4G338980"  autocomplete="on" style="width:200px; display:inline-block !important" required>&nbsp;&nbsp;
                <small>Example:
                    <a href="{{ url('search/gene/Csa4G338980') }}">Csa4G338980</a>
                </small>
            </div>
            <div class="col-md-12 text-center" style="margin-top: 100px">
                <button class="button button-rounded button-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
@endsection
