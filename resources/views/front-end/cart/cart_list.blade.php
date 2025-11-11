@extends('front-end.components.master')

@section('contents')

  <style>
  tr th {
    text-align: center
  }
  tr td {
    text-align: center
  }
/* Container */
td div {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

/* Input field */
td input[type="text"] {
  width: 60px;
  height: 34px;
  text-align: center;
  font-size: 16px;
  font-weight: 500;
  color: #333;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 6px;
  outline: none;
}

/* Buttons */
td button {
  width: 34px;
  height: 34px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #fff;
  color: #333;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.2s ease;
}

/* Hover effect: slightly darker border */
td button:hover {
  border-color: #888;
  color: #000;
}

/* Click effect: small scale */
td button:active {
  transform: scale(0.95);
}

/* Remove focus outlines */
td button:focus,
td input:focus {
  outline: none;
}


</style>
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
                      <th class="">Item Image</th>
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
                    
                        {{-- <td>{{ $cartItem->quantity }}</td> --}}
                        <td>
                          <div style="display:flex; justify-content:center; gap:6px;">
                            <button type="button" onclick="decrementQTY('{{ $cartItem->id }}')">−</button>
                            <input type="text" id="qty-{{ $cartItem->id }}" value="{{ $cartItem->quantity }}" readonly style="width:60px; text-align:center;">
                            <button type="button" onclick="incrementQTY('{{ $cartItem->id }}')">+</button>
                          </div>
                        </td>                      
                        <td class="">${{ $cartItem->price }}</td>
                        <td class="">
                          <a class="product-remove" href="{{ route('cart.remove.from.cart',$cartItem->id) }}">Remove</a>
                        </td>
                      </tr>
                    @endforeach
           
          
                  </tbody>
                </table>
                <a href="{{ route('checkout.index') }}" class="btn btn-main pull-right">Checkout</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection



@section('scripts')
  <script>
  function incrementQTY(id) {
    let qtyInput = $('#qty-' + id);
    let newQty = parseInt(qtyInput.val()) + 1;

    $.ajax({
      type: "POST",
      url: "{{ route('cart.update.quantity') }}",
      data: {
        _token: "{{ csrf_token() }}",
        id: id,
        quantity: newQty
      },
      dataType: "json",
      success: function(response) {
        if (response.status === 200) {
          qtyInput.val(response.quantity);

          if ($('#cart-total').length) {
            $('#cart-total').text('$' + response.cart_total);
          }
          message(response.message)
        }
      },
      error: function(err) {
        console.error(err);
      }
    });
  }

  function decrementQTY(id) {
    let qtyInput = $('#qty-' + id);
    let newQty = parseInt(qtyInput.val()) - 1;
    if (newQty < 1) newQty = 1;

    $.ajax({
      type: "POST",
      url: "{{ route('cart.update.quantity') }}",
      data: {
        _token: "{{ csrf_token() }}",
        id: id,
        quantity: newQty
      },
      dataType: "json",
      success: function(response) {
        if (response.status === 200) {
          qtyInput.val(response.quantity);

          if ($('#cart-total').length) {
            $('#cart-total').text('$' + response.cart_total);
          }
        }
      },
      error: function(err) {
        console.error(err);
      }
    });
  }
</script>

@endsection