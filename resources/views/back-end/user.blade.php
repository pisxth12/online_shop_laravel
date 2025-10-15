@extends('back-end.components.master')
@section('contens')

  <!-- Page Title Header Starts-->
  <div class="row page-title-header">
    <div class="col-12">
      <div class="page-header">
        <h4 class="page-title">Dashboard</h4>
        <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
          <ul class="quick-links">
            <li><a href="#">ICE Market data</a></li>
            <li><a href="#">Own analysis</a></li>
            <li><a href="#">Historic market data</a></li>
          </ul>
          <ul class="quick-links ml-auto">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Watchlist</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- Page Title Header Ends-->


  {{-- Modal start --}}
  @include('back-end.messages.user.create')
  {{-- Modal end --}}


  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title">Users</h4>
          <p data-bs-toggle="modal" data-bs-target="#modalCreateUser" class="card-description btn btn-primary ">new users
          </p>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="user_list">

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    //store users

    const StoreUser = (form) => {

      let payloads = new FormData($(form)[0])

      $.ajax({
        type: "POST",
        url: "{{ route('user.store') }}",
        data: payloads,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            $("#modalCreateUser").modal("hide");
            $(form).trigger("reset");

             $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');


            $("input").removeClass('is-invalid').siblings('p').removeClass('text-danger').text('');


            UserList();
            Message(response.message);

          }

          else {
            let errors = response.errors;
            if (errors.name) {
              $('.name').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.name);
            } else {
              $('.name').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");
            }
            if (errors.email) {
              $('.email').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.email);
            } else {
              $('.email').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");
            }
            if (errors.password) {
              $('.password').addClass('is-invalid').siblings('p').addClass('text-danger').text(errors.password);
            } else {
              $('.password').removeClass('is-invalid').siblings('p').removeClass('text-danger').text("");

            }
            // $.each(errors, function (key, value) { 
            //   $(`.${key}`).addClass('is-invalid').siblings('p').addClass('text-danger').text(value);
            // });

          }
        }
      });
    }

    const UserList = () => {
      $.ajax({
        type: "GET",
        url: "{{ route('user.list') }}",
        dataType: "json",
        success: function (response) {
          if (response.status == 200) {
            let users = response.users;
            let tr = "";
            $.each(users, function (key, value) {
              tr += `
                      <tr>
                          <td>${value.id}</td>
                          <td>${value.name}</td>
                          <td>${value.email}</td>
                          <td>${(value.role == 1) ? "admin" : "user"}</td>

                          <td>
                            <a href="#" class="btn btn-primary btn-sm">view</a>
                            <a href="javascript:void()" onclick="DeleteUser(${value.id})" class="btn btn-danger btn-sm">Delete</a>

                          </td>
                      </tr>
                     `;
            });
            $(".user_list").html(tr);
          }
        }
      });
    }
    UserList();

    const DeleteUser = (id) => {
      if (confirm('do you want to delete this user ?')) {
        $.ajax({
          type: "POST",
          url: "{{ route('user.delete') }}",
          data: {
            "id": id
          },
          dataType: "json",
          success: function (response) {
            if (response.status == 200) {
              UserList();
              Message(response.message);
            } else {
              message(response.message);
            }

          }
        });
      }

    }


  </script>
@endsection