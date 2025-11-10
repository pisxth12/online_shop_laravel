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
                  {{-- result here --}}


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

    // upload image
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
                                            onclick="cancelBanner('${response.image}')"
                                            class="btn btn-sm btn-danger mt-2">
                                        <i class="bi bi-trash"></i> 
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="banner_image" value="${response.image}">
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
                if(response.status == 200){
                    $('#modalCreateBanner').modal('hide');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $(form).trigger('reset');
                    Message(response.message);
                    bannerList();
                }
                else{ 
                    let errors = response.errors;
                $('.title')
                    .addClass('is-invalid')
                    .siblings('p')
                    .addClass('text-danger')
                    .text(errors.title);
                    console.log(errors.title);
                }
                
            }
        });
    }


    const bannerList = (page=1) => {
      $.ajax({
        type: "GET",
        url: "{{ route('banner.list') }}",
        data:{
          page:page
        },  
        dataType: "json",
        success: function (response) {
          if(response.status == 200){
           console.log(response.message);
           let banners = response.banners;
           let html = '';
          
           $.each(banners, function (key, value) { 
             html += `
               <tr>
                        <td>B${value.id}</td>
                        <td>
                            <img src="{{ asset('uploads/banner/${value.image}') }}" alt="" width="50">
                        </td>
                        <td>
                            <p>${value.title.substring(0,10)+'..'}</p>
                        </td>
                        <td><label class="badge ${value.status == 1 ? 'badge-success' : 'badge-danger'  } ">${value.status == 1 ? 'Active' : 'Inactive'}</label></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateBanner" onclick="bannerEdit(${value.id})">Edit</button>
                            
                            <button onclick="deleteBanner(${value.id})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
             `;
             $('.Banner_list').html(html);
             let totalPage = response.pages.totalPage;
             let currentPage = response.pages.currentPage;
              
              let page = ``;
              page +=`
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item ${(currentPage==1)? 'd-none':'block'}" >
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>`
                  
                  for(let i=1 ; i<=totalPage ;i++){
                    page += `
                      <li onclick="bannerPage(${i})" class="page-item ${(i==currentPage) ? 'active':'block'}" >
                        <a class="page-link" href="javascript:void(0)">${i}</a>
                      </li> 
                    `
                  }
                  
             page +=   ` <li class="page-item ${(currentPage==totalPage)? 'd-none':'block'}"">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
              `; 
              $('.show_page').html(page);

           });
                      
          }
        }
      });
    }
    bannerList();
    const NextPage = (page) =>{
      bannerList(page+1)
     }
     const PreviousPage =(page)=>{
       bannerList(page-1)
     }
     const bannerPage = (page) =>{
      bannerList(page)
    }
    const deleteBanner = (id) => {
      if (confirm('Are you sure to delete this banner?')) {
        $.ajax({
          type: "POST",
          url: "{{ route('banner.delete') }}",
          data: { id: id },
          dataType: "json",
          success: function (response) {
            if(response.status == 200){
              Message(response.message);
              bannerList();
            }

          }
      })
    }
  }

  const cancelBanner = (img) =>{

    $.ajax({
      type: "post",
      url: "{{ route('banner.cancel.image') }}",
      data:{
        image:img
      },
      dataType: "json",
      success: function (response) {
        $('.banner_preview').html('');
        $('input').val('');
        Message(response.message);      
      

      }
    });
  }


  const bannerEdit = (id) => {
    $.ajax({
      type: "post",
      url: "{{ route('banner.edit') }}",
      data: {
        id: id
      },
      dataType: "json",
      success: function (response) {
        if(response.status ==200){
          let banner = response.banner;
          $('#banner_id').val(banner.id);
          $('.title_edit').val(banner.title);
          $('.status_edit').val(banner.status);
          if(banner.image != ""){
            let img = `
             <div class="card border">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('uploads/banner/${banner.image}') }}" 
                                     alt="Banner Preview" 
                                     class="img-thumbnail"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="flex-grow-1">
                                   
                                    <h6 class="mb-0 text-muted small">${banner.image}</h6>
                                    <button type="button" 
                                            onclick="cancelBanner('${banner.image}')"
                                            class="btn btn-sm btn-danger mt-2">
                                        <i class="bi bi-trash"></i> 
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="banner_image" value="${banner.image}">
            `;
            $('.show-image-banner_edit').html(img);
          }
          else{
            $('.show-image-banner_edit').html('');
          }

        }
      }
    });
  }
  const UpdateBanner = (form) => {
    let payloads = new FormData($(form)[0]);
    $.ajax({
     type: "POST",
      url: "{{ route('banner.update') }}",
      data: payloads,
      processData: false,
      contentType: false,
      dataType: "json", 
      success: function (response) {
        if(response.status == 200){
          $('#modalUpdateBanner').modal('hide');
          $('.modal-backdrop').remove();
          $('body').removeClass('modal-open');
          Message(response.message);
          $(form).trigger('reset');
          bannerList();
        }
       
       
        }
      
    });

  }
  
  

   
  </script>
@endsection