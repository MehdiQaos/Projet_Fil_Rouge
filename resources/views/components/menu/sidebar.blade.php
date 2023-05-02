<div class="bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
            class="fa-solid fa-chess me-2"></i>My Chess</div>
    <div>
        <div class="list-group list-group-flush my-3">
        @auth
            <a href="/find" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-chess-pawn me-2"></i>Find game</a>
            <a href="/custom" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-chess-queen me-2"></i>Custom game</a>
            <a href="/games" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-chess-knight me-2"></i>My games</a>
            @if (auth()->user()->isAdmin())
            <a href="/users" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-users me-2"></i>Users</a>
            @endif
        @endauth
        </div>
    </div>
    @auth
    <a href="/logout" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
            class="fas fa-power-off me-2"></i>Logout</a>
    @endauth
</div>