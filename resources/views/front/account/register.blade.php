@extends('front.layouts.app')


@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> {{Session::get('success')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (Session::has('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> {{Session::get('errors')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="login-form">    
                <form action="#" method="post" name="registerFrom" id="registerFrom"> 
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p></p>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" >
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                        <p></p>
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div> 
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>			
                <div class="text-center small">Already have an account? <a href="{{route('account.login')}}">Login Now</a></div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    <script type="text/javascript">
      
       $('#registerFrom').submit(function(event){
        
            event.preventDefault();
            
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('account.processRegister' )}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);
                  if (response.status == true) {
                    $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#phone').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#password_confirmation').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(' ');
                    

                    window.location.href='{{route('account.login')}}'
                    
                  } else {
                        // Handle the response from the server
                    var errors = response.errors;
                   
                   
                   if(errors['name']){
                       $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
   
                   }else{
                       $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['email']){
                       $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
   
                   }else{
                    //    console.log('remove')
                       $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['phone']){
                       $('#phone').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['phone']);
   
                   }else{
                    //    console.log('remove')
                       $('#phone').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['password']){
                       $('#password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password']);
   
                   }else{
                    //    console.log('remove')
                       $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['password_confirmation']){
                       $('#password_confirmation').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password_confirmation']);
   
                   }else{
                    //    console.log('remove')
                       $('#password_confirmation').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(' ');
                   }
                   
                  }
                },
                error: function(){
                    console.log("Something went worg");
                }

            });

        });
    </script>
@endsection