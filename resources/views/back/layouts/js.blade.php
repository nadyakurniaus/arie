<script src="{{ asset('global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
<script src="{{ asset('global/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('global/vendor/tether/tether.js') }}"></script>
<script src="{{ asset('global/vendor/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('global/vendor/animsition/animsition.js') }}"></script>
<script src="{{ asset('global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
<script src="{{ asset('global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
<script src="{{ asset('global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Plugins -->
<script src="{{ asset('global/vendor/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('global/vendor/intro-js/intro.js') }}"></script>
<script src="{{ asset('global/vendor/screenfull/screenfull.js') }}"></script>
<script src="{{ asset('global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
<script src="{{ asset('global/vendor/skycons/skycons.js') }}"></script>
<script src="{{ asset('global/vendor/chartist/chartist.min.js') }}"></script>
<script src="{{ asset('global/vendor/aspieprogress/jquery-asPieProgress.min.js') }}"></script>
<script src="{{ asset('global/vendor/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('global/vendor/jvectormap/maps/jquery-jvectormap-au-mill-en.js') }}"></script>
<script src="{{ asset('global/vendor/matchheight/jquery.matchHeight-min.js') }}"></script>
<!-- Scripts -->
<script src="{{ asset('global/js/State.js') }}"></script>
<script src="{{ asset('global/js/Component.js') }}"></script>
<script src="{{ asset('global/js/Plugin.js') }}"></script>
<script src="{{ asset('global/js/Base.js') }}"></script>
<script src="{{ asset('global/js/Config.js') }}"></script>
<script src="{{ asset('global/assets/js/Section/Menubar.js') }}"></script>
<script src="{{ asset('global/assets/js/Section/GridMenu.js') }}"></script>
<script src="{{ asset('global/assets/js/Section/Sidebar.js') }}"></script>
<script src="{{ asset('global/assets/js/Section/PageAside.js') }}"></script>
<script src="{{ asset('global/assets/js/Plugin/menu.js') }}"></script>
<script src="{{ asset('global/js/config/colors.js') }}"></script>
<script src="{{ asset('global/assets/js/config/tour.js') }}"></script>
<script src="{{ asset('js/parsley.js') }}">
</script>
<script>
    Config.set('assets', '../assets');
</script>
<!-- Page -->
<script src="{{ asset('global/assets/js/Site.js') }}"></script>
<script src="{{ asset('global/js/Plugin/asscrollable.js') }}"></script>
<script src="{{ asset('global/js/Plugin/slidepanel.js') }}"></script>
<script src="{{ asset('global/js/Plugin/switchery.js') }}"></script>
<script src="{{ asset('global/js/Plugin/matchheight.js') }}"></script>
<script src="{{ asset('global/js/Plugin/jvectormap.js') }}"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
</script>
<script type="text/javascript">

window.ParsleyConfig = {
      errorsWrapper: '<div></div>',
      errorTemplate: '<span class="error-text"></span>',
      classHandler: function (el) {
          return el.$element.closest('input');
      },
      successClass: 'valid',
      errorClass: 'invalid'
  };
  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
      });
    });
  }
    $(function () {
      $('.btn-gantipw').on('click', function (e) {
          let id = $(this).data('id');
          let url = '{{ route("user.edit", ':id') }}';
          let urlw = '{{ route("user.update", ':id') }}';
          urlw=urlw.replace(':id', id);
          url=url.replace(':id', id);
          $.ajax({
              url:url,
              method:"get",
              dataType:"json",
              success:function(res){
                  $('[name=idUser]').val(res.idUser);
                  $('[name=name]').val(res.name);
                  $('[name=username]').val(res.username);
                  $('[name=email]').val(res.email);
                  $('#gantipassword').attr('action', urlw)
              }
          })
      });
    })
    $('.btn-reset-password').click(function(){
      swal({
          title: "Are you sure want to remove this item?",
          text: "You will not be able to recover this item",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Confirm",
          cancelButtonText: "Cancel",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {
            swal("Deleted!", "Your item deleted.", "success");
          } else {
            swal("Cancelled", "You Cancelled", "error");
          }
      });
    });

  </script>
