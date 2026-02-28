<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    <!-- Logo -->
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a href="{{ route('home') }}">
            <img class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" src="assets/images/logo.svg" alt="logo" /> </a>
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center">

        <!-- Search -->
        <form class="ml-auto search-form d-none d-md-block" action="#">
            <div class="form-group">
                <input type="search" class="form-control" placeholder="Search Here">
            </div>
        </form>

        <ul class="navbar-nav ml-auto">

            <!-- Notifications -->
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator" href="#" data-bs-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count">7</span>
                </a>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">

                    <!-- Profile Image (optional default image) -->
                    <img class="img-xs rounded-circle"
                         src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                         alt="Profile image">
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown">

                    <!-- User Info -->
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle"
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                             alt="Profile image">

                        <p class="mb-1 mt-3 font-weight-semibold">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="font-weight-light text-muted mb-0">
                            {{ Auth::user()->email }}
                        </p>
                    </div>

                    <!-- Profile Link -->
                    <a href="{{ route('home') }}" class="dropdown-item">
                        My Profile
                        <i class="dropdown-item-icon ti-user"></i>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           class="dropdown-item"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            Sign Out
                            <i class="dropdown-item-icon ti-power-off"></i>
                        </a>
                    </form>

                </div>
            </li>

        </ul>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                type="button"
                data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>

    </div>
</nav>
