<!-- Brand Logo -->
<a href="#" class="brand-link mx-auto" style="text-align: center; max-width:120px">
    <img src="{{ asset('storage/images/logo.jpeg') }}" alt="BCSSL Logo"
        class="img-circle img-fluid img-responsive elevation-3" style="opacity: .8">

</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

            {{-- dashboard --}}
            @can('Deashboard View')
                <li class="nav-item ">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
            @endcan
            {{-- Member Management --}}
            @canany(['Registration Add', 'Associators Info View', 'Associators Info Edit', 'Profile Approval View',
                'Profile Approval Edit', 'Member List View', 'Member List Edit', 'Profile Update View'])
                <li
                    class="nav-item {{ in_array(\Request::route()->getName(), ['admin.member.registration', 'admin.associators-info.index', 'admin.approval.list', 'admin.report.member.list', 'admin.report.member.edit', 'admin.updated.profiles.list']) ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link {{ in_array(\Request::route()->getName(), ['admin.member.registration', 'admin.associators-info.index', 'admin.approval.list', 'admin.report.member.list', 'admin.updated.profiles.list']) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-xs fa-users" style="font-size:.875em"></i>
                        <p>
                            Member Management
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Registration Add')
                            <li class="nav-item ">
                                <a href="{{ route('admin.member.registration') }}"
                                    class="nav-link {{ Route::is('admin.member.registration') ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Registration</p>
                                </a>
                            </li>
                        @endcan
                        @can('Associators Info View')
                            <li class="nav-item">
                                <a href="{{ route('admin.associators-info.index') }}"
                                    class="nav-link {{ Route::is('admin.associators-info.index') ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Associators Info</p>
                                </a>
                            </li>
                        @endcan
                        <li
                            class="nav-item {{ Route::is('admin.approval.list') || Route::is('admin.updated.profiles.list') ? 'menu-open' : '' }}">
                            <a href="./index2.html"
                                class="nav-link {{ Route::is('admin.approval.list') || Route::is('admin.updated.profiles.list') ? 'active' : '' }}"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Update</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview ">
                                @can('Profile Update View')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.updated.profiles.list') }}"
                                            class="nav-link {{ Route::is('admin.updated.profiles.list') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Profile</p>
                                        </a>
                                    </li>
                                @endcan

                                @can('Profile Approval View')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.approval.list') }}"
                                            class="nav-link {{ Route::is('admin.approval.list') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Approval</p>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.report.*') ? 'menu-open' : '' }}">
                            <a href="./index3.html"
                                class="nav-link {{ request()->routeIs('admin.report.*') ? 'active' : '' }}"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Report</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('Member List View')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.report.member.list') }}"
                                            class="nav-link {{ request()->routeIs('admin.report.member.*') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Member List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.report.suspended.list') }}"
                                            class="nav-link {{ request()->routeIs('admin.report.suspended.list') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Suspended List</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </li>
            @endcanany
            {{-- Fee Management --}}
            @canany(['Fee Setup View', 'Fee Setup Add', 'Fee Assign View', 'Fee Assign Add', 'Fee Collection View',
                'Quick Collection View', 'Quick Collection Add', 'Quick Collection Invoices View', 'Payment Approval View',
                'Payment Approval Edit'])
                <li
                    class="nav-item {{ in_array(\Request::route()->getName(), ['admin.fees.index', 'admin.fees.assign', 'admin.fees.collections', 'admin.payment.list', 'admin.report.paid.info', 'admin.report.due.info', 'fees.quick.collection']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(\Request::route()->getName(), ['admin.fees.index', 'admin.fees.assign', 'admin.fees.collections', 'admin.payment.list', 'admin.report.paid.info', 'admin.report.due.info', 'fees.quick.collection']) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-xs fa-solid fa-receipt" style="font-size:.875em"></i>
                        <p>
                            Fees Management
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Fee Setup View')
                            <li class="nav-item">
                                <a href="{{ route('admin.fees.index') }}"
                                    class="nav-link {{ Route::is('admin.fees.index') ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Fee Setup</p>
                                </a>
                            </li>
                        @endcan
                        @can('Fee Assign View')
                            <li class="nav-item">
                                <a href="{{ route('admin.fees.assign') }}"
                                    class="nav-link {{ Route::is('admin.fees.assign') ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Fee Assign</p>
                                </a>
                            </li>
                        @endcan
                        @can('Fee Collection View')
                            <li class="nav-item">
                                <a href="{{ route('admin.fees.collections') }}"
                                    class="nav-link {{ Route::is('admin.fees.collections') ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Fee Collection</p>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-item {{ Route::is('admin.payment.list') ? 'menu-open' : '' }}">
                            <a href="./index2.html" class="nav-link {{ Route::is('admin.payment.list') ? 'active' : '' }}"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Update</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('Payment Approval View')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.payment.list') }}"
                                            class="nav-link  {{ Route::is('admin.payment.list') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Approval</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('admin.payment.complete.list') }}"
                                            class="nav-link  {{ Route::is('admin.payment.complete.list') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Completed Payment</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('admin.payment.suspend.list') }}"
                                            class="nav-link  {{ Route::is('admin.payment.suspend.list') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Suspended Payment</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('Profile Approval Edit')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.fine.adjust') }}"
                                            class="nav-link {{ Route::is('admin.fine.adjust') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Fine Adjust</p>
                                        </a>
                                    </li>
                                @endcan;
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ Route::is('admin.report.due.info') || Route::is('admin.report.paid.info') ? 'menu-open' : '' }}">
                            <a href="./index3.html"
                                class="nav-link {{ Route::is('admin.report.due.info') || Route::is('admin.report.paid.info') ? 'active' : '' }}"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                <p>Report</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item">
                                    <a href="./index.html" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Datewise Summary</p>
                                    </a>
                                </li> --}}
                                @canany(['Paid Info Report View', 'Paid Info Report Invoice View'])
                                    <li
                                        class="nav-item {{ Route::is('admin.report.due.info') || Route::is('admin.report.paid.info') ? 'menu-open' : '' }}">
                                        <a href="./index2.html"
                                            class="nav-link {{ Route::is('admin.report.due.info') || Route::is('admin.report.paid.info') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Details</p>
                                            <i class="right fas fa-angle-left"
                                                style="font-size:.875em; line-height:1.5em;"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('Paid Info Report View')
                                                <li class="nav-item">
                                                    <a href="{{ route('admin.report.paid.info') }}"
                                                        class="nav-link {{ Route::is('admin.report.paid.info') ? 'active' : '' }}"
                                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                                        <p>Paid Info</p>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('Paid Info Report View')
                                                <li class="nav-item">
                                                    <a href="{{ route('admin.report.memberwise.paid.info') }}"
                                                        class="nav-link {{ Route::is('admin.report.memberwise.paid.info') ? 'active' : '' }}"
                                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                                        <p>Memberwise Paid Info</p>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('Due Info Report View')
                                                <li class="nav-item">
                                                    <a href="{{ route('admin.report.due.info') }}"
                                                        class="nav-link {{ Route::is('admin.report.due.info') ? 'active' : '' }}"
                                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                                        <p>Active Due Info</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('admin.report.suspended.due.info') }}"
                                                        class="nav-link {{ Route::is('admin.report.suspended.due.info') ? 'active' : '' }}"
                                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                                        <p>Suspended Due Info</p>
                                                    </a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcanany
                            </ul>
                        </li>

                    </ul>
                </li>
            @endcanany
            {{-- Account Management --}}
            @canany([
                'Create Ledger View',
                'Create Ledger Add',
                // 'Profile Update View',
                'Profile Update Add',
                ])
                <li
                    class="nav-item {{ in_array(\Request::route()->getName(), ['admin.ledger.index']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(\Request::route()->getName(), ['admin.ledger.index']) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-xs fa-sharp fa-solid fa-bookmark" style="font-size:.875em"></i>
                        <p>
                            Account Management
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Create Ledger View')
                            <li
                                class="nav-item {{ in_array(\Request::route()->getName(), ['admin.ledger.index']) ? 'menu-open' : '' }}">
                                <a href="./index.html"
                                    class="nav-link {{ in_array(\Request::route()->getName(), ['admin.ledger.index']) ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Setup</p>
                                    <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ route('admin.ledger.index') }}"
                                            class="nav-link {{ Route::is('admin.ledger.index') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Create Ledger</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="./index.html" class="nav-link"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Voucher Entry</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('admin.voucher.entry.payment') }}" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Payment</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.voucher.entry.receipt') }}" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Receipt</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Contra</p>
                                </a>
                            </li> --}}
                                {{-- <li class="nav-item">
                                <a href="{{route('admin.voucher.entry.journal')}}" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Journal</p>
                                </a>
                            </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Core Report</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Balance Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Trial Balance</p>
                                </a>
                            </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route('admin.core-report.income-statement') }}" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Income Statement</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Cash Summary</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Cash Flow Statement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Chart of Accounts</p>
                                </a>
                            </li> --}}
                            </ul>
                        </li>
                        {{-- @can('Profile Update View') --}}
                        <li class="nav-item">
                            <a href="./index2.html" class="nav-link"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Update</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.voucher.index') }}" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Voucher Requests</p>
                                    </a>
                                </li>

                                {{-- <li class="nav-item">
                                <a href="#" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Approval</p>
                                </a>
                            </li> --}}
                            </ul>
                        </li>
                        {{-- @endcan --}}

                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                <p>Transaction Report</p>
                                <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.voucherwise.report') }}" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Voucher Wise</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="./index2.html" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>User Wise</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./index3.html" class="nav-link"
                                        style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                        <p>Ledger Wise</p>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                    </ul>
                </li>
            @endcan
            {{-- SMS --}}
            <li class="nav-item">
                <a href="#" class="nav-link ">
                    <i class="nav-icon fa fa-xs fa-solid fa-envelope" style="font-size:.875em"></i>
                    <p>
                        SMS
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                            <p>Create</p>
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.sms.temp.index') }}" class="nav-link"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Template</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                            <p>Send</p>
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.member.sms.index') }}" class="nav-link"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                    <p>Memeber Wise</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.notificationSms') }}" class="nav-link"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Notification Wise</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sms.purchase.index') }}" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                            <p>Recharge</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                            <p>Report</p>
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.smsReport') }}" class="nav-link"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                    <p>Details</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Layout & Certificate --}}
            <li class="nav-item">
                <a href="#" class="nav-link ">
                    <i class="nav-icon fa fa-xs fa-solid fa-layer-group" style="font-size:.875em"></i>
                    <p>
                        Layouts
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.layout.member.list.fetch') }}" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Certificate and ID card</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.layout.signature') }}" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Signatures</p>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- Core Setting --}}
            @canany(['Roles View', 'Roles Add', 'Roles Edit', 'Roles Delete', 'Users View', 'Users Add', 'Users Edit',
                'Users Delete'])
                <li
                    class="nav-item {{ in_array(\Request::route()->getName(), ['admin.roles.index', 'admin.users.create', 'admin.users.index', 'admin.users.edit', 'admin.settings.index']) ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ in_array(\Request::route()->getName(), ['admin.roles.index', 'admin.users.create', 'admin.users.index', 'admin.users.edit']) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-xs fa-solid fa-wrench" style="font-size:.875em"></i>
                        <p>
                            Core Setting
                            <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('Roles View')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ Route::is('admin.roles.index') ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                    <p>Roles</p>
                                </a>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                                class="nav-link {{ Route::is('admin.settings.index') ? 'active' : '' }}"
                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                <p>Organization Info</p>
                            </a>
                        </li>

                        @canany(['Users View', 'Users Add', 'Users Edit', 'Users Delete'])
                            <li
                                class="nav-item {{ in_array(\Request::route()->getName(), ['admin.users.create', 'admin.users.index', 'admin.users.edit']) ? 'menu-open' : '' }}">
                                <a href="./index2.html"
                                    class="nav-link {{ in_array(\Request::route()->getName(), ['admin.users.create', 'admin.users.index', 'admin.users.edit']) ? 'active' : '' }}"
                                    style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                    <p>User Assign</p>
                                    <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('Users View')
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.create') }}"
                                                class="nav-link {{ Route::is('admin.users.create') ? 'active' : '' }}"
                                                style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                                <p>User Add</p>
                                            </a>
                                        </li>
                                    @endcan

                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}"
                                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                                            <p>User List</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endcanany
            {{-- Helpline --}}
            <li class="nav-item">
                <a href="#" class="nav-link ">
                    <i class="nav-icon fa fa-xs fa-solid fa-headset" style="font-size:.875em"></i>
                    <p>
                        Helpline
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link"
                            style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">

                            <p>Support Token</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
