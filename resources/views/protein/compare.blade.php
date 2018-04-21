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
<div class="container-fluid content">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">ssss</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">14</span>
                            Cras justo odio
                    </li>
                </ul>
                <div class="panel-footer">Panel footer</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">ssss</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">14</span>
                            Cras justo odio
                    </li>
                </ul>
                <div class="panel-footer">Panel footer</div>
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
    var proteins = '{!! $proteins !!}';

</script>
@endsection
