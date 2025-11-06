@extends('front-end.components.master')

@section('contents')

			@section('category')
				<section class="product-category section">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="title text-center">
								<h2>Product Category</h2>
							</div>
						</div>
						<div class="col-md-6">
							<div class="category-box">
								<a href="#!">
									{{-- <img src="{{asset('front-end/asset/images/shop/category/category-1.jpg')}}" alt="" /> --}}
									<img src="{{asset('uploads/category/'. $categories[0]->image)}}" alt="" />

									<div class="content ">
										<h3>{{$categories[0]->name}}</h3>
										<p>{{ $categories[0]->title}}Shop New Season Clothing</p>
									</div>
								</a>	
							</div>
							<div class="category-box">
								<a href="#!">
									<img src="{{asset('uploads/category/'. $categories[1]->image)}}" alt="" />
									<div class="content ">
										<h3>{{$categories[1]->name}}</h3>
										<p>{{ $categories[1]->title}}Get Wide Range Selection</p>
									</div>
								</a>	
							</div>
						</div>
						<div class="col-md-6">
							<div class="category-box category-box-2">
								<a href="#!">
									<img src="{{asset('uploads/category/'.$categories[2]->image)}}" alt="" />
									<div class="content ">
										<h3>{{$categories[2]->name}}</h3>
										<p>{{ $categories[2]->title}}Special Design Comes First</p>
									</div>
								</a>	
							</div>
						</div>
					</div>
				</div>
			</section>
			@endsection

			@section('product')
			<section class="products section bg-gray">
				<div class="container">
					<div class="row">
						<div class="title text-center">
							<h2>Trendy Products</h2>
						</div>
					</div>
					<div class="row">
						
						@if ($products->count() > 0)
							@foreach ($products as $product )
								<div class="col-md-4">
							<div class="product-item">
								<div class="product-thumb">
									<span class="bage">Sale</span>
									@if ($product->image[0]->image > 0)
									<img class="img-responsive" src="{{asset('uploads/product/'.$product->image[0]->image)}}" alt="product-img" />
									@endif
									<div class="preview-meta">
										<ul>
											<li  onclick="ViewProduct({{ $product->id }})" >
												<span  data-toggle="modal" data-target="#product-modal">
													<i class="tf-ion-ios-search-strong"></i>
												</span>
											</li>
											<li>
												<a href="#!" ><i onclick="ViewProduct({{ $product->id }})" class="tf-ion-ios-heart"></i></a>
											</li>

											{{-- add to cart --}}
											<li>
												@if (Auth::check())
													<a href="{{ route('cart.add.to.cart', $product->id) }}" class="btn }}"><i class="tf-ion-android-cart"></i></a>
													@else
													<a href="{{ route('customer.login') }}"><i class="tf-ion-android-cart"></i></a>
												@endif
											</li>
										</ul>
									</div>
								</div>
								<div class="product-content">
									<h4><a href="product-single.html">{{ $product->name }}</a></h4>
									<p class="price">
											@php
												if($product->price >= 1000000){

													$priceM = $product->price / 1000000;
													echo '$' . (intval($priceM) == $priceM ? $priceM : number_format($priceM, 1)) . 'M';
												} else {
													echo '$' . number_format($product->price, 2);
												}
											@endphp
											</p>

								</div>
							</div>
						</div>
							@endforeach
						
					
						@endif
						
					

					
					<!-- Modal -->
					<div class="modal product-modal fade" id="product-modal">
						
					</div><!-- /.modal -->

					</div>
				</div>
			</section>
			@endsection

			@section('scripts')
			<script> 
				const ViewProduct = (id) => {
				
					$.ajax({
					type: "get",
					url: `/viewProduct/${id}`,
					dataType: "json",
					success: function (response) {
						if(response.status == 200){
							let product = response.product;

							// Construct image URL
							let imageURL = (product.image && product.image.length > 0) 
								? `/uploads/product/${product.image[0].image}` 
								: `/back-end/assets/css/demo_1/style.css`; // fallback image

							let modalHTML = `
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i class="tf-ion-close"></i>
								</button>
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-8 col-sm-6 col-xs-12">
													<div class="modal-image">
														<img class="img-responsive " src="${imageURL}" alt="product-img" />
													</div>
												</div>
												<div class="col-md-4 col-sm-6 col-xs-12">
													<div class="product-short-details">
														<h2 class="product-title">${product.name}</h2>
														<p class="product-price">$${product.price}</p>
														<p class="product-short-description">
															${product.desc}
														</p>
														<a href="cart.html" class="btn btn-main">Add To Cart</a>
														<a href="/product/detail/${product.id}" class="btn btn-transparent">View Product Details</a>
														

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							`;

							$('#product-modal').html(modalHTML);
							$('#product-modal').modal('show'); 
						}
					}
				});
			}



			</script>
				
			@endsection

@endsection

