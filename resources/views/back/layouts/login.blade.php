<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>Arie | Digital Printing</title>
  <link rel="apple-touch-icon" href="{{ asset('global/assets/images/apple-touch-icon.png') }}">
  <link rel="shortcut icon" href="{{asset('global/assets/images/favicon.ico')}}">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{asset('global/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('global/css/bootstrap-extend.min.css')}}">
  <link rel="stylesheet" href="{{asset('global/assets/css/site.min.css')}}">
  <!-- Plugins -->
  <link rel="stylesheet" href="{{asset('global/vendor/animsition/animsition.css')}}">
  <link rel="stylesheet" href="{{asset('global/vendor/asscrollable/asScrollable.css')}}">
  <link rel="stylesheet" href="{{asset('global/vendor/switchery/switchery.css')}}">
  <link rel="stylesheet" href="{{asset('global/vendor/intro-js/introjs.css')}}">
  <link rel="stylesheet" href="{{asset('global/vendor/slidepanel/slidePanel.css')}}">
  <link rel="stylesheet" href="{{asset('global/vendor/flag-icon-css/flag-icon.css')}}">
  <link rel="stylesheet" href="{{asset('global/assets/examples/css/pages/login-v3.css')}}">
  <!-- Fonts -->
  <link rel="stylesheet" href="{{asset('global/fonts/web-icons/web-icons.min.css')}}">
  <link rel="stylesheet" href="{{asset('global/fonts/brand-icons/brand-icons.min.css')}}">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!--[if lt IE 9]>
    <script src="../../../global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="../../../global/vendor/media-match/media.match.min.js"></script>
    <script src="../../../global/vendor/respond/respond.min.js"></script>
    <![endif]-->
  <!-- Scripts -->
  <script src="{{asset('global/vendor/breakpoints/breakpoints.js')}}"></script>
  <script>
  Breakpoints();
  </script>
</head>
<body class="animsition page-login-v3 layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <!-- Page -->
  <div class="page vertical-align text-xs-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
      <div class="panel">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img" src="{{asset('global/assets/images/logo-blue.png')}}" alt="...">
            <h2 class="brand-text font-size-18">Arie | Digital Printing</h2>
          </div>
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus/>
              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
              <label class="floating-label">Emails</label>
            </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required/>
              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
              <label class="floating-label">Password</label>
            </div>
            <div class="form-group clearfix">
              <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg pull-xs-left">
                <input type="checkbox" id="inputCheckbox" name="remember">
                <label for="inputCheckbox">Remember me</label>
              </div>
              <a class="pull-xs-right" href="forgot-password.html">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg m-t-40">Sign in</button>
          </form>
          <p>Still no account? Please go to <a href="register-v3.html">Sign up</a></p>
        </div>
      </div>
      <footer class="page-copyright page-copyright-inverse">
      
        <p>Copyright © CV. Arie 2019. All RIGHT RESERVED.</p>
        <div class="social">
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
        </div>
      </footer>
    </div>
  </div>
  <!-- End Page -->
  <!-- Core  -->
  <script src="{{asset('global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
  <script src="{{asset('global/vendor/jquery/jquery.js')}}"></script>
  <script src="{{asset('global/vendor/tether/tether.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap/bootstrap.js')}}"></script>
  <script src="{{asset('global/vendor/animsition/animsition.js')}}"></script>
  {{-- <script src="{{asset('global/vendor/mousewheel/jquery.mousewheel.$table->json('column')->nullable();')}}"></script> --}}
  <script src="{{asset('global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
  <script src="{{asset('global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
  <script src="{{asset('global/vendor/ashoverscroll/jquery-asHoverScroll.js')}}"></script>
  <!-- Plugins -->
  <script src="{{asset('global/vendor/switchery/switchery.min.js')}}"></script>
  <script src="{{asset('global/vendor/intro-js/intro.js')}}"></script>
  <script src="{{asset('global/vendor/screenfull/screenfull.js')}}"></script>
  <script src="{{asset('global/vendor/slidepanel/jquery-slidePanel.js')}}"></script>
  <script src="{{asset('global/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
  <!-- Scripts -->
  <script src="{{asset('global/js/State.js')}}"></script>
  <script src="{{asset('global/js/Component.js')}}"></script>
  <script src="{{asset('global/js/Plugin.js')}}"></script>
  <script src="{{asset('global/js/Base.js')}}"></script>
  <script src="{{asset('global/js/Config.js')}}"></script>
  <script src="{{asset('global/assets/js/Section/Menubar.js')}}"></script>
  <script src="{{asset('global/assets/js/Section/GridMenu.js')}}"></script>
  <script src="{{asset('global/assets/js/Section/Sidebar.js')}}"></script>
  <script src="{{asset('global/assets/js/Section/PageAside.js')}}"></script>
  <script src="{{asset('global/assets/js/Plugin/menu.js')}}"></script>
  <script src="{{asset('global/js/config/colors.js')}}"></script>
  <script src="{{asset('global/assets/js/config/tour.js')}}"></script>
  <script>
  Config.set('assets', '../assets');
  </script>
  <!-- Page -->
<script src="{{ asset('global/assets/js/Site.js') }}"></script>
<script src="{{ asset('global/js/Plugin/asscrollable.js') }}"></script>
<script src="{{ asset('global/js/Plugin/slidepanel.js') }}"></script>
<script src="{{ asset('global/js/Plugin/switchery.js')}}"></script>
<script src="{{ asset('global/js/Plugin/jquery-placeholder.js')}}"></script>
<script src="{{ asset('global/js/Plugin/material.js')}}"></script>
<script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>
</body>
</html>