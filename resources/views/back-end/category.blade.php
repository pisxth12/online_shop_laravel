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
  @include('back-end.messages.category.create')
  {{-- Modal end --}}
  @include('back-end.messages.category.edit')

  {{-- table start --}}

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        @include('back-end.messages.alert.alert')

        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Category</h4>
          <p data-bs-toggle="modal" data-bs-target="#modalCreateCategory" class="card-description btn btn-primary ">new
            category
          </p>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Category ID</th>
              <th>Image</th>
              <th>Category Name</th>
              <th>Category title</th>
              <th>Status</th>
              <th>Ation</th>
            </tr>
          </thead>
          <tbody class="category_list">

          </tbody>

        </table>
        <div class="show_page mt-3">

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script>
    let gif = "https://juststickers.in/wp-content/uploads/2016/12/404-error-not-found-badge.png"

    const UploadImage = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('category.upload') }}",
        data: payloads,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.status == 200) {


            $('.show-image-category').html(`
                   <input type="hidden" name="category_image" value="${response.image}">
                     <img width="100" src="uploads/temp/${response.image}" alt="">
                     <input type="hidden" name="image" value="uploads/temp/${response.image}">
                      <button type="button" onclick="CancelImage('${response.image}')" class="btn btn-danger btn_upload">Cancel</button>
                   `);


            $('.image').removeClass('is-invalid').removeClass('border-danger').siblings('p').removeClass('text-danger').text('');

          } else {
            let errors = response.errors;
            $('.image')
              .addClass('is-invalid')
              .addClass('border-danger')
              .siblings('p')
              .addClass('text-danger')
              .text(errors.image);
          }

        }
      });
    }

    const CancelImage = (img) => {
      if (confirm('Are you sure to cancel this image?')) {
        $.ajax({
          type: "POST",
          url: "{{ route('category.cancel.image') }}",
          data: {
            image: img
          },
          success: function (response) {
            if (response.status == 200) {
              $('.show-image-category').html(``);
              Message(response.message);
            }
          }
        });

      }
    }

    const StoreCatecory = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('category.store') }}",
        data: payloads,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.status == 200) {
            $('#modalCreateCategory').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');

            $(form).trigger('reset');
            $('.show-image-category').html('');
            Message(response.message);
            CategoryList();
          }
          else {
            let errors = response.errors;
            $('.name')
              .addClass('is-invalid')
              .siblings('p')
              .addClass('text-danger')
              .text(errors.name);
          }
        }
      });
    }

    const CategoryList = (page=1) => {
      $.ajax({
        type: "GET",
        url: "{{ route('category.list') }}",
        data:{
          page:page
        },
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            let categories = response.categories;
            let html = '';
            $.each(categories, function (key, value) {

              html += `
                    <tr>
                      <td>${value.id}</td>
                      <td><img width="100" src="/uploads/category/${value.image}" style="object-fit: cover"  alt=""></td>
                      <td>${value.name}</td>
                      <td>${(value.title.length > 5) ? value.title.slice(0,6)+"..." : value.title}</td>

                      <td>${value.status == 1 ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>'}</td>
                      <td>
                        <button  class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditCategory" onclick="categoryEdit(${value.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCategory(${value.id})">Delete</button>
                      </td>
                    </tr>
                  `;
              $('.category_list').html(html);

              let totalPage = response.pages.totalPage;
              let currentPage = response.pages.currentPage;
              let page = ``;
              page = `
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item ${(currentPage==1)? 'd-none':'block'}" onclick="PreviousPage(${currentPage})" >
                    <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>`
                 for(let i=1 ; i<=totalPage ;i++){
                  page+=`
                       <li onclick="CategoryPage(${i})" class="page-item ${(i==currentPage) ? 'active':'block'}">
                          <a class="page-link" href="javascript:void(0)">${i}</a>
                        </li>
                  `;
                 }
                page +=` <li onclick="NextPage(${currentPage})" class="page-item ${(currentPage==totalPage)? 'd-none':'block'}" >
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
              `; 
              $('.show_page').html(page)
            });
          }
        }
      });
    }
    CategoryList();

    const CategoryPage = (page) =>{
      CategoryList(page)
    }

    const NextPage = (page) =>{
     CategoryPage(page+1)
    }
    const PreviousPage =(page)=>{
      CategoryPage(page-1)
    }


    const deleteCategory = (id) => {
      if (confirm('Are you sure to delete this category?')) {
        $.ajax({
          type: "POST",
          url: "{{ route('category.delete') }}",
          data: { id: id },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Message(response.message);
              CategoryList();
            }
            else {
              alert(response.message)
            }
          }
        });
      }
    }


    const categoryEdit = (id) => {
      $.ajax({
        type: "POST",
        url: "{{ route('category.edit') }}",
        data: { id: id },
        dataType: "json",
        success: function (response) {
          let imageUrl = response.category.image ?
            `/uploads/category/${response.category.image}` : gif;
          if (response.status == 200) {
            $('.name_edit').val(response.category.name);
            $('.title_edit').val(response.category.title);
            $("#category_id").val(response.category.id);
            // $("#category_id").val(response.category.id);


            if (response.category.image != "") {
              let img = `
                      <input type="hidden" name="old_image" value="${response.category.image}"> 
                      <p>Old image</p>
                      <img width="100" src="${imageUrl}" alt="">
                `;
              $('.show-image-category_edit').html(img);
            }
            $('.status_edit').val(response.category.status);
          }
        }
      });
    }

    const UpdateCategory = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('category.update') }}",
        data: payloads,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.status == 200) {
            $('#modalEditCategory').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');

            $(form).trigger('reset');
            $('.show-image-category_edit').html('');
            Message(response.message);
            CategoryList();
          }
          else {
            let errors = response.errors;
            $('.name_edit')
              .addClass('is-invalid')
              .siblings('p')
              .addClass('text-danger')
              .text(errors.name);
          }
        }
      });
    }

  </script>
@endsection