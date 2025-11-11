<!DOCTYPE html>


<html lang="en">
@include('front-end.components.header')
<body id="body">
	
@include('front-end.components.navBar')




@yield('slider')

@yield('contents')






@include('front-end.components.subscribe')
<section class="section instagram-feed">
	<div class="container">
		<div class="row">
			<div class="title">
				<h2>View us on instagram</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="instagram-slider" id="instafeed" data-accessToken="IGQVJYeUk4YWNIY1h4OWZANeS1wRHZARdjJ5QmdueXN2RFR6NF9iYUtfcGp1NmpxZA3RTbnU1MXpDNVBHTzZAMOFlxcGlkVHBKdjhqSnUybERhNWdQSE5hVmtXT013MEhOQVJJRGJBRURn"></div>
			</div>
		</div>
	</div>
</section>


@include('front-end.components.footer')
    <!-- 
    Essential Scripts
    =====================================-->
    
    <!-- Main jQuery -->
    <script src="{{asset('front-end/asset/plugins/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{asset('front-end/asset/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{asset('front-end/asset/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
    <!-- Instagram Feed Js -->
    <script src="{{asset('front-end/asset/plugins/instafeed/instafeed.min.js')}}"></script>
    <!-- Video Lightbox Plugin -->
    <script src="{{asset('front-end/asset/plugins/ekko-lightbox/dist/ekko-lightbox.min.js')}}"></script>
    <!-- Count Down Js -->
    <script src="{{asset('front-end/asset/plugins/syo-timer/build/jquery.syotimer.min.js')}}"></script>

    <!-- slick Carousel -->
    <script src="{{asset('front-end/asset/plugins/slick/slick.min.js')}}"></script>
    <script src="{{asset('front-end/asset/plugins/slick/slick-animation.min.js')}}"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="{{asset('front-end/asset/plugins/google-map/gmap.js')}}"></script>

    <!-- Main Js File -->
    <script src="{{ asset('front-end/asset/js/script.js') }} "></script>

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
