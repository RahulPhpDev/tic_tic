<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin/home') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            {{trans('tictic/title.title')}}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          {{trans('tictic/title.title')}}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        @can('team_select')
            {!! Form::open(['method' => 'POST', 'url' => route('admin.team-select.select'), 'id' => 'navbar__select-team-form']) !!}
            {!! Form::hidden('redirect', 'back') !!}
            {!! Form::select('team_id', Auth::user()->teams->pluck('name', 'id'), session('team_id'), ['class' => 'select2', 'id' => 'navbar__select-team']) !!}
            {!! Form::close() !!}
        @endif

    </nav>
</header>


