<!-- Brand Logo -->
<a href="index3.html" class="brand-link" style="text-align: center">
    {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
    <span class="brand-text font-weight-light">Assoc</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div> --}}

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
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" >
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

            {{-- dashboard --}}
            <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            {{-- Member Management --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-users" style="font-size:.875em"></i>
                    <p>
                        Member Management
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('register.index')}}" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Registration</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('assoc.index')}}" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Associators Info</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Update</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('approval.index')}}" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Approval</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Report</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Member List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Fee Management --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-solid fa-receipt" style="font-size:.875em"></i>
                    <p>
                        Fees Management
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('fees.index')}}" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Fee Setup</p>
                        </a>
                    </li>                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Fee Collection</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>Report</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Summery</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Detais</p>
                                    <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Paid Info</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                            <p>Due Info</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Account Management --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-sharp fa-solid fa-bookmark" style="font-size:.875em"></i>
                    <p>
                        Account Management
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Setup</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('ledger.index')}}" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Create Ledger</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Voucher Entry</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Payment</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Receipt</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Contra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Journal</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Core Report</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Balance Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Trial Balance</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Income Statement</p>
                                </a>
                            </li>
                            <li class="nav-item">
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
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            <p>Transaction Report</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Voucher Wise</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>User Wise</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    <p>Ledger Wise</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- SMS --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-solid fa-envelope" style="font-size:.875em"></i>
                    <p>
                        SMS
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>Create</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>Template</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>Send</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>Memeber Wise</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>Notification Wise</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>Recharge</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index3.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>Report</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>Summery</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>Details</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Layout & Certificate --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-solid fa-layer-group" style="font-size:.875em"></i>
                    <p>
                        Certificate
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em"></i>
                    </p>
                </a>
            </li>
            {{-- Core Setting --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-solid fa-wrench" style="font-size:.875em"></i>
                    <p>
                        Core Setting
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>Organization Info</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
                            <p>User Assign</p>
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>User Add</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index2.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                                    
                                    <p>User List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Helpline --}}
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fa fa-xs fa-solid fa-headset" style="font-size:.875em"></i>
                    <p>
                        Helpline
                        <i class="right fas fa-angle-left" style="font-size:.875em; line-height:1.5em;"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link" style="border-left:2px solid rgba(142, 190, 249, 0.631372549); border-radius:0; margin:0">
                            
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
