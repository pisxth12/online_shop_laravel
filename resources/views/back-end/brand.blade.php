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
  @include('back-end.messages.brand.create')
  {{-- Modal end --}}
  @include('back-end.messages.brand.edit')

  {{-- table start --}}


  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Brand</h4>
          <p data-bs-toggle="modal" data-bs-target="#modalCreateBrand" class="card-description btn btn-primary ">new
            Brand
          </p>
        </div>
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>Brand ID</th>
              <th>Brand Name</th>
              <th>Category Name</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="brand_list">
            {{-- result here --}}
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center ">
          <div class="show_page mt-3 d-flex"></div>

          <div id="brandRefresh"  style="cursor: pointer"><i class="bi bi-arrow-clockwise text-2xl px-3" style="font-size: 20px"></i></div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>



    $(document).on('click', '.btnSearch', function () {
      let container = $(this).closest('.modal, .search-form');
      let searchValue = container.find('.search_box').val();
      BrandList('1', searchValue);
      if (container.hasClass('modal')) {
        container.hide();
        $('.modal-backdrop').remove();
      }
    });

    //refresh list
    $(document).on('click','#brandRefresh',function(){
      BrandList();
    });


    const BrandStore = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('brand.store') }}",
        data: payloads,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            const modalEl = document.getElementById('modalCreateBrand');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            setTimeout(() => {
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
              document.body.classList.remove('modal-open');
              document.body.style.paddingRight = '';
            }, 300);

            $(".name_brand").removeClass("is-invalid")
              .siblings('p').removeClass('text-danger').text("");
            Message(response.message);
            BrandList()

            $(".name").removeClass("is-invalid").siblings('p').removeClass('text-danger').text("");
          } else {
            let error = response.error;
            $(".name").addClass("is-invalid").siblings('p').addClass('text-danger').text(error.name);
          }

        }
      });
    }

    const BrandList = (page = 1, search = "") => {
      $.ajax({
        type: "GET",
        url: "{{ route('brand.list') }}",
        data: {
          "page": page,
          "search": search
        },
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {

            let brands = response.brands;
            let html = "";
            if (brands.length > 0) {
              $.each(brands, function (key, value) {
                html += `
                            <tr>
                                <td>${value.id}</td>
                                <td>${value.name}</td>
                                <td>${value.category.name}</td>
                                <td>${value.status == 1 ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>'}</td>
                                <td>
                                   <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateBrand" onclick="editBrand(${value.id},'${value.name}')">Edit</button>
                                   <button class="btn btn-danger" onclick="deleteBrand(${value.id})">Delete</button> </td>
                              </tr>
                         `;
              });
            } else {
              html = `<tr><td colspan="5" class="text-center"><h1>No brands found</h1></td></tr>`;
            }
            $('.brand_list').html(html);

            // pageginator
            let page = ``;
            let totalPage = response.page.totalPage;
            let currentPage = response.page.currentPage;
            page = `
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : 'block'}">
                        <a  class="page-link " href="javascript:void(0)" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>`

            for (let i = 1; i <= totalPage; i++) {
              page += `
                         <li onclick="BrandPage(${i})" class="page-item ${(i == currentPage) ? 'active' : 'block'}">
                            <a class="page-link" href="javascript:void(0)">${i}</a>
                          </li>
                           `;
            }
            page += ` <li class="page-item ${(currentPage == totalPage) ? 'd-none' : 'block'}" onclick="NextPage(${currentPage})">
                        <a  class="page-link " href="javascript:void(0)" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>

                 `;
            $('.show_page').html(page);
          }

        }
      });
    }
    
    BrandList();

    const BrandPage = (page) => {
      BrandList(page);
    }
    
    const NextPage = (page) => {
      BrandPage(page + 1);
    }

    const PreviousPage = (page) => {
      BrandPage(page - 1)
    }

    const deleteBrand = (id) => {
      if (confirm('are you want to delete this')) {
        $.ajax({
          type: "POST",
          url: "{{ route('brand.delete') }}",
          data: { id: id },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              Message(response.message);
              BrandList();
            }
          }
        });
      }
    }

    const editBrand = (id, name) => {
      $(".name_edit").val(name);
      $("#brand_id").val(id);
    }

    const BrandUpdate = (form) => {
      let payloads = new FormData($(form)[0]);

      $.ajax({
        type: "POST",
        url: "{{ route('brand.update') }}",
        data: payloads,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.status == 200) {

            const modalEl = document.getElementById('modalUpdateBrand');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            setTimeout(() => {
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
              document.body.classList.remove('modal-open');
              document.body.style.paddingRight = '';
            }, 300);

            $(".name_brand").removeClass("is-invalid")
              .siblings('p').removeClass('text-danger').text("");

            Message(response.message);
            BrandList();

          }
        }
      });
    };
    
  </script>

@endsection