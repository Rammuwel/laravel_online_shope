@extends('front.layouts.app')


@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Forget Password</li>
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
                <form action="{{route('account.processForgetFassword')}}" method="post" name="loginFrom" id="loginFrom">
                    @csrf
                    <h4 class="modal-title">Forget Password</h4>
                    <div class="form-group">
                        <input type="text" name="email"  class="form-control @error('email') is-invalid @enderror"  placeholder="Email" id="email" value="{{old('email')}}">
                        @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                      @enderror
                    </div>
                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Send Mail">              
                </form>			
                <div class="text-center small">Back to login >> <a href="{{route('account.login')}}">Login</a></div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
   
@endsection