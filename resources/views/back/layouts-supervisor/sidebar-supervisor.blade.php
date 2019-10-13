<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">General</li>
                    <li class="site-menu-item has-sub">
                    <a href="{{ route('index.supervisor') }}">
                            <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                            <span class="site-menu-title">Dashboard</span>
                            <div class="site-menu-badge">
                                {{-- <span class="tag tag-pill tag-success">3</span> --}}
                            </div>
                        </a>
                    </li>
                     </li>
                    <li class="site-menu-item">
                            <a href="{{ route('produksi.jadwal') }}">
                                <i class="site-menu-icon fas fa-clock" aria-hidden="true"></i>
                                <span class="site-menu-title">Kelola Jadwal Produksi</span>
                            </a>
                        </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon wb-list" aria-hidden="true"></i>
                            <span class="site-menu-title">Kelola Produksi</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub" style="">
                            <li class="site-menu-item">

                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('produksi.jadwal-spv') }}">
                            <i class="site-menu-icon " aria-hidden="true"></i>
                            <span class="site-menu-title">Tambah Produksi</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('produksi.list') }}">
                            <i class="site-menu-icon " aria-hidden="true"></i>
                            <span class="site-menu-title">Monitoring Produksi</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('produksi.hasil-spv') }}">
                            <i class="site-menu-icon " aria-hidden="true"></i>
                            <span class="site-menu-title">Hasil Produksi</span>
                        </a>
                    </li>
                </ul>

                </ul>
            </div>
        </div>
    </div>
    <div class="site-menubar-footer">
        <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Settings">
            <span class="icon wb-settings" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
            <span class="icon wb-eye-close" aria-hidden="true"></span>
        </a>
        <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
            <span class="icon wb-power" aria-hidden="true"></span>
        </a>
    </div>
</div>
