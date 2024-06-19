@extends('front.layouts.app')

@section('content')
      
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="section-11">
        <div class="container mt-5">
             @include('front.message')
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sitebar')
                </div>
                <div class="col-md-9 bg-white">
                    <form action="#" method="post" id="changePasswordForm" name="changePasswordForm">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="mb-2">               
                                <label for="name">Old Password</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-2">               
                                <label for="name">New Password</label>
                                <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-2">               
                                <label for="name">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-dark">Reset</button>
                            </div>
                        </div>
                    </div>
                 </form>
                </div>
            </div>
        </div>
@endsection

@section('customjs')
    <script type="text/javascript">
        $('#changePasswordForm').submit(function(event){
            
            event.preventDefault();
            
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '{{ route('account.processChangePassword' )}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);

                    if (response.status) {  
                        window.location.href = '{{route('account.changePassword')}}';
                    }
                   else {
                        var errors = response.errors;
                       //name error
                        if(errors['old_password']){
                            $('#old_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['old_password']);
                        }else{
                            $('#old_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                        }

                        //email error
                        if(errors['new_password']){
                        $('#new_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['new_password']);
                        }else{
                        $('#new_password').removeClass('is-invalid').siblings('p').removeClass ('invalid-feedback').html(""); 
                        }

                      //phone error
                      if(errors['confirm_password']){
                        $('#confirm_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['confirm_password']);
                      }else{
                        $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                        }
                    }
               
                }
            });
       

        });



    </script>
@endsection

