<!DOCTYPE html>
<html lang="zh-CN">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <meta name="description" content="cucumber, Germplasm, resource">
      <meta name="author" content="liubing">
      <link rel="icon" href="{{ asset('favicon.ico') }}">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ trim(config('app.name').str_replace('/', ' > ', Request::getRequestUri()),' > ') }}</title>

      <!-- 新 Bootstrap 核心 CSS 文件 -->
      {{-- <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

      <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
      {{-- <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script> --}}
      <script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>

      <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
      {{-- <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      <!-- Font Awesome 自动加载文件  -->
      {{-- <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"> --}}
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

      <!-- Auto hide navbar -->
      <script src="{{ asset('js/jquery.bootstrap-autohidingnavbar.min.js') }}"></script>

      <!-- Buttons -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.css') }}">

      <!-- Custom styles for this template -->
      <link href="{{ asset('css/customize.css') }}" rel="stylesheet">

      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Scripts -->
      <script>
          window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
]); ?>
      </script>
      @yield('css')
  </head>
  <body>

    @yield('navbar')

    @yield('content')

    @yield('footer')

  </body>
    @yield('js')
</html>
