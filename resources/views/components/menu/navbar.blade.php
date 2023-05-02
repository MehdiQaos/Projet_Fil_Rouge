<nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
    {{-- @if(auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'superadmin') --}}
        <div class="d-flex align-items-center">
            <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
        </div>
    {{-- @endif --}}
        <a href="/" class="d-flex align-items-center">
            <i class="fas fa-house primary-text fs-4 me-3"></i>
        </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="true" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user me-2"></i>
                    @auth
                        {{auth()->user()->user_name}}
                    @else
                        Guest
                    @endauth
                    {{-- piq --}}
                </a>
                @auth
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/profile">Profile</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
                @endauth
            </li>
        </ul>
    </div>
</nav>
<!-- notifications -->
<!-- end notifications -->