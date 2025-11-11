<html lang="en">
@include('front-end.components.header')
<body>
  <section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.html">
            <img src="images/logo.png" alt="">
          </a>
          <h2 class="text-center">Create Your Account</h2>
          <form method="POST" class="text-left clearfix" onsubmit="return loadingForm()" action="{{ route('customer.register.process') }}">
            @csrf         
            <div class="form-group">
              <input type="text" class="form-control" name="name"  placeholder="Username">
              @error('name')
                <small class="text-danger">{{ $message }}</small>    
              @enderror
            </div>
             <div class="form-group">
              <input type="number" class="form-control" name="phone"  placeholder="Phone">
              @error('phone')
                <small class="text-danger">{{ $message }}</small>    
              @enderror
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email"  placeholder="Email">
              @error('email')
                <small class="text-danger">{{ $message }}</small>    
              @enderror
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="password"  placeholder="Password">
              @error('password')
                <small class="text-danger">{{ $message }}</small>    
              @enderror
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="confirm_password"  placeholder="Confirm Password">
              @error('confirm_password')
                <small class="text-danger">{{ $message }}</small>    
              @enderror
            </div>
            <div class="text-center">
              <button type="submit"  id="btnRegister" class="btn btn-main text-center">Sign In</button>
            </div>
          </form>
          <p class="mt-20">Already hava an account ?<a href="{{ route('customer.login') }}"> Login</a></p>
          <p><a href="forget-password.html"> Forgot your password?</a></p>
        </div>
      </div>
    </div>
  </div>
  <script>
    function loadingForm(){
        const loadingShow = document.querySelector('#btnRegister');
        loadingShow.disabled = true;
        loadingShow.innerHTML = `<span><i class="fa fa-spinner fa-spin"></i> Loading...</span>`;
        return true
    }
    
  </script>
</section>
  
</body>
</html>