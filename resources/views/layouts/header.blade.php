<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="/setting" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <!-- {{--<img src="/assets/img/defaultlogo.png" alt="">{{Auth::user()->name}} --}}-->
                        <?php

                        use App\Model\company\company_logo;
                        use Illuminate\Support\Facades\Auth;

                        $logo = company_logo::where('company_id', Auth::user()->company_id)->latest()->first();
                        ?>
                        <img src="{{ url('file_logo/'.$logo->filename) }}" alt="">{{Auth::user()->name}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="/settings/company">
                                <!--<span class="badge bg-red pull-right">50%</span>-->
                                <span>Settings</span>
                            </a>
                        </li>
                        <!--<i class="cc cc-by-nc-jp"></i><li><a href="#">Help</a></li>-->
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>
                                {{ __('Logout') }}</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                <li>
                    <div class="form-group" style="margin: auto; padding: 20px">
                        <ul class="">
                            <li>
                                <a style="{{ app()->getLocale() == 'id' ? 'text-decoration: underline;font-weight: bold;' : '' }}" href="{{ route('localization.switch', 'id') }}">Indonesia</a>
                                <a> | </a>
                                <a style="{{ app()->getLocale() == 'en' ? 'text-decoration: underline;font-weight: bold;' : '' }}" href="{{ route('localization.switch', 'en') }}">English</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--<li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">6</span>
                    </i>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <span class="image"><img src="/assets/img/defaultlogo.png" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="/assets/img/defaultlogo.png" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="/assets/img/defaultlogo.png" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="/assets/img/defaultlogo.png" alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>-->
            </ul>
        </nav>
    </div>
</div>