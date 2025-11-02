@extends('back-end.components.master')
@section('contens')

  <!-- Page Title Header Starts-->
  <div class="row page-title-header">
    <div class="col-12">
      <div class="page-header">
        <h4 class="page-title">Dashboard</h4>

      </div>
    </div>
  </div>
  <!-- Page Title Header Ends-->


  {{-- Modal start --}}
  @include('back-end.messages.product.create')
  {{-- Modal end --}}
  @include('back-end.messages.product.edit')

  {{-- table start --}}


  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Product</h4>
          <div class="form-group">
            <div class="search-content border-l-2">
              <div class=" d-flex gap-2">
                <div class="search-content d-flex justify-content-between border align-items-center">
                  <input type="text" name="search_color" placeholder="Search..."
                    class="search_color_box form-control border-0 search_box">
                  <i class="bi bi-search search_icon px-2 btnSearch_color"></i>
                </div>
                <div type="button" id="btnSearch_color"
                  class="btn btn-primary btnSearch_color text-center d-flex justify-content-center align-items-center">
                  Search</div>
              </div>

            </div>
          </div>
          </form>
          <p onclick="handleClickNewProduct()" data-bs-toggle="modal" data-bs-target="#modalCreateProduct"
            class="card-description btn btn-primary ">new
            product
          </p>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Product ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Stock</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Color</th>
                <th>Owner</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="Product_list">
              {{-- rows will be injected here --}}
            </tbody>
          </table>
        
        </div>
        <div class="d-flex mt-3 align-items-center justify-content-between">
          <div class="show_page"></div>

            <div id="prouductRefresh" class="refresh-page d-flex justify-content-end  hover-open " style="cursor: pointer;  ">
              <div class=" d-flex justify-content-end w-full">
                <i class="bi bi-arrow-clockwise text-2xl  w-full" style="font-size: 30px"></i>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>

    // /prodcuct refresh
    $(document).on('click','#prouductRefresh', function(){
      productList();
    })


    $(document).ready(function () {
      $('#color_add').select2({
        placeholder: 'Select options',
        allowClear: true,
        tags: true,
      });
    });

    $(document).ready(function () {
      $('#color_edit').select2({
        placeholder: 'Select options',
        allowClear: true,
        tags: true,
      });
    });




    //clear form upldate
   $(document).ready(function(){
    $('#modalEditProduct').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('show-message').html('');
      $('.show-images_edit').html('')
      $('.show-images_edit_old').html('')
    });
   })


   //searchh event
   $(document).on('click', '.btnSearch', function () {
      let container = $(this).closest('.modal, .search-form');
      let searchValue = container.find('.search_box').val();
      productList(1, searchValue);
      if (container.hasClass('modal')) {
        container.hide();
        $('.modal-backdrop').remove();
      }
    });

    $(document).on('click','.btnSearch_color', function(){

      let searchValue = $(".search_color_box").val();
      productList(1, searchValue);
      
    })






    const productList = (page=1, search="") => {
      $.ajax({
        type: "get",
        url: "{{ route('product.list') }}",
        data:{
          page:page,
          search:search,
        },
        dataType: "json",
        success: function (response) {

          if (response.status == 200) {

            let products = response.products || [];
            
          let html = ``;

             products = Object.values(products);
          
            $.each(products, function (key, value) {
              let imageSrc = value.image.length > 0 ? `/uploads/product/${value.image[0].image}` : '/uploads/default.png';

              let stock = value.qty;
              let stockClass;

              if (stock > 30) {
                stockClass = "bg-success";
                stockText = "in stock";
              } else if (stock > 1) { 
                stockClass = "bg-warning";
                stockText = "low stock";
              } else {
                stockClass = "bg-danger";
                stockText = "out stock";
              }

              html += `
                  <tr>
                        <td>${value.id}</td>
                      ${value.image.length > 0       
                      ? `<td><img src="${imageSrc}" alt="${value.name}" style="width:60px; height:60px; object-fit:cover;"></td>` 
                      : `<td class="">😒 no image</td>`
                        }
                        <td>${value.name}</td>
                        <td>${value.price}</td>
                        <td>${value.qty}</td>
                        <td>
                           <span class=" ${stockClass} p-2">${stockText}</span>
                        </td>
                        <td>${value.brand.name}</td>
                        <td>${value.category.name}</td>
                        <td class=" d-flex  gap-1">
                            ${value.colors_data.map(color => `
                              <div class="rounded-circle border  border-dark me-1" 
                                  style="width: 10px; height: 10px; background-color: ${color.color_code};">
                              </div>
                            `).join('')}
                          </td>
                        <td>seth</td>
                        <td>
                          <div class="form-check form-switch">
                            <input value="${value.status == 1 ? 'checked' : ''}" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                          </div>
                        </td>
                        <td>
                          <button class="btn btn-warning" onclick="editProduct('${value.id}')" data-bs-toggle="modal" data-bs-target="#modalEditProduct">Edit</button>
                          <button class="btn btn-danger" onclick="deleteProduct('${value.id}')">Delete</button>
                        </td>
                      </tr>
                 `;
                });
            
             
             $('.Product_list').html(html);

          } else {
             $('.Product_list').html(`
                    <tr>
                      <td colspan="12" class="text-center text-danger fw-bold">
                        Product not found
                      </td>
                    </tr>
                  `);
              return;
          }

          //pagiation
          let pages = response.pages;
          let totalPage = pages.totalPage;
          let currentPage = pages.currentPage;
          
          let pagination = `
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li onclick="PreviousPage(${currentPage})" class="page-item ${currentPage == 1 ? "d-none" : ""}" >
              <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>`;

      for (let i = 1; i <= totalPage; i++) {
        pagination += `
          <li onclick="ProductPage(${i})" class="page-item ${i == currentPage ? "active" : ""}" >
            <a class="page-link" href="javascript:void(0)">${i}</a>
          </li>`;
      }

      pagination += `
            <li onclick="NextPage(${currentPage})" class="page-item ${currentPage == totalPage ? "d-none" : ""}" >
              <a class="page-link" href="javascript:void(0)" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      `;

           $('.show_page').html(pagination);
        }
      });
    }

    function ProductPage(page){
      productList(page);
    }
    function NextPage(page){
      ProductPage(page+1);
    }
    function PreviousPage(page){
      ProductPage(page-1);
    }
   
   
    productList();


    const editProduct = (id) => {
     
      $.ajax({
        type: "post",
        url: "{{ route('product.edit') }}",
        data: {
          id: id
        },
        dataType: "json",
        success: function (response) {
          let product = response.data.product;
          if (response.status == 200) {

            //start name
            $('#id_edit').val(product.id)
            $('.title_edit').val(product.name);
            $('.desc_edit').val(product.desc);
            $('.price_edit').val(product.price);
            $('.qty_edit').val(product.qty);

            //start brands
            let brands = response.data.brands;
            let htmls = ``;
            $.each(brands, function (key, value) {
              htmls += `
                    <option value="${value.id}" ${(value.id == response.data.product.brand_id) ? 'selected' : ''}> ${value.name}</option>
                 `;
            });
            $('.brand_edit').html(htmls);
            //end brnad

            //  start category
            let categories = response.data.categories;
            $.each(categories, function (key, value) {
              $('.category_edit').append(`
                  <option value="${value.id}"  ${(value.id == response.data.product.category_id) ? 'selected' : ''}>${value.name}</option>
                `)
            });
            //end category

            

            // start color
            let colors = response.data.colors;
            let color_IDs = response.data.product.color;
            let html = ``;
            $.each(colors, function (key, value) {
              if (color_IDs.includes(String(value.id))) {
                html += `
                    <option value="${value.id}" selected>${value.name}</option>
                  `;
              } else {
                html += `
                    <option value="${value.id}">${value.name}</option>
                  `;
              }
            });
            $('.color_edit').html(html);
            // end

          let productImages = response.data.productImage;
          $.each(productImages, function(key, value){
              let imageUrl = "/uploads/product/" + value.image; // relative path from public
              $('.show-images_edit_old').append(`
                   <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 position-relative">
                          <div class="card border-0 shadow-sm text-center p-3 position-relative" 
                              style="border-radius: 15px; transition: 0.3s ease;">

                            <!-- Cancel (X) Button -->
                            <button
                              onclick="CancelImage(this,'${value.image}')"
                            type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 border bg-danger rounded-circle shadow-sm btn-remove" 
                                    style="width: 28px; height: 28px; line-height: 1; padding: 0; font-size: 16px;">
                              &times;
                            </button>

                            <input type="hidden" name="old_image" value="${value}">

                            <img 
                       
                              src="${imageUrl}" 

                              class="card-img-top rounded-circle mx-auto border" 
                              style="
                                width: 100px; 
                                height: 100px; 
                                object-fit: cover; 
                                margin-top: 10px;
                                transition: 0.3s ease;
                              "
                              onmouseover="this.style.transform='scale(1.08)'"
                              onmouseout="this.style.transform='scale(1)'"
                            >
                          </div>
                        </div>
              `);
          });




          }
        }, error: function (xhr, status, error) {
          console.error("Error:", error);
        }
      });
    }
   
    const updateProduct = (form) =>{
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "post",
        url: "{{ route('product.update') }}",
        data: payloads,
        contentType:false,
        processData:false,
        dataType: "json",
        success: function (response) {
          if(response.status ==200){
             
              var myModal = document.getElementById('modalEditProduct');
              var  modal = bootstrap.Modal.getOrCreateInstance(myModal);
              modal.hide()

              document.querySelectorAll('.modal-backdrop').forEach(function(el){
                  el.remove();
              });
              productList()

              Message(response.message)
          }
        }
      });
    }
    
    const productUpload = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('product.upload') }}",
        data: payloads,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            // $('#image').val('')

            
            let images = response.images;
            $.each(images, function (key, value) {
            $('.show-images').append(
              ` <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 position-relative">
                          <div class="card border-0 shadow-sm text-center p-3 position-relative" 
                              style="border-radius: 15px; transition: 0.3s ease;">

                            <!-- Cancel (X) Button -->
                            <button
                              onclick="CancelImage(this,'${value}')"

                            type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 border bg-danger rounded-circle shadow-sm btn-remove" 
                                    style="width: 28px; height: 28px; line-height: 1; padding: 0; font-size: 16px;">
                              &times;
                            </button>

                            <input type="hidden" name="image_uploads[]" value="${value}">

                            <img 
                              src="{{ asset('uploads/temp') }}/${value}" 
                              alt="preview" 
                              class="card-img-top rounded-circle mx-auto border" 
                              style="
                                width: 100px; 
                                height: 100px; 
                                object-fit: cover; 
                                margin-top: 10px;
                                transition: 0.3s ease;
                              "
                              onmouseover="this.style.transform='scale(1.08)'"
                              onmouseout="this.style.transform='scale(1)'"
                            >

                            <div class="card-body p-2">
                              <p class="card-text text-muted small mb-0">Image Preview</p>
                            </div>
                          </div>
                        </div>`
            )
            });
          }
        }
      });
    }
   
    const CancelImage = (e, image) => {
      if (confirm("Sure mf?")) {
        $.ajax({
          type: "POST",
          url: "{{ route('image.cancel') }}",
          data: {
            image: image,
          },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Message(response.message)
              $(e).parent().remove();
            }
          }
        });
      }
    }

    const handleClickNewProduct = () => {
      $.ajax({
        type: "POST",
        url: "{{ route('product.data') }}",
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            //stat categories
            let categories = response.data.Categories;
            let cate_option = ``;
            $.each(categories, function (key, value) {
              cate_option += `
                  <option value="${value.id}">${value.name}</option>
                `;
            });

            $('.category_add').html(cate_option);
            // end category

            // start brand
            let brands = response.data.brands;
            let brand_option = ``
            $.each(brands, function (key, value) {
              $('.brand_add').append(`
                  <option value="${value.id}">${value.name}</option>
                `);
            });



            // end brand

            let colors = response.data.colors;
            $.each(colors, function (key, value) {
              $('.color_add').append(`
                  <option value="${value.id}">${value.name}</option>
                `);
            });

            $('#mySelectDestrict').select2({
              placeholder: 'Select options',
              allowClear: true,
              tags: true,
            });

            $('#mySelectCities').select2({
              placeholder: 'Select options',
              allowClear: true,
              tags: true,
            });

          }
        }
      });
    }

    const StoreProduct = (form) => {
       $('.show-images').html("");
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('product.store') }}",
        data: payloads,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {

            $('#modalCreateProduct').modal('hide');
            $('#modalCreateProduct').modal('show');     // Hide the modal
            $('.modal-backdrop').remove();
            // Remove the overlay
             $('.show-images').html("");
            $("form").trigger('reset');                   // Reset all form inputs
            $('input').removeClass('is-invalid')
              .siblings('p')
              .removeClass('text-danger')
              .text("");                          // Clear validation messages
            Message(response.message)

            productList();
          } else {
            // let errors = response.error;

            // if(errors.title){
            //   $('.title_add').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.title);
            // }else{
            //   $('.title_add').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");
            // }

            // if(errors.price){
            //   $('.price_add').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.price);
            // }else{
            //   $('.price_add').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");
            // }
            //  if(errors.qty){
            //   $('.qty_add').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.qty);
            // }else{
            //   $('.qty_add').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");
            // }
            // Message(response.message , false);

            let errors = response.errors;
            let fields = ['title', 'price', 'qty', 'image'];

            fields.map(field => {
              let errorMsg = errors[field] ? errors[field][0] : '';
              let inputSelector = '.' + field + '_add';
              if (errorMsg) {
                $(inputSelector).addClass('is-invalid').siblings('p').addClass('text-danger').text(errorMsg)
              } else {
                $(inputSelector).removeClass('is-invalid')
                  .siblings('p').removeClass('text-danger')
                  .text('');
              }
            })
            Message(response.message, false)

          }
        }
      });
    }

    const deleteProduct = (id) => {
      $.ajax({
        type: "post",
        url: "{{ route('product.delete') }}",
        data: {
          id: id
        },
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            Message(response.message)
            productList();
          }

        }
      });
    }


  </script>

@endsection