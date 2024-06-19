@extends('admin.app')

@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{ route('users.update', $user->id) }}" method="POST" name="usersForm" id="usersForm">
             @csrf
             @method('PUT')
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{ $user->phone }}">
                                <p></p>	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                   <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                   <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Block</option>
                                </select>      
                            </div>
                        </div>	
                        
                        <!-- Password fields, hidden by default -->
                        <div class="col-md-12" id="password-fields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        <p></p>	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                                        <p></p>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Change Password button -->
                        <div class="col-md-12">
                            <button type="button" id="change-password-button" class="btn btn-secondary">Change Password</button>
                        </div>							
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customjs') 
<script type="text/javascript">
    $("#usersForm").submit(function(event) {
        event.preventDefault();
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route('users.update', $user->id) }}',
            type: 'put',
            data: $(this).serializeArray(), 
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response['status'] == true) {
                    window.location.href = "{{ route('users.index') }}";
                } else {
                    // Handle the response from the server
                    var errors = response.errors;
                   
                    if(errors['name']){
                        $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors['email']){
                        $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                    } else {
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors['phone']){
                        $('#phone').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['phone']);
                    } else {
                        $('#phone').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors['password']){
                        $('#password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password']);
                    } else {
                        $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            },
            error: function(jqXHR, exception) {
                console.log("Exception:", exception); 
            }
        });
    });

    // Toggle password fields visibility
    $('#change-password-button').click(function() {
        $('#password-fields').toggle();
    });
</script>
@endsection
