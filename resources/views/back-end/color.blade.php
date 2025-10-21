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
  @include('back-end.messages.color.create')
  {{-- Modal end --}}
  @include('back-end.messages.color.edit')

  {{-- table start --}}

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Color</h4>
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


          <p data-bs-toggle="modal" data-bs-target="#modalCreateColor" class="card-description btn btn-primary ">new
            Color
          </p>
        </div>
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>Color ID</th>
              <th>Color Name</th>
              <th>Color Code</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="Color_list">

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


    //search color
    $(document).on('click', '.btnSearch_color', function () {
      let search = $('.search_color_box').val();

      ColorList('1', search)

    });
    $('.search_color_box').on('keypress', function (e) {
      if (e.which == 13) { // enter key
        let search = $(this).val();
        ColorList(1, search);
      }
    });



    const ColorStore = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('color.store') }}",
        data: payloads,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            const modalEl = document.getElementById('modalCreateColor');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            setTimeout(() => {
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
              document.body.classList.remove('modal-open');
              document.body.style.paddingRight = '';
            }, 300);

            $(".name_color").removeClass("is-invalid")
              .siblings('p').removeClass('text-danger').text("");
            Message(response.message);
            ColorList()


            $(".name").removeClass("is-invalid").siblings('p').removeClass('text-danger').text("");
          } else {
            let error = response.error;
            $(".name").addClass("is-invalid").siblings('p').addClass('text-danger').text(error.name);
          }

        }
      });
    }

    const ColorList = (page = 1, search = "") => {
      $.ajax({
        type: "GET",
        url: "{{ route('color.list') }}",
        data: {
          search: search,
          page: page
        },
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            let color = ``;
            let colors = response.colors;

            if (colors.length > 0) {
              $.each(colors, function (key, value) {
                color += `
                               <tr>
                                  <td>B${value.id}</td>
                                  <td>${value.name}</td>
                                  <td><div class="rounded-circle border border-dark p-1" style="width: 20px; height: 20px; background-color: ${value.color_code};" ></div></td>
                                  <td>${value.status == 1 ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>'}</td>
                                  <td>
                                      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateColor" onclick="colorEdit(${value.id},'${value.name.replace(/'/g, "\\'")}','${value.color_code}')">Edit</button>
                                      <button class="btn btn-danger" onclick="deleteColor(${value.id})" >Delete</button> </td>
                                </tr>
                              `;
              });
            } else {
              color += `<tr><td colspan="5" class="text-center"><h1>No Color found</h1></td></tr>`;
            }

            $('.Color_list').html(color);

            //paginate
            let totalPage = response.page.totalPage;
            let currentPage = response.page.currentPage;
            let page = ``;
            page = `
               <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li onclick="PreviousPage(${currentPage})" class="page-item ${(currentPage == 1) ? 'd-none' : ''}">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                    `
            for (let i = 1; i <= totalPage; i++) {
              page += `
                      <li class="page-item ${(i == currentPage) ? 'active' : 'block'}" onclick="ColorPage(${i})" >
                        <a class="page-link" href="javascript:void(0)">${i}</a>
                      </li>
                      `;
            }

            page += `
                      <li onclick="NextPage(${currentPage})" class="page-item ${(currentPage == totalPage) ? 'd-none' : 'block'}">
                        <a class="page-link" href="javascript:void(0)" aria-label="Next">
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
    ColorList()

    const ColorPage = (page) => {
      ColorList(page);
    }
    const NextPage = (page) => {
      ColorPage(page + 1);
    }
    const PreviousPage = (page) => {
      ColorPage(page - 1);
    }




    const deleteColor = (id) => {
      if (confirm('Are you sure want to delete this')) {
        $.ajax({
          type: "POST",
          url: "{{ route('color.delete') }}",
          data: {
            id: id
          },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              ColorList()
              Message(response.message)
            }

          }
        });
      }
    }

    const colorEdit = (id, name, color) => {
      $('#color_id').val(id)
      $('.name_color').val(name);
      $('.color_edit').val(color);
    }

    const UpdateColor = (form) => {
      let payloads = new FormData($(form)[0]);
      $.ajax({
        type: "POST",
        url: "{{ route('color.update') }}",
        data: payloads,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
          const modalEl = document.getElementById('modalUpdateColor');
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
          ColorList()
        }
      });
    }


  </script>
@endsection