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
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sitebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <div class="card-body p-4">
                            <form id="updateProfileForm" method="POST" action="{{ route('account.updateProfile') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">               
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control" value="{{ $user->name }}" disabled>
                                        <p></p>
                                    </div>

                                    <div class="mb-3">            
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control" value="{{ $user->email }}" disabled>
                                        <p></p>
                                    </div>
                                    <div class="mb-3">                                    
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control" value="{{ $user->phone }}" disabled>
                                        <p></p>
                                    </div>

                                </div>

                                <h3 class="h5 mb-3">Address Details</h3>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control" disabled>
                                                <option value="">Select a Country</option>
                                                @if ($countries->isNotEmpty())
                                                    @foreach ($countries as $country)
                                                        <option {{ !empty($customerAddress) && ($customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control" disabled>{{ !empty($customerAddress) ? $customerAddress->address : '' }}</textarea>
                                            <p></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ !empty($customerAddress) ? $customerAddress->apartment : '' }}" disabled>
                                            <p></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ !empty($customerAddress) ? $customerAddress->city : '' }}" disabled>
                                            <p></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ !empty($customerAddress) ? $customerAddress->state : '' }}" disabled>
                                            <p></p>
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ !empty($customerAddress) ? $customerAddress->zip : '' }}" disabled>
                                            <p></p>
                                        </div>            
                                    </div>   
                                </div>

                                <div class="d-flex">
                                    <button type="button" id="edit-button" class="btn btn-primary" onclick="enableEdit()">Edit</button>
                                    <button type="submit" id="update-button" class="btn btn-dark" style="display:none;">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
<script>
    function enableEdit() {
        document.getElementById('name').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
     

        document.getElementById('country').disabled = false;
        document.getElementById('address').disabled = false;
        document.getElementById('apartment').disabled = false;
        document.getElementById('city').disabled = false;
        document.getElementById('state').disabled = false;
        document.getElementById('zip').disabled = false;

        document.getElementById('edit-button').style.display = 'none';
        document.getElementById('update-button').style.display = 'block';
    }

    $('#updateProfileForm').submit(function(event){
            
            event.preventDefault();
            
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('account.updateProfile' )}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);
                 if (response.success) {
              
                    window.location.href = '{{route('account.profile')}}';

                }
               else {
                 var errors = response.errors;
                   //name error
                if(errors['name']){
                    $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                }else{
                   $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                }

                   //email error
                if(errors['email']){
                  $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                }else{
                  $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                  }

                  //phone error
                if(errors['phone']){
                  $('#phone').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['phone']);
                 }else{
                  $('#phone').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                }

                  //address errors
                if(errors['country']){
                  $('#country').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['country']);
                }else{
                  $('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                 }

                if(errors['address']){
                   $('#address').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['address']);
                }else{
                   $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                }
                if(errors['city']){
                   $('#city').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['city']);
                }else{
                  $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                }
                if(errors['state']){
                  $('#state').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['state']);
                }else{
                  $('#state').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                }
                if(errors['apartment']){
                  $('#apartment').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['apartment']);
                }else{
                  $('#apartment').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                }
                if(errors['zip']){
                  $('#zip').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['zip']);
                }else{
                  $('#zip').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
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
