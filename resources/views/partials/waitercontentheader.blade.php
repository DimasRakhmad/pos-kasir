<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/waiter')}}" class="btn btn-default">
                <i class="fa fa-list"></i> Main Menu
            </a>
            <a href="{{url('auth/logout')}}" class="btn btn-default">
                <i class="fa fa-sign-out"></i> Logout
            </a>
        </li>
    </ol>
</section>