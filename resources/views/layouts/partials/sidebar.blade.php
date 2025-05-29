<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="index.html"><img src="{{ asset('assets/images/icon/logo.png')}}" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu" style="padding:0px;">
                    <li class="active"><a href="maps.html"><i class="ti-dashboard"></i><span>dashboard</span></a></li>
                    <li >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>Member Management</span></a>

                        <ul class="collapse">
                            <li ><a href="#">Registration</a></li>
                            <li><a href="{{route('admin.associators-info.index')}}">Associators Info</a></li>

                            <li >
                                <a href="javascript:void(0)" aria-expanded="true"><span>Update</span></a>
                                <ul class="collapse">
                                    <li ><a href="#">Profile</a></li>
                                    <li><a href="{{route('admin.approval.list')}}">Approval</a></li>

                                </ul>
                            </li>

                            <li >
                                <a href="javascript:void(0)" aria-expanded="true"><span>Report</span></a>
                                <ul class="collapse">
                                    <li ><a href="index.html">Member List</a></li>

                                </ul>
                            </li>


                        </ul>
                    </li>
                    {{-- <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>Sidebar
                                Types
                            </span></a>
                        <ul class="collapse">
                            <li><a href="index.html">Left Sidebar</a></li>
                            <li><a href="index3-horizontalmenu.html">Horizontal Sidebar</a></li>
                        </ul>
                    </li> --}}

                </ul>
            </nav>
        </div>
    </div>
</div>
