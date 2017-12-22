<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Søk...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGASJON</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview {{ (Request::is('members*') ? 'active' : '') }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Medlemmer</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li {{ (Request::is('members') ? 'class=active' : '') }}><a href="{{ Route('members.index') }}"><i class="fa fa-circle-o"></i> Vis medlemmer</a></li>
                    <li {{ (Request::is('members/create') ? 'class=active' : '') }}><a href="{{ Route('members.create') }}"><i class="fa fa-circle-o"></i> Nytt medlem</a></li>
                    <li {{ (Request::is('members/details') ? 'class=active' : '') }}><a href="{{ Route('members.details') }}"><i class="fa fa-circle-o"></i> Detaljer</a></li>
                    <li {{ (Request::is('members/sms') ? 'class=active' : '') }}><a href="{{ Route('members.sms') }}"><i class="fa fa-circle-o"></i> Send SMS</a></li>
                    <li class="treeview {{ (Request::is('members/lists/*') ? 'active' : '') }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Lister
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {{ (Request::is('members/lists/phones') ? 'class=active' : '') }}><a href="{{ Route('members.phones') }}"><i class="fa fa-circle-o"></i> Telefonliste</a></li>
                            <li {{ (Request::is('members/lists/emails') ? 'class=active' : '') }}><a href="{{ Route('members.emails') }}"><i class="fa fa-circle-o"></i> E-postliste</a></li>
                            <li {{ (Request::is('members/lists/print') ? 'class=active' : '') }}><a href="{{ Route('members.print') }}"><i class="fa fa-circle-o"></i> Skriv ut</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ (Request::is('volunteers*') ? 'active' : '') }}">
                <a href="#">
                    <i class="fa fa-heart"></i> <span>Frivillige</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview {{ (Request::is('volunteers/campuslan/*') ? 'active' : '') }}">
                        <a href="#"><i class="fa fa-circle-o"></i> CampusLAN
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {{ (Request::is('volunteers/campuslan') ? 'class=active' : '') }}><a href="{{ Route('volunteers.index') }}"><i class="fa fa-circle-o"></i> Vis frivillige</a></li>
                            <li {{ (Request::is('volunteers/campuslan/create') ? 'class=active' : '') }}><a href="{{ Route('volunteers.create') }}"><i class="fa fa-circle-o"></i> Ny frivillig</a></li>
                            <li {{ (Request::is('volunteers/campuslan/sms') ? 'class=active' : '') }}><a href="{{ Route('volunteers.sms') }}"><i class="fa fa-circle-o"></i> Send SMS</a></li>
                            <li class="treeview {{ (Request::is('volunteers/campuslan/lists/*') ? 'active' : '') }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Lister
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li {{ (Request::is('volunteers/campuslan/lists/phones') ? 'class=active' : '') }}><a href="{{ Route('volunteers.phones') }}"><i class="fa fa-circle-o"></i> Telefonliste</a></li>
                                    <li {{ (Request::is('volunteers/campuslan/lists/emails') ? 'class=active' : '') }}><a href="{{ Route('volunteers.emails') }}"><i class="fa fa-circle-o"></i> E-postliste</a></li>
                                    <li {{ (Request::is('volunteers/campuslan/lists/print') ? 'class=active' : '') }}><a href="{{ Route('volunteers.print') }}"><i class="fa fa-circle-o"></i> Skriv ut</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview {{ (Request::is('volunteers/quiz*') ? 'active' : '') }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Quizmastere
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {{ (Request::is('volunteers/quiz') ? 'class=active' : '') }}><a href="{{ Route('quiz.index') }}"><i class="fa fa-circle-o"></i> Vis quizmastere</a></li>
                            <li {{ (Request::is('volunteers/quiz/create') ? 'class=active' : '') }}><a href="{{ Route('quiz.create') }}"><i class="fa fa-circle-o"></i> Ny quizmaster</a></li>
                            <li {{ (Request::is('volunteers/quiz/sms') ? 'class=active' : '') }}><a href="{{ Route('quiz.sms') }}"><i class="fa fa-circle-o"></i> Send SMS</a></li>
                            <li class="treeview {{ (Request::is('volunteers/quiz/lists/*') ? 'active' : '') }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Lister
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li {{ (Request::is('volunteers/quiz/lists/phones') ? 'class=active' : '') }}><a href="{{ Route('quiz.phones') }}"><i class="fa fa-circle-o"></i> Telefonliste</a></li>
                                    <li {{ (Request::is('volunteers/quiz/lists/emails') ? 'class=active' : '') }}><a href="{{ Route('quiz.emails') }}"><i class="fa fa-circle-o"></i> E-postliste</a></li>
                                    <li {{ (Request::is('volunteers/quiz/lists/print') ? 'class=active' : '') }}><a href="{{ Route('quiz.print') }}"><i class="fa fa-circle-o"></i> Skriv ut</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview {{ (Request::is('volunteers/studiestart*') ? 'active' : '') }}">
                        <a href="#"><i class="fa fa-circle-o"></i> Studiestart
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {{ (Request::is('volunteers/studiestart') ? 'class=active' : '') }}><a href="{{ Route('volunteers.index') }}"><i class="fa fa-circle-o"></i> Vis frivillige</a></li>
                            <li {{ (Request::is('volunteers/studiestart/create') ? 'class=active' : '') }}><a href="{{ Route('volunteers.create') }}"><i class="fa fa-circle-o"></i> Ny frivillig</a></li>
                            <li {{ (Request::is('volunteers/studiestart/sms') ? 'class=active' : '') }}><a href="{{ Route('volunteers.sms') }}"><i class="fa fa-circle-o"></i> Send SMS</a></li>
                            <li class="treeview {{ (Request::is('volunteers/studiestart/lists/*') ? 'active' : '') }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Lister
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li {{ (Request::is('volunteers/studiestart/lists/phones') ? 'class=active' : '') }}><a href="{{ Route('volunteers.phones') }}"><i class="fa fa-circle-o"></i> Telefonliste</a></li>
                                    <li {{ (Request::is('volunteers/studiestart/lists/emails') ? 'class=active' : '') }}><a href="{{ Route('volunteers.emails') }}"><i class="fa fa-circle-o"></i> E-postliste</a></li>
                                    <li {{ (Request::is('volunteers/studiestart/lists/print') ? 'class=active' : '') }}><a href="{{ Route('volunteers.print') }}"><i class="fa fa-circle-o"></i> Skriv ut</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview {{ (Request::is('volunteers/uka*') ? 'active' : '') }}">
                        <a href="#"><i class="fa fa-circle-o"></i> UKA
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {{ (Request::is('volunteers/uka') ? 'class=active' : '') }}><a href="{{ Route('uka.index') }}"><i class="fa fa-circle-o"></i> Vis frivillige</a></li>
                            <li {{ (Request::is('volunteers/uka/create') ? 'class=active' : '') }}><a href="{{ Route('uka.create') }}"><i class="fa fa-circle-o"></i> Ny frivillig</a></li>
                            <li {{ (Request::is('volunteers/uka/sms') ? 'class=active' : '') }}><a href="{{ Route('uka.sms') }}"><i class="fa fa-circle-o"></i> Send SMS</a></li>
                            <li class="treeview {{ (Request::is('volunteers/uka/lists/*') ? 'active' : '') }}">
                                <a href="#"><i class="fa fa-circle-o"></i> Lister
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li {{ (Request::is('volunteers/uka/lists/phones') ? 'class=active' : '') }}><a href="{{ Route('uka.phones') }}"><i class="fa fa-circle-o"></i> Telefonliste</a></li>
                                    <li {{ (Request::is('volunteers/uka/lists/emails') ? 'class=active' : '') }}><a href="{{ Route('uka.emails') }}"><i class="fa fa-circle-o"></i> E-postliste</a></li>
                                    <li {{ (Request::is('volunteers/uka/lists/print') ? 'class=active' : '') }}><a href="{{ Route('uka.print') }}"><i class="fa fa-circle-o"></i> Skriv ut</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ (Request::is('hemsedal*') ? 'active' : '') }}">
                <a href="#">
                    <i class="fa fa-snowflake-o"></i> <span>Skitur</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li {{ (Request::is('hemsedal') ? 'class=active' : '') }}><a href="{{ Route('hemsedal.index') }}"><i class="fa fa-circle-o"></i> Vis påmeldte</a></li>
                    <li {{ (Request::is('hemsedal/create') ? 'class=active' : '') }}><a href="{{ Route('hemsedal.create') }}"><i class="fa fa-circle-o"></i> Ny påmelding</a></li>
                    <li {{ (Request::is('hemsedal/details') ? 'class=active' : '') }}><a href="{{ Route('hemsedal.details') }}"><i class="fa fa-circle-o"></i> Detaljer</a></li>
                    <li {{ (Request::is('hemsedal/sms') ? 'class=active' : '') }}><a href="{{ Route('hemsedal.sms') }}"><i class="fa fa-circle-o"></i> Send SMS</a></li>
                    <li {{ (Request::is('hemsedal/print') ? 'class=active' : '') }}><a href="{{ Route('hemsedal.print') }}"><i class="fa fa-circle-o"></i> Skriv ut lister</a></li>
                </ul>
            </li>
            <li class="treeview {{ (Request::is('settings/*') ? 'active' : '') }}">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Innstillinger</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li {{ (Request::is('settings/members') ? 'class=active' : '') }}><a href="{{ Route('settings.members') }}"><i class="fa fa-circle-o"></i> Medlemmer</a></li>
                    <li {{ (Request::is('settings/volunteers') ? 'class=active' : '') }}><a href="{{ Route('settings.volunteers') }}"><i class="fa fa-circle-o"></i> Frivillige</a></li>
                    <li {{ (Request::is('settings/hemsedal') ? 'class=active' : '') }}><a href="{{ Route('settings.hemsedal') }}"><i class="fa fa-circle-o"></i> Skitur</a></li>
                    <li {{ (Request::is('settings/users') ? 'class=active' : '') }}><a href="{{ Route('settings.users') }}"><i class="fa fa-circle-o"></i> Brukere</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>