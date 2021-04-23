<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-book fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-2">Library Admin</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>
            <span>Books</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('books.index') }}">
                    <i class="fa fa-book mr-1 text-primary"></i>
                    Books
                </a>
                <a class="collapse-item" href="{{ route('books.copies.index') }}">
                    <i class="fa fa-book mr-1 text-primary"></i>
                    Book Copies
                </a>
                <a class="collapse-item" href="{{ route('authors.index') }}">
                    <i class="fa fa-user-tie mr-1 text-primary"></i>
                    Authors
                </a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLoans" aria-expanded="true" aria-controls="collapseLoans">
            <i class="fas fa-fw fa-book"></i>
            <span>Members</span>
        </a>
        <div id="collapseLoans" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('members.index') }}">
                    <i class="fa fa-users mr-1 text-primary"></i>
                    Members
                </a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembers" aria-expanded="true" aria-controls="collapseMembers">
            <i class="fas fa-fw fa-book"></i>
            <span>Loans</span>
        </a>
        <div id="collapseMembers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">
                    <i class="fa fa-users mr-1 text-primary"></i>
                    Loans
                </a>

                <a class="collapse-item" href="#">
                    <i class="fa fa-bookmark mr-1 text-primary"></i>
                    Holds
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Config</span>
        </a>
        <div id="collapseConfig" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('category.index') }}">
                    <i class="fa fa-address-book mr-1 text-primary"></i>
                    Categories
                </a>
            </div>
        </div>
    </li>



    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
