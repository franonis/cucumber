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
        @include('partials.errors')
        <div class="panel panel-info regionbox">
            <div class="panel-heading"><h4>A. Search by Name</h4></div>
            <div class="panel-body">
            <form action='{{ url('./search') }}' method="post">
            <div class="panel-heading"><h4>1. Choose The Type of Data:</h4></div>
            {{ csrf_field() }}
        	<div class="col-md-12">
                <select id="type" name="type" class="form-control">
                    <option value="gene" selected="selected">GeneID</option>
                    <option value="protein">ProteinID</option>
                    <option value="uniprot">Uniprot</option>
                </select>
                <br>
            </div>

            <h4>2. Input the gene/protein:</h4>
            <div class="col-md-12">
                <input type="text" name="query" class="form-control" placeholder="e.g. Csa4G338980"  autocomplete="on" style="width:200px; display:inline-block !important" required>&nbsp;&nbsp;
                <small>Example:
                    <a href="{{ url('search/gene/Csa4G338980') }}" id="example">Csa4G338980</a>
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
            <div class="panel-heading"><h4>B. Search by chromosome region</h4></div>
            <div class="panel-body">
                <form id="regionform" action="{{ url('./search') }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-12 form-inline">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Chr: </label>
                                <select name="chr" id="chr" class="form-control">
                                    <option value="Chr1" selected="selected">Chr1</option>
                                    <option value="Chr2">Chr2</option>
                                    <option value="Chr3">Chr3</option>
                                    <option value="Chr4">Chr4</option>
                                    <option value="Chr5">Chr5</option>
                                    <option value="Chr6">Chr6</option>
                                    <option value="Chr7">Chr7</option>
                                </select>
                            </div>
                            <input type="text" name="type" value="location" style="display: none;">
                            <div class="col-md-3">
                                <label> Start: </label>
                                <input type="number" id="start" name="start" class="form-control" min="0" placeholder=" > 0" value="14021919">
                            </div>
                            <div class="col-md-3">
                                <label>End: </label>
                                <input type="number" id="end" name="end" style="min-width: 150px" class="form-control" min="0" value="14036507">
                            </div>
                        </div>
                    </div>
                    <div class="text-center col-md-12">
                        <p></p>
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
    $('#type').change(function () {
        type = $('#type').val()

        if(type == 'protein'){
            value = 'Csa4G338980.1'
            link = '{{ url('search/protein/Csa4G338980.1') }}'
        }
        else if(type == 'uniprot'){
            value = 'A0A0A0LTV1';
            link = '{{ url('search/uniprot/A0A0A0LTV1') }}'
        }
        else {
            value = 'Csa4G338980';
            link = '{{ url('search/gene/Csa4G338980') }}'
        }
        $('#example').html(value)
        $('#example').attr('href', link);
    });

</script>
@endsection
