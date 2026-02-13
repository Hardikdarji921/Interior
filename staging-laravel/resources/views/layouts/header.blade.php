<!-- Header Section Begin -->
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('img/logo.png') }}" alt="Staging Logo"></a>
                </div>
            </div>
            <div class="col-lg-8">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about') }}">About</a>
                        </li>
                        <li class="{{ request()->routeIs('services*') ? 'active' : '' }}">
                            <a href="{{ route('services') }}">Services</a>
                        </li>
                        
                        <!-- Portfolio (Public Projects) -->
                        <li class="{{ request()->routeIs('portfolio*') ? 'active' : '' }}">
                            <a href="{{ route('portfolio') }}">Portfolio</a>
                        </li>
                        
                        <!-- Calculator Dropdown -->
                        <li class="{{ request()->routeIs('calculator*') || request()->routeIs('projects.*') ? 'active' : '' }}">
                            <a href="{{ route('calculator.index') }}">
                                <i class="fa fa-calculator mr-1"></i> Calculator
                            </a>
                            <ul class="dropdown">
                                <li><a href="{{ route('calculator.index') }}">Cost Calculator</a></li>
                                <li><a href="{{ route('calculator.category', 'paint') }}">Paint Calculator</a></li>
                                <li><a href="{{ route('calculator.category', 'furniture') }}">Furniture Estimator</a></li>
                                @auth
                                <li><a href="{{ route('projects.index') }}">My Saved Projects</a></li>
                                @endauth
                            </ul>
                        </li>
                        
                        <li class="{{ request()->routeIs('blog*') ? 'active' : '' }}">
                            <a href="{{ route('blog') }}">Blog</a>
                        </li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}">Contact</a>
                        </li>
                        
                        @auth
                        <li>
                            <a href="{{ route('projects.index') }}">
                                <i class="fa fa-folder-open"></i> My Projects
                            </a>
                        </li>
                        @endauth
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2">
                <div class="header__right">
                    <div class="header__right__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                    <div class="header__right__search">
                        <a href="#" class="search-switch"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>
<!-- Header Section End -->