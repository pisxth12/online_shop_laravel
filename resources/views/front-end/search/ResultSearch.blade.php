@extends('front-end.components.master')

@section('contents')
<section class="products section">
    <div class="container">
        <h2>Search Results for "{{ $query }}"</h2>

        <div class="row">
            @if($products->count() > 0)
                @foreach ($products as $index => $product)
                    <div class="col-md-4">
                        <div class="product-item">
                            <div class="product-thumb">
                                @if($product->sale ?? false)
                                    <span class="bage">Sale</span>
                                @endif
                                <img class="img-responsive" src="{{ asset('uploads/product/' . $product->image[0]->image) }}" alt="{{ $product->name }}" />
                                <div class="preview-meta">
                                    <ul>
                                        <li>
                                            <span data-toggle="modal" data-target="#product-modal-{{ $product->id }}">
                                                <i class="tf-ion-ios-search-strong"></i>
                                            </span>
                                        </li>
                                        <li>
                                            <a href="#!"><i class="tf-ion-ios-heart"></i></a>
                                        </li>
                                        <li>
                                            @if (Auth::check())
                                                <a href="{{ route('cart.add.to.cart', $product->id) }}"><i class="tf-ion-android-cart"></i></a>
                                            @else
                                                <a href="{{ route('customer.login') }}"><i class="tf-ion-android-cart"></i></a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h4><a href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a></h4>
                                <p class="price">${{ $product->price }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal product-modal fade" id="product-modal-{{ $product->id }}">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="tf-ion-close"></i>
                        </button>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <div class="modal-image">
                                                <img class="img-responsive" src="{{ asset('uploads/product/' . $product->image[0]->image) }}" alt="{{ $product->name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="product-short-details">
                                                <h2 class="product-title">{{ $product->name }}</h2>
                                                <p class="product-price">${{ $product->price }}</p>
                                                <p class="product-short-description">{{ $product->desc }}</p>
                                                @if (Auth::check())
                                                    <a href="{{ route('cart.add.to.cart', $product->id) }}" class="btn btn-main">Add To Cart</a>
                                                @else
                                                    <a href="{{ route('customer.login') }}" class="btn btn-main">Add To Cart</a>
                                                @endif
                                                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-transparent">View Product Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal -->

                @endforeach
            @else
                <p>No products found for "{{ $query }}".</p>
            @endif
        </div>
    </div>
</section>
@endsection
