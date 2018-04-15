@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/layer/skin/default/layer.css') }}">
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
        <div class="panel panel-info regionbox">
            <div class="panel-heading"><h4>A. Search by Name</h4></div>
            <div class="panel-body">
            <form action='/search' method="post">
            <div class="panel-heading"><h4>1. Choose The Type of Data:</h4></div>
            @csrf
        	<div class="col-md-12">
                <select name="type" class="form-control">
                    <option value="gene">GeneID</option>
                    <option value="protein">ProteinID</option>
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
            <div class="col-md-12 text-center" >
                <button class="button button-rounded button-primary" type="submit">Search</button>
            </div><br>
            </form><hr>
        </div>
        </div>
        </div>
        <hr>
        <br><br>
        <div class="panel panel-info namebox">
            <div class="panel-heading"><h4>B. Search by region</h4></div>
            <div class="panel-body">
                <form id="regionform" action="/search" method="post">
                    @csrf
                    <div class="col-md-12 form-inline">
                        <h4 class="text-primary">1. Choose the chr and input the region</h4>
                            </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Chr: </label>
                                <select name="chr" id="chr" class="form-control">
                                    <option value="chr1">chr1</option>
                                    <option value="chr1">chr2</option>
                                    <option value="chr1">chr3</option>
                                    <option value="chr1">chr4</option>
                                    <option value="chr1">chr5</option>
                                    <option value="chr1">chr6</option>
                                    <option value="chr1">chr7</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> Start: </label>
                                <input type="number" id="start" name="start" class="form-control" min="0" placeholder=" > 0">
                            </div>
                            <div class="col-md-3">
                                <label>End: </label>
                                <input type="number" id="end" name="end" style="min-width: 150px" class="form-control" min="0">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="button button-rounded button-primary pull-center">Search</button><br>
                    </div><br>
                </form>
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
    $('#regionform').submit(function(e){
        start = parseInt($('#start').val());
        end = parseInt($('#end').val());

        if(start < 0 || end < start){
            layer.msg('Start should smaller than end!');
            return;
        }
    });


</script>
@endsection
