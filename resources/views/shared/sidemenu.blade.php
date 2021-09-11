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
            <i class="fas fa-fw fa-book {{strtolower($data['category_name']) === 'books' ? 'text-warning': '' }}"></i>
            <span class="{{strtolower($data['category_name']) === 'books' ? 'font-weight-bold text-white': '' }}">{{trans('common.books_label')}}</span>
        </a>
        <div id="collapseTwo" class="collapse {{strtolower($data['category_name']) === 'books' ? 'show': '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('books.index') }}">
                    <i class="fa fa-book mr-1 text-primary"></i>
                    {{trans('common.books_label')}}
                </a>
                <a class="collapse-item" href="{{ route('books.copies.index') }}">
                    <i class="fa fa-book mr-1 text-primary"></i>
                    {{trans('common.book_copies_label')}}
                </a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembers" aria-expanded="true" aria-controls="collapseMembers">
            <i class="fas fa-fw fa-users {{strtolower($data['category_name']) === 'members' ? 'text-warning': '' }}"></i>
            <span class="{{strtolower($data['category_name']) === 'members' ? 'font-weight-bold text-white': '' }}">{{trans('common.members_label')}}</span>
        </a>
        <div id="collapseMembers" class="collapse {{strtolower($data['category_name']) === 'members' ? 'show': '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('requests.index') }}">
                    <i class="fa fa-user-plus mr-1 text-primary"></i>
                    <span style="font-size: 0.85rem">{{trans('common.members_applications_label')}}</span>
                </a>
                <a class="collapse-item" href="{{ route('members.index') }}">
                    <i class="fa fa-users mr-1 text-primary"></i>
                    {{trans('common.members_label')}}
                </a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLoans" aria-expanded="true" aria-controls="collapseLoans">
            <i class="fas fa-fw fa-book {{strtolower($data['category_name']) === 'loans' ? 'text-warning': '' }}"></i>
            <span class="{{strtolower($data['category_name']) === 'loans' ? 'font-weight-bold text-white': '' }}">{{trans('common.loans_label')}}</span>
        </a>
        <div id="collapseLoans" class="collapse {{strtolower($data['category_name']) === 'loans' ? 'show': '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('loans.index') }}">
                    <i class="fa fa-users mr-1 text-primary"></i>
                    {{trans('common.loans_label')}}
                </a>

                <a class="collapse-item" href="#">
                    <i class="fa fa-business-time mr-1 text-primary"></i>
                    {{trans('common.holds_label')}}
                </a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinance" aria-expanded="true" aria-controls="collapseFinance">
            <i class="fas fa-fw fa-dollar-sign {{strtolower($data['category_name']) === 'finance' ? 'text-warning': '' }}"></i>
            <span class="{{strtolower($data['category_name']) === 'finance' ? 'font-weight-bold text-white': '' }}">{{trans('common.finance_label')}}</span>
        </a>
        <div id="collapseFinance" class="collapse {{strtolower($data['category_name']) === 'finance' ? 'show': '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('invoices.index') }}">
                    <i class="fa fa-file-invoice-dollar mr-1 text-primary"></i>
                    {{trans('common.invoices_label')}}
                </a>
                <a class="collapse-item" href="{{ route('payments.index') }}">
                    <i class="fa fa-hand-holding-usd mr-1 text-primary"></i>
                    {{trans('common.payments_label')}}
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig">
            <i class="fas fa-fw fa-cogs {{strtolower($data['category_name']) === 'config' ? 'text-warning': '' }}"></i>
            <span class="{{strtolower($data['category_name']) === 'config' ? 'font-weight-bold text-white': '' }}">{{trans('common.config_label')}}</span>
        </a>
        <div id="collapseConfig" class="collapse {{strtolower($data['category_name']) === 'config' ? 'show': '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('category.index') }}">
                    <i class="fa fa-address-book mr-1 text-primary"></i>
                    {{trans('common.categories_label')}}
                </a>
                <a class="collapse-item" href="{{ route('authors.index') }}">
                    <i class="fa fa-user-tie mr-1 text-primary"></i>
                    {{trans('common.authors_label')}}
                </a>
                <a class="collapse-item" href="{{ route('pricing.index') }}">
                    <i class="fa fa-money-bill mr-1 text-primary"></i>
                    {{trans('common.pricings_label')}}
                </a>
            </div>
        </div>
    </li>



    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
