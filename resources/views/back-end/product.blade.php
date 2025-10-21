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


          <p data-bs-toggle="modal" data-bs-target="#modalCreateProduct" class="card-description btn btn-primary ">new
            product
          </p>
        </div>
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product image</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Brand</th>
              <th>Category</th>
              <th>Color</th>
              <th>User</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="Product_list">
            <tr>
              <td>P001</td>
              <td>iphone.jpg</td>
              <td>12 promax</td>
              <td>$100</td>
              <td>12</td>
              <td>iphnone</td>
              <td>phone</td>
              <td>red</td>
              <td>seth</td>
              <td>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                </div>



              </td>
              <td>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditProduct">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </td>
            </tr>

          </tbody>
        </table>
        <div class="d-flex mt-3">
          <div class="show_page"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
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
            let img = ``
            let images = response.images;
            $.each(images, function (key, value) {
              img += `
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 position-relative">
                        <div class="card border-0 shadow-sm text-center p-3 position-relative" 
                            style="border-radius: 15px; transition: 0.3s ease;">

                          <!-- Cancel (X) Button -->
                          <button
                            onclick="CancelImage(this,'${value}')"

                          type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 border bg-danger rounded-circle shadow-sm btn-remove" 
                                  style="width: 28px; height: 28px; line-height: 1; padding: 0; font-size: 16px;">
                            &times;
                          </button>

                          <input type="hidden" name="image" value="${value}">

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
                      </div>
                 `;
            });
            $('.show-images').html(`<div class="row">${img}</div>`);
          }
        }
      });
    }

    const CancelImage = (e,image)=>{
      if(confirm("Sure mf?")){
        $.ajax({
        type: "POST",
        url: "{{ route('image.cancel') }}",
        data: {
          image:image,
        },
        dataType: "json",
        success: function (response) {
          if(response.status == 200){
            Message(response.message)
            $(e).parent().remove();
          }
        }
      });
      }
    }

    

  </script>

@endsection