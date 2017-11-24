<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
        <!--
                        <li class="sidebar-search">
                            <form role="form" method="POST" action="{{ URL::to('members/search') }}" name="memberSearch" accept-charset="UTF-8"">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="input-group custom-search-form">
                                    <input disabled="disabled" name="searchKeyWords" type="text" class="form-control" placeholder="Søk i alle medlemmer...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </span>
                                </div>
                            </form>
                        </li>
                        <!-- /input-group -->
            <li>
                <a href="{{ URL::to('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-group fa-fw"></i> Medlemmer<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('members/create') }}"><i class="fa fa-user fa-fw"></i> Nytt medlem</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('members/index') }}"><i class="fa fa-th-list fa-fw"></i> Vis medlemmer</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('members/details') }}"><i class="fa fa-info-circle fa-fw"></i> Detaljer</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-list-alt fa-fw"></i> Lister <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ URL::to('members/emails') }}"><i class="fa fa-envelope fa-fw"></i> E-post</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('members/phones')}}"><i class="fa fa-phone fa-fw"></i> Telefon</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('members/print') }}"><i class="fa fa-print fa-fw"></i> Skriv ut liste</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-heart-o fa-fw"></i> Frivillige<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('volunteers/index') }}"><i class="fa fa-th-list fa-fw"></i> Frivillige</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('volunteers/quiz/index') }}"><i class="fa fa-th-list fa-fw"></i> Quizmastere</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('volunteers/uka/index') }}"><i class="fa fa-th-list fa-fw"></i> UKA-frivillige</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('volunteers/list') }}"><i class="fa fa-list-alt fa-fw"></i> Lister <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ URL::to('volunteers/list/emails') }}"><i class="fa fa-envelope fa-fw"></i> E-post</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('volunteers/list/phones')}}"><i class="fa fa-phone fa-fw"></i> Telefon</a>
                            </li>
                            {{--
                            <li>
                                <a href="{{ URL::to('volunteers/print') }}"><i class="fa fa-print fa-fw"></i> Skriv ut liste</a>
                            </li>
                            --}}
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-beer fa-fw"></i> Hemsedal<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('hemsedal/create') }}"><i class="fa fa-user fa-fw"></i> Ny påmelding</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('hemsedal') }}"><i class="fa fa-th-list fa-fw"></i> Vis påmeldte</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('hemsedal/details') }}"><i class="fa fa-info-circle fa-fw"></i> Detaljer</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-list-alt fa-fw"></i> Lister <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ URL::to('hemsedal/emails') }}"><i class="fa fa-envelope fa-fw"></i> E-post</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('hemsedal/phones')}}"><i class="fa fa-phone fa-fw"></i> Telefon</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('hemsedal/print') }}"><i class="fa fa-print fa-fw"></i> Skriv ut liste</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-mobile-phone fa-fw"></i> Send SMS<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('sms/single') }}"><i class="fa fa-user fa-fw"></i> Enkelt SMS</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('sms/members') }}"><i class="fa fa-group fa-fw"></i> Medlemmer</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('sms/volunteers') }}"><i class="fa fa-heart-o fa-fw"></i> Frivillige</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('sms/hemsedal') }}"><i class="fa fa-beer fa-fw"></i> Hemsedal</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-gears fa-fw"></i> Innstillinger<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('settings/members') }}"><i class="fa fa-group fa-fw"></i> Medlemmer</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('settings/volunteers') }}"><i class="fa fa-heart-o fa-fw"></i> Frivillige</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('settings/hemsedal') }}"><i class="fa fa-beer fa-fw"></i> Hemsedal</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('settings/users') }}"><i class="fa fa-user-plus fa-fw"></i> Brukere</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            @show
        </ul>
        </div>
    </div>
    <!-- /.sidebar-collapse -->