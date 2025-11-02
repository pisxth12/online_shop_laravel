<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>

  <!-- Bootstrap CSS v5.2.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
  <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/css/vendor.bundle.addons.css') }}">

  <!-- Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('back-end/assets/css/shared/style.css') }}">
  <link rel="stylesheet" href="{{ asset('back-end/assets/css/demo_1/style.css') }}">

  <!-- Toastify CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('back-end/assets/images/favicon.ico') }}" />

  <!-- jQuery (only one version!) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Select2 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <!-- Toastify JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>


<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('back-end.components.navbar')
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      @include('back-end.components.sidebar')
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">


          @yield("contens")


        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com
              2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a
                href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin
                templates</a> from Bootstrapdash.com</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  {{-- Modal --}}
  <!-- Button trigger modal -->
  {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}

  <!-- Modal -->
  <div class="modal fade" id="modalSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Search sometings</h5>
          <button type="button" class="close text-2xl" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="search-content ">
            <div class="form-group d-flex gap-2">
                <input type="text" name="search"  placeholder="Search..." class="form-control border-0 search_box" >
              <div type="button" id="btnSearch" class="btn btn-primary btnSearch text-center d-flex justify-content-center align-items-center">Search</div>
            </div>
            <button type="button" class="btn btn-secondary d-flex justify-content-end w-full" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- container-scroller -->

  {{-- select2 script --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> 

  <!-- plugins:js -->
  <script src="{{ asset('back-end/assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('back-end/assets/vendors/js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->


  <script src="{{ asset('back-end/assets/js/shared/off-canvas.js') }}"></script>
  <script src="{{ asset('back-end/assets/js/shared/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('back-end/assets/js/demo_1/dashboard.js') }}"></script>
  <!-- End custom js for this page-->
  <script src="{{ asset('back-end/assets/js/shared/jquery.cookie.js') }}" type="text/javascript"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  {{-- Boostrap 5.2 start --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  {{-- Boostrap 5.2 end --}}



  {{-- toastify mesaage --}}
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  {{-- select 2 --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> 
  

  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    const Message = (message , status = true) => {
      Toastify({
        text: `${message}`,
        duration: 3000,
        destination: "https://github.com/apvarun/toastify-js",
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
          background: `${status ? 'linear-gradient(to right, #00b09b, #96c93d)':'red' }`
        },
        onClick: function () { } // Callback after click
      }).showToast();
    }
    

  </script>

@yield('scripts')



</body>

</html>