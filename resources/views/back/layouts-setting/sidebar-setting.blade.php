<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">General</li>
                    <li class="site-menu-item has-sub">
                    <a href="{{ route('index.setting') }}">
                            <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                            <span class="site-menu-title">Dashboard</span>
                            <div class="site-menu-badge">
                                {{-- <span class="tag tag-pill tag-success">3</span> --}}
                            </div>
                        </a>
                        {{-- <ul class="site-menu-sub">
                            <li class="site-menu-item active">
                                <a class="animsition-link" href="javascript:void(0)">
                                <span class="site-menu-title">Dashboard v1</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="javascript:void(0)">
                                <span class="site-menu-title">Dashboard v2</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="javascript:void(0)">
                                <span class="site-menu-title">Ecommerce</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="javascript:void(0)">
                                <span class="site-menu-title">Analytics</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="javascript:void(0)">
                                <span class="site-menu-title">Team</span>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    <li class="site-menu-item">
                        <a href="{{ route('setting.index') }}">
                            <i class="site-menu-icon wb-pluse" aria-hidden="true"></i>
                            <span class="site-menu-title">Kelola Desain Order</span>
                        </a>
                    </li>
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