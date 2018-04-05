<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}"><strong> CuAS</strong></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="{{ Request::path()=='/' ? 'active':'' }}">
          <a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Home</a>
        </li>
        <li class="{{ Request::path()=='/search' ? 'active':'' }}">
          <a href="{{ url('/search') }}">&nbsp;&nbsp;Search</a>
        </li>
        <li id="tools" class="dropdown{{ ( preg_match('/tool/', Request::path()) ) ? ' active':'' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tools <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown{{ (preg_match('/blast/', Request::path() ) ? ' active':'') }}">
              <a href="{{ url('tools/blast') }}">BLAST </a>
            </li>
            <li class="dropdown{{ ( preg_match('/jbrowse/', Request::path()) ) ? ' active':'' }}">
              <a href="{{ url('tools/jbrowse') }}">JBrowse </a>
            </li>
            <li class="dropdown{{ (preg_match('/apis/', Request::path() ) ? ' active':'') }}">
              <a href="{{ url('tools/apis') }}">APIs </a>
            </li>
          </ul>
        </li>
        <li class="dropdown{{ (preg_match('/download/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('download') }}">Download </a>
        </li>
        <li id="help" class="dropdown {{ ( preg_match('/help/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('help') }}">Help </a>
        </li>
        <li id="about" class="dropdown{{ ( preg_match('/about/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('about') }}">About</a>
        </li>
        <li>
          <form id="searchall" class="navbar-form navbar-right" action="{{ url('search') }}" method="get" role="search">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="IDs, names, literatures ..." >
              <span class="input-group-btn">
                <button id="narbar-search-btn" class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
              </span>
            </div>
          </form>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
