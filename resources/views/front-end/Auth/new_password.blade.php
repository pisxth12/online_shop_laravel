@include('front-end.components.header')

<section class="signin-page account">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="block text-center">
                    @include('front-end.message.alert')

                    <a class="logo" href="index.html">
                        <img src="{{ asset('front-end/asset/images/logo.png') }}" alt="">
                    </a>
                    <h2 class="text-center">Reset Password</h2>

                    {{-- Fixed: Changed action route and added onsubmit --}}
                    <form method="POST" class="text-left clearfix" action="{{ route('reset.password.process') }}" onsubmit="return loadingForm(this)">
                        @csrf
                        
                        {{-- Added: Hidden fields for token and code --}}
                        <input type="hidden" name="token" value="{{ $tokenData->token }}">
                        <input type="hidden" name="code" value="{{ $tokenData->code }}">
                        
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="New Password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            {{-- Fixed: Changed type from "confirm_password" to "password" --}}
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                            @error('confirm_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-center">
                            {{-- Fixed: Changed button text --}}
                            <button type="submit" id="loginBtn" class="btn btn-main text-center">Reset Password</button>
                        </div>
                    </form>
                    
                    {{-- Fixed: Changed link text --}}
                    <p class="mt-20">Remember your password? <a href="{{ route('customer.login') }}">Back to Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadingForm(form) {
            const loginBtn = document.querySelector('#loginBtn');
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Resetting...';
            return true;
        }
    </script>
</section>