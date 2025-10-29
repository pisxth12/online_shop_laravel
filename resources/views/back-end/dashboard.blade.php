@extends('back-end.components.master')
@section('contens')
    <div class="row">
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
            <div class="col-md-12">
                <div class="page-header-toolbar">
                    <div class="btn-group toolbar-item" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary"><i class="mdi mdi-chevron-left"></i></button>
                        <button type="button" class="btn btn-secondary">03/02/2019 - 20/08/2019</button>
                        <button type="button" class="btn btn-secondary"><i class="mdi mdi-chevron-right"></i></button>
                    </div>
                    <div class="filter-wrapper">
                        <div class="dropdown toolbar-item">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownsorting"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Day</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownsorting">
                                <a class="dropdown-item" href="#">Last Day</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">Last Year</a>
                            </div>
                        </div>
                        <a href="#" class="advanced-link toolbar-item">Advanced Options</a>
                    </div>
                    <div class="sort-wrapper">
                        <button type="button" class="btn btn-primary toolbar-item">New</button>
                        <div class="dropdown ml-lg-auto ml-3 toolbar-item">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownexport"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Export</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownexport">
                                <a class="dropdown-item" href="#">Export as PDF</a>
                                <a class="dropdown-item" href="#">Export as DOCX</a>
                                <a class="dropdown-item" href="#">Export as CDR</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="d-flex">
                                <div class="wrapper">
                                    {{-- <h3 class="mb-0 font-weight-semibold">32,451</h3> --}}
                                    <h3 class="mb-0 font-weight-semibold">{{ App\Models\User::count() }}</h3>

                                    <h5 class="mb-0 font-weight-medium text-primary">Visits</h5>
                                    <p class="mb-0 text-muted">+14.00(+0.50%)</p>
                                </div>
                                <div class="wrapper my-auto ml-auto ml-lg-4">
                                    <canvas height="50" width="100" id="stats-line-graph-1"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                            <div class="d-flex">
                                <div class="wrapper">
                                    <h3 class="mb-0 font-weight-semibold">15,236</h3>
                                    <h5 class="mb-0 font-weight-medium text-primary">Impressions</h5>
                                    <p class="mb-0 text-muted">+138.97(+0.54%)</p>
                                </div>
                                <div class="wrapper my-auto ml-auto ml-lg-4">
                                    <canvas height="50" width="100" id="stats-line-graph-2"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                            <div class="d-flex">
                                <div class="wrapper">
                                    <h3 class="mb-0 font-weight-semibold">7,688</h3>
                                    <h5 class="mb-0 font-weight-medium text-primary">Conversation</h5>
                                    <p class="mb-0 text-muted">+57.62(+0.76%)</p>
                                </div>
                                <div class="wrapper my-auto ml-auto ml-lg-4">
                                    <canvas height="50" width="100" id="stats-line-graph-3"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                            <div class="d-flex">
                                <div class="wrapper">
                                    <h3 class="mb-0 font-weight-semibold">1,553</h3>
                                    <h5 class="mb-0 font-weight-medium text-primary">Downloads</h5>
                                    <p class="mb-0 text-muted">+138.97(+0.54%)</p>
                                </div>
                                <div class="wrapper my-auto ml-auto ml-lg-4">
                                    <canvas height="50" width="100" id="stats-line-graph-4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Page Title Header Ends-->
        {{-- Modal start --}}
        @include('back-end.messages.user.create')
        {{-- Modal end --}}


        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Users</h4>
                        <p data-bs-toggle="modal" data-bs-target="#modalCreateUser"
                            class="card-description btn btn-primary ">new users
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