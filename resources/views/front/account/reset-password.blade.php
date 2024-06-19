@extends('front.layouts.app')


@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Login</li>
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
           @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> {{Session::get('error')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
           @endif
            <div class="login-form">    
                <form action="{{route('front.resetPasswordProcess')}}" method="post" name="loginFrom" id="loginFrom">
                    @csrf
                    <h4 class="modal-title">Reset Your Password</h4>
                    <input type="text" hidden name="token"  class="form-control" id="token" value="{{$token}}">
                    <div class="form-group">
                        <input type="password" name="password"   class="form-control @error('password') is-invalid @enderror" id="password" placeholder="New Password">
                        @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror"  id="confirm_password" placeholder="Confirm Password">
                        @error('confirm_password')
                        <p class="invalid-feedback">{{ $message }}</p>
                         @enderror
                    </div>
                    
                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Reset">              
                </form>			
            </div>
        </div>
    </section>
@endsection

@section('customjs')
   
@endsection