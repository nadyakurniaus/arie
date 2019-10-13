<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">General</li>
                    <li class="site-menu-item has-sub">
                        <a href="{{route('index.admin')}}">
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
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fas fa-box" aria-hidden="true"></i>
                            <span class="site-menu-title">Kelola Produk</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub" style="">
                            <li class="site-menu-item">
                                <a href="{{ route('product.index')}}">
                                    <i class="site-menu-icon " aria-hidden="true"></i>
                                    <span class="site-menu-title">Produk</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a href="/pricelist">
                                    <i class="site-menu-icon " aria-hidden="true"></i>
                                    <span class="site-menu-title">Price List Produk</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fas fa-angle-double-down" aria-hidden="true"></i>
                            <span class="site-menu-title">Kelola Order</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub" style="">
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('order.index') }}">
                                    <span class="site-menu-title">Order</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('order.list') }}">
                                    <span class="site-menu-title">Rekapitulasi Order</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                            <i class="site-menu-icon fas fa-industry" aria-hidden="true"></i>
                            <span class="site-menu-title">Kelola Produksi</span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub" style="">
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('produksi.hasil') }}">
                                    <span class="site-menu-title">Lihat Hasil Produksi</span>
                                </a>
                            </li>
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ route('produksi.index') }}">
                                    <span class="site-menu-title">Lihat Monitoring Produksi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="site-menu-item">
                        <a href="/admin/monitoringbahan">
                            <i class="site-menu-icon fas fa-clipboard-list" aria-hidden="true"></i>
                            <span class="site-menu-title">Lihat Monitoring Bahan Baku</span>
                        </a>
                    </li>
                    
                  
                    
                    <li class="site-menu-item">
                        <a href="{{ route('pengambilan.index')}}">
                            <i class="site-menu-icon fas fa-truck-loading" aria-hidden="true"></i>
                            <span class="site-menu-title">Kelola Pengambilan Barang (Produk Jadi)</span>
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
<script>
function myFunction() {
    localStorage.removeItem("metode");
    localStorage.removeItem("tanggal_produksi");
}

</script>