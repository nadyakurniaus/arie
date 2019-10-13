<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
  <div class="navbar-header">
    <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
      <img class="navbar-brand-logo" src="{{ asset('global/assets/images/logo.png') }}"
        title="Arie | Percetakan Digital">

      <span class="navbar-brand-text hidden-xs-down">Arie | Percetakan</span>
    </div>
    </button>
  </div>
  <div class="navbar-container container-fluid">
    <!-- Navbar Collapse -->
    <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
      <!-- Navbar Toolbar -->
      <ul class="nav navbar-toolbar">
        <li class="nav-item hidden-float" id="toggleMenubar">
          <a class="nav-link" data-toggle="menubar" href="#" role="button">
            <i class="icon hamburger hamburger-arrow-left">
              <span class="sr-only">Toggle menubar</span>
              <span class="hamburger-bar"></span>
            </i>
          </a>
        </li>
      </ul>
      <!-- End Navbar Toolbar -->
      <!-- Navbar Toolbar Right -->
      <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Notifications"
            aria-expanded="false" data-animation="scale-up" role="button">
            <i class="icon wb-bell" aria-hidden="true"></i>
            @if (Auth::user()->role == 'manajer')
            @if ($pembcount != 0)
            <span class="tag tag-pill tag-danger up">{{$pembcount}}</span>
            @else
            <span class="tag tag-pill tag-danger up"></span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
            <div class="dropdown-menu-header">
              <h5>NOTIFICATIONS</h5>
              @if ($pembcount != 0)
              <span class="tag tag-round tag-danger">New {{$pembcount}}</span>
              @else
              <span class="tag tag-round tag-danger"></span>
              @endif
            </div>
            @elseif (Auth::user()->role == 'gudang')
            @if ($counter != 0)
            <span class="tag tag-pill tag-danger up">{{$counter}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
            <div class="dropdown-menu-header">
              <h5>NOTIFICATIONS</h5>
              <span class="tag tag-round tag-danger">New {{$counter}}</span>
            </div>
            @else
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
            <div class="dropdown-menu-header">
              <h5>NOTIFICATIONS</h5>
            </div>
            @endif
            @else
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
            <div class="dropdown-menu-header">
              <h5>NOTIFICATIONS</h5>
            </div>
            @endif
            <div class="list-group">
              <div data-role="container">
                <div data-role="content">
                  @if (Auth::user()->name == 'manajer')
                  {{-- for manajer --}}
                  @if ($pembcount != 0)
                  <a class="list-group-item dropdown-item" href="/list-permintaan" role="menuitem">
                    <div class="media">
                      <div class="media-left p-r-10">
                        <i class="icon wb-chat bg-orange-600 white icon-circle" aria-hidden="true"></i>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Permintaan Pembelian &nbsp;
                          <span class="tag tag-pill tag-danger right" id="counter-permintaan-pembelian">
                            {{$pembcount}}
                          </span></h6>
                      </div>
                    </div>
                  </a>
                  @else
                  @endif
                  {{-- end funtion --}}
                  @endif

                  @if (Auth::user()->name == 'Gudang')
                  {{-- for manajer --}}
                  <a class="list-group-item dropdown-item" id="otomatisStok" href="{{ route("produksi.isiOtomatis") }}" role="menuitem">
                    <div class="media">
                      <div class="media-left p-r-10">
                        <i class="icon wb-chat bg-orange-600 white icon-circle" aria-hidden="true"></i>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Stok Yang Perlu Diorder &nbsp;
                          <span class="tag tag-pill tag-danger right" id="counter-permintaan-pembelian">
                            {{$counter}}
                          </span></h6>
                      </div>
                    </div>
                  </a>
                  {{-- end funtion --}}
                  @endif
                </div>
              </div>
            </div>
            <div class="dropdown-menu-footer">
              <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                <i class="icon md-settings" aria-hidden="true"></i>
              </a>
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                All notifications
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
            <span class="avatar">
              <img src="{{ asset('images/user.jpg') }}" alt="...">
              <i></i>
            </span>
          </a>
          <div class="dropdown-menu" role="menu">
          <button class="dropdown-item btn-gantipw" role="menuitem" data-target="#exampleFormModal" data-id="{{Auth::user()->id}}" data-toggle="modal"><i class="icon wb-refresh"
                aria-hidden="true"></i> Ubah Password</button>
                <div class="dropdown-divider" role="presentation"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" role="menuitem"><i class="icon wb-power"
              aria-hidden="true"></i> Logout</a>
          </div>
        </li>
      </ul>
      <div class="nav navbar-right" style="margin-top: 23px;">
        <span class="text-center mt-3">
          @if(Auth::user()->role == 'gudang')
          <p>Level Pengguna:Bagian {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'finance')
          <p>Level Pengguna:Bagian {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'setting')
          <p>Level Pengguna:Bagian {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'supervisor')
          <p>Level Pengguna:{{Auth::user()->role}} produksi<p>
          @endif
          @if(Auth::user()->role == 'admin')
          <p>Level Pengguna: {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'manajer')
          <p>Level Pengguna: {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'direktur')
          <p>Level Pengguna: {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'adminsystem')
          <p>Level Pengguna: {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'cutting')
          <p>Level Pengguna:Bagian {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'offset')
          <p>Level Pengguna:Bagian {{Auth::user()->role}}<p>
          @endif
          @if(Auth::user()->role == 'finishing')
          <p>Level Pengguna:Bagian {{Auth::user()->role}}<p>
          @endif
        </span>
      </div>

      <!-- End Navbar Toolbar Right -->
    </div>
    <!-- End Navbar Collapse -->
  </div>
</nav>
<!-- Modal -->
<div class="modal fade modal-primary in" id="exampleFormModal" aria-hidden="false" aria-labelledby="exampleFormModalLabel"
role="dialog" tabindex="-1">
  <div class="modal-dialog">
  <form class="modal-content" action="{{ route('user.update',Auth::user()->id) }}" id="gantipassword" method="POST" data-parsley-validate ="">
        @method('PUT')
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      <h4 class="modal-title" id="exampleFormModalLabel">Form ganti password</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-xs-12 col-xl-4 form-group">
                 <p>ID User :</p>
                </div>
            <div class="col-xs-12 col-xl-6 form-group">
              <input type="text" class="form-control" name="idUser" readonly>
            </div>
          </div>
        <div class="row">
            <div class="col-xs-12 col-xl-4 form-group">
               <p>Nama :</p>
              </div>
          <div class="col-xs-12 col-xl-6 form-group">
            <input type="text" class="form-control" name="name" readonly>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-xl-4 form-group">
                <p>Username :</p>
               </div>
          <div class="col-xs-12 col-xl-6 form-group">
            <input type="text" class="form-control" name="username"  readonly>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-xl-4 form-group">
                <p>Email :</p>
               </div>
          <div class="col-xs-12 col-xl-6 form-group">
          <input type="email" class="form-control" name="email"  readonly>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-xl-4 form-group">
                <p>Password Baru :</p>
               </div>
          <div class="col-xs-12 col-xl-6 form-group">
            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="pwbaru" placeholder="Password Baru" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-xl-4 form-group">
                <p>Konfirmasi Password :</p>
               </div>
          <div class="col-xs-12 col-xl-6 form-group">
            <input type="password" class="form-control" name="cnfrmpwbaru" placeholder="Konfirmasi Password Baru" required>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-md-12 pull-xs-right">
            <button type="submit" class="btn btn-primary btn-reset-password">Simpan</button>
          </div>
        </div>
        @csrf
      </div>
    </form>
  </div>
</div>
<!-- End Modal -->
