@include('front-end.components.header')

<section class="forget-password-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="index.html">
            <img src="images/logo.png" alt="">
          </a>
          @include('front-end.message.alert')
          <h2 class="text-center">Enter Verify Code</h2>
          <form class="text-left clearfix" action="{{ route('verify.code.process') }}" method="POST">
            @csrf
            
            
            {{-- Hidden field for token (not disabled) --}}
            <input type="hidden" name="token" value="{{ $tokenData->token }}">
            
            <div class="form-group">
              <input type="text" name="code" class="form-control" id="code" placeholder="Enter code sent to your email" value="{{ old('code') }}">
              @error('code')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center">Verify Code</button>
            </div>
          </form>
          <p class="mt-20"><a href="{{ route('customer.login') }}">Back to log in</a></p>
        </div>
      </div>
    </div>
  </div>
</section>