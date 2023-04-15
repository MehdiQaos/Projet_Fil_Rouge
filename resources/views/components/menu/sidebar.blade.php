<div class="bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
            class="fa-solid fa-bowl-food me-2"></i>Bistro</div>
    <div>
        <div class="list-group list-group-flush my-3">
            {{-- <a href="/" name="dashboard" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-tachometer-alt me-2"></i>Dashboard</a> --}}
            <a href="/dishes/manage" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-utensils me-2"></i>list dishes</a>
            <a href="/users/manage" name="listusers" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-users me-2"></i>list users</a>
            <a href="/dishes/add" name="addbook" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                    class="fas fa-plus me-2"></i>Add Dish</a>
        </div>
    </div>
    <a href="/logout" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
            class="fas fa-power-off me-2"></i>Logout</a>
</div>