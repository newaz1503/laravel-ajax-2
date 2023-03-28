@extends('app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p id="show_success"></p>
                <div class="card">
                    <h5 class="card-header">User List
                        <a data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary float-end btn-sm">Add
                            User</a>

                    </h5>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Serial No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>


                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- add user Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul id="show_error"></ul>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" class="name form-control" id="exampleFormControlInput1"
                                placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="email form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input type="text" class="phone form-control" id="exampleFormControlInput1"
                                placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary add_user">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- add user Modal end -->

         <!-- edit user Modal -->
         <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <ul id="show_error"></ul>
                    <ul id="show_erro2r"></ul>
                    <div class="modal-body">
                        <input type="hidden" class="user_id">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" class="edit_name form-control" id="exampleFormControlInput1"
                                placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" class="edit_email form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input type="text" class="edit_phone form-control" id="exampleFormControlInput1"
                                placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update_user">Upadte</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit user Modal end -->

         <!-- delete user Modal -->
         <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" class="deluser_id">
                        <h5>Are you sure delete this user ?!!</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary delete_user_btn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete user Modal end -->
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
             //get user
            function getUser(){
                $.ajax({
                    type: 'GET',
                    url:'/users',
                    dataType:'json',
                    success: function (response) {
                        $("tbody").html('');
                        $.each(response.users, function(key, value){
                            $("tbody").append('<tr>\
                                <td>'+value.id+'</td>\
                                <td>'+value.name+'</td>\
                                <td>'+value.email+'</td>\
                                <td>'+value.phone+'</td>\
                                <td><button type="button" value="'+value.id+'" class="edit_user btn btn-primary btn-sm">Edit</button></td>\
                                <td><button type="button" value="'+value.id+'" class="delete_user btn btn-danger btn-sm">Delete</button></td>\
                            </tr>');
                        });
                     }
                });
            }
            getUser();

            //store user
            $(document).on('click', '.add_user', function(e) {
                e.preventDefault();
                let data = {
                    'name': $(".name").val(),
                    'email': $(".email").val(),
                    'phone': $(".phone").val()
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:"POST",
                    url:"/user/store",
                    data: data,
                    dataType: "json",
                    success: function(response){
                        getUser();
                        if(response.status == 400){
                            $("#show_error").html('');
                            $("#show_error").addClass('alert alert-danger');
                            $.each(response.errors, function(key, value){
                                $("#show_error").append('<li>'+value+'</li>')
                            })
                        }else{
                            $("#show_error").html('');
                            $("#show_success").addClass('alert alert-success');
                            $("#show_success").text(response.success);
                            $("#addUserModal").modal('hide');
                            $("#addUserModal").find('input').val('');
                        }
                    }
                })
            })
            //edit user
            $(document).on('click', '.edit_user', function(e){
                e.preventDefault();
                let userId = $(this).val();

                $('#editUserModal').modal('show');
                $.ajax({
                    type: "GET",
                    url:"/edit-user/"+userId,
                    dataType: 'json',
                    success: function(res){
                        if(res.status == 400){
                            $('#error_msg').html('');
                            $('#error_msg').addClass('alert alert-danger');
                            $('#error_msg').text(res.errorMsg);
                        }else{
                            $("#show_erro2r").html('');
                            $('.user_id').val(userId);
                            $('.edit_name').val(res.user.name);
                            $('.edit_email').val(res.user.email);
                            $('.edit_phone').val(res.user.phone);
                        }
                    }
                })
            })
            //update user
            $(document).on('click', '.update_user', function (e) {
                e.preventDefault();
                let userId = $('.user_id').val();
                $(this).text('updating')
                let data = {
                    'name': $(".edit_name").val(),
                    'email': $(".edit_email").val(),
                    'phone': $(".edit_phone").val()
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "/user-update/"+userId,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                       if(response.status == 400){
                             $("#show_erro2r").html('');
                            $("#show_erro2r").addClass('alert alert-danger');
                            $.each(response.errors, function(key, value){
                                $("#show_erro2r").append('<li>'+value+'</li>')
                            })
                            $('.update_user').text('Update');
                       }else if(response.status == 404){
                          $("#show_erro2r").html('');
                           $("#show_success").html('');
                           $("#show_success").addClass('alert alert-danger');
                           $("#show_success").text(response.errorMsg);
                           $('.update_user').text('Update')
                       }else{
                            $("#show_erro2r").html('');
                           $("#show_success").html('');

                           $("#show_success").addClass('alert alert-success');
                           $("#show_success").text(response.success);
                           $('#editUserModal').modal('hide');
                           $('.update_user').text('Update')
                           getUser();
                       }
                    }
                });
            });
            // delete user
            $(document).on('click', '.delete_user', function (e) {
                $("#deleteUserModal").modal('show')
                let delete_user_id = $(this).val();
                $('.deluser_id').val(delete_user_id);

            });

            $(document).on('click', '.delete_user_btn', function (e) {
                e.preventDefault();
                $(this).text('Deleting..')
                let userId = $('.deluser_id').val();
                $.ajax({
                    type: "get",
                    url:"/user-delete/"+userId,
                    dataType: "json",
                    success: function (response) {
                        getUser();
                        if(response.status == 200){
                            $('#show_success').html('')
                            $('#show_success').addClass('alert alert-success')
                            $('#show_success').text(response.success)
                            $('.delete_user').text('Delete')
                            $('#deleteUserModal').modal('hide')
                        }
                    }
                });
            });
        })
    </script>
@endpush
