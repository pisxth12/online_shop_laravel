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

                    <h2 class="text-center">Welcome Back</h2>


                    <form method="POST" class="text-left clearfix" action="{{ route('customer.login.process') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" id="loginBtn" class="btn btn-main text-center">Login</button>
                        </div>
                    </form>
                    <p class="mt-20">New in this site ?<a href="{{ route('customer.register') }}"> Create New
                            Account</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadingForm(form) {
            const loginBtn = document.querySelector('#loginBtn');
            loginBtn.disabled = true;
            loginBtn.innerHTML = `<span class="btn btn-main text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</span>`
            return true;
        }

    </script>

</section>