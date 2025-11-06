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
  @include('back-end.messages.banner.create')
  {{-- Modal end --}}
  @include('back-end.messages.banner.edit')

  {{-- table start --}}

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Banner</h4>
          <div class="form-group">
            <div class="search-content border-l-2">
              <div class=" d-flex gap-2">
                <div class="search-content d-flex justify-content-between border align-items-center">

                  <input type="text" name="search_Banner" placeholder="Search..."
                    class="search_Banner_box form-control border-0 search_box">

                  <i class="bi bi-search search_icon px-2 btnSearch_Banner"></i>
                </div>
                <div type="button" id="btnSearch_Banner"
                  class="btn btn-primary btnSearch_Banner text-center d-flex justify-content-center align-items-center">
                  Search</div>
              </div>

            </div>
          </div>
          </form>


          <p data-bs-toggle="modal" data-bs-target="#modalCreateBanner" class="card-description btn btn-primary ">new
            Banner
          </p>
        </div>
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>Banner ID</th>
              <th>Banner Image</th>
              <th>Banner title</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
         <tbody class="Banner_list">
                   <tr>
                        <td>B1</td>
                        <td>
                            <img src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg" alt="" width="50">
                        </td>
                        <td>
                            <p>Lorem ipsum dolor sit amet.</p>
                        </td>
                        <td><label class="badge badge-success">Active</label></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateBanner">Edit</button>
                            
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
    const storeBanner = (form) => {
        let payloads = new FormData($(form)[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('banner.store') }}",
            data: payloads,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                
            }
        });
    }

    const UploadImage = (form) => {
    let payloads = new FormData($(form)[0]);
    $.ajax({
      type: "POST",
      url: "{{ route('banner.upload') }}",
      data: payloads,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if(response.status == 200){
        
          // banner preview
           $('.banner_preview').html(`
                    <div class="card border">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="/${response.path}" 
                                     alt="Banner Preview" 
                                     class="img-thumbnail"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="flex-grow-1">
                                   
                                    <h6 class="mb-0 text-muted small">${response.image}</h6>
                                    <button type="button" 
                                            onclick="removePreview()" 
                                            class="btn btn-sm btn-danger mt-2">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="banner_image" value="${response.image}">
                `);


                $('.image').removeClass('is-invalid').removeClass('border-danger').siblings('p').removeClass
                ('text-danger').text('');
                
        }
        else{
            let errors = response.errors;
            $('.image')
            .addClass('is-invalid')
            .addClass('border-danger')
            .siblings('p')
            .addClass('text-danger')
            .text(errors.image);
            console.log(errors.image);
        }
      }
    });
}

  </script>
@endsection