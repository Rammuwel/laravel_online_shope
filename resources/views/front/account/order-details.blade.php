@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('account.profile')}}">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sitebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                    </div>

                    <div class="card-body pb-0">
                        <!-- Info -->
                        <div class="card card-sm">
                            <div class="card-body bg-light mb-3">
                                <div class="row">
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h6 class="heading-xxxs text-muted ">Order No:</h6>
                                        <!-- Text -->
                                        <p class="mb-lg-0 fs-sm fw-bold ">
                                         {{$order->id}}
                                        </p>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h6 class="heading-xxxs text-muted ">Shipped date:</h6>
                                        <!-- Text -->
                                        <p class="mb-lg-0 fs-sm fw-bold">
                                            <time datetime="2019-10-01">
                                                {{Carbon\Carbon::parse($order->shipped_at)->format('d M, y')}}
                                            </time>
                                        </p>
                                    </div>
                                    <div class="col-6 col-lg-3 ">
                                        <!-- Heading -->
                                        <h6 class="heading-xxxs text-muted ">Status:</h6>
                                        <!-- Text -->
                                        @if ($order->status == 'panding')
                                            <span class="badge bg-success">{{$order->status}}</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">{{$order->status}}</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">{{$order->status}}</span>
                                        @else
                                            <span class="badge bg-success">{{$order->status}}</span>
                                        @endif
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                        <!-- Text -->
                                        <p class="mb-0 fs-sm fw-bold ">
                                        &#8377; {{number_format($order->grand_total, 2)}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-3">

                        <!-- Heading -->$itemsCount
                        <h6 class="mb-7 h5 mt-4">Order Items {{$order->coupon_code > 0 ?'('.$itemsCount.')':''}}</h6>

                        <!-- Divider -->
                        <hr class="my-3">

                        <!-- List group -->
                        <ul>
                            @if ($orderItems->isNotEmpty())
                            @foreach ($orderItems as $item)
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-4 col-md-3 col-xl-2">
                                        <!-- Image -->
                                        {{-- <a href="product.html"><img src="images/product-1.jpg" alt="..." class="img-fluid"></a> --}}
                                        @php
                                         $productImage =  grtProductImage($item->id);
                                        @endphp
                                         @if (!empty($productImage))
                                         <img class="img-fluid" src="{{asset('upload/product/small/'.$productImage->image)}}" alt="">
                                         @else
                                         <img class=" img-fluid" src="{{ asset('front-assets/images/product-1.jpg') }}" alt="">
                                         @endif

                                    </div>
                                    <div class="col">
                                        <!-- Title -->
                                        <p class="mb-4 fs-sm fw-bold">
                                            <a class="text-body" href="product.html">{{$item->name}}</a> <br>
                                            <span class="text-muted">&#8377; {{number_format($item->price)}}</span>
                                        </p>
                                    </div>
                                </div>
                            </li>  
                            @endforeach   
                            @endif
                            
                        </ul>
                    </div>                      
                </div>
                
                <div class="card card-lg mb-5 mt-3">
                    <div class="card-body">
                        <!-- Heading -->
                        <h6 class="mt-0 mb-3 h5">Order Total</h6>

                        <!-- List group -->
                        <ul>
                            <li class="list-group-item d-flex">
                                <span>Subtotal</span>
                                <span class="ms-auto"> &#8377; {{number_format($order->subtotal,2)}}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Discount{{$order->coupon_code ?'('.$order->coupon_code.')':''}}</span>
                                <span class="ms-auto"> &#8377; {{number_format($order->descount, 2)}}</span>
                            </li>
                            {{-- <li class="list-group-item d-flex">
                                <span>Tax</span>
                                <span class="ms-auto"> &#8377; {{number_format(0.00, 2)}}</span>
                            </li> --}}
                            <li class="list-group-item d-flex">
                                <span>Shipping</span>
                                <span class="ms-auto"> &#8377; {{number_format($order->shipping, 2)}}</span>
                            </li>
                            <li class="list-group-item d-flex fs-lg fw-bold">
                                <span>Total</span>
                                <span class="ms-auto"> &#8377; {{number_format($order->grand_total, 2)}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customjs')
    
@endsection