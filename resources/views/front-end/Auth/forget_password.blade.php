@include('front-end.components.header')

<section class="forget-password-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.html">
            <img src="images/logo.png" alt="">
          </a>
          <h2 class="text-center">Enter email to create new password</h2>
          <form  class="text-left clearfix" action="{{ route('customer.process.forgot.password') }}" method="POST" >
          @csrf
            <div class="form-group">
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Account email address">
             @error('error')
                <p class="text-danger ">{{ $message }}</p>
              @enderror
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center">Enter email</button>
            </div>
          </form>
          <p class="mt-20"><a href="{{ route('customer.login') }}">Back to log in</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

