@extends('front.layouts.app')

@section('content')
    <section class="container">
        <div class="row-md-12 text-center mt-5">
            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success:</strong> {{Session::get('success')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <h1>Thank You!</h1>
            <p>Your Order Id is: {{$orderId}}</p>
        </div>
    </section>
@endsection