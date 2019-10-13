<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">General</li>
                    <li class="site-menu-item has-sub">
                    <a href="{{ route('direktur') }}">
                            <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                            <span class="site-menu-title">Dashboard</span>
                            <div class="site-menu-badge">
                                {{-- <span class="tag tag-pill tag-success">3</span> --}}
                            </div>
                        </a>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fas fa-list" aria-hidden="true"></i>
                            <span class="site-menu-title">Lihat Pelaporan</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item">
                            <a class="animsition-link" href="{{route('direktur.pricelist')}}">
                                <span class="site-menu-title">Laporan Price List Produk</span>
                              </a>
                            </li>
                            <li class="site-menu-item">
                              <a class="animsition-link" href="{{route('direktur.rekaporder')}}">
                                <span class="site-menu-title">Laporan Rekapitulasi Order</span>
                              </a>
                            </li>
                            <li class="site-menu-item">
                              <a class="animsition-link" href="{{route('direktur.produksi')}}">
                                <span class="site-menu-title">Laporan Produksi</span>
                              </a>
                            </li>
                            <li class="site-menu-item">
                              <a class="animsition-link" href="{{route('direktur.ppbb')}}">
                                <span class="site-menu-title">Laporan Permintaan Pembelian BB</span>
                              </a>
                            </li>
                        </ul>
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