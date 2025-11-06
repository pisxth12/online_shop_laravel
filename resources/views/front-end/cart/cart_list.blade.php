@include('front-end.components.header')
@include('front-end.components.navBar')
<div class="page-wrapper">
  <div class="cart shopping">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="block">
            <div class="product-list">
              <form method="post">
                {{-- add to cart success --}}
                @include('front-end.message.alert')
                <table class="table">
                  <thead>
                    <tr>
                      <th class="">Item Name</th>
                      <td class="">Item Image</td>
                      <th class="">Item Quantity</th>
                      <th class="">Item Price</th>
                      <th class="">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cartItems as $cartItem )
                        <tr class="">
                        <td>{{ $cartItem->name }}</td>  
                        <td class="">
                           @if($cartItem->attributes->image)
                              <img width="80" src="{{ asset('uploads/product/' . $cartItem->attributes->image) }}" alt="{{ $cartItem->name }}">
                          @else
                              <img width="80" src="{{ asset('uploads/product/default.png') }}" alt="{{ $cartItem->name }}">
                          @endif
                        </td>
                    =
                        <td>{{ $cartItem->quantity }}</td>

                      
                        <td class="">${{ $cartItem->price }}</td>
                        <td class="">
                          <a class="product-remove" href="{{ route('cart.remove.from.cart',$cartItem->id) }}">Remove</a>
                        </td>
                      </tr>
                    @endforeach
           
          
                  </tbody>
                </table>
                <a href="checkout.html" class="btn btn-main pull-right">Checkout</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('front-end.components.footer')