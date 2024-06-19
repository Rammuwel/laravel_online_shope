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
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sitebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>
                        <div class="card-body p-4">
                            @if ($wishlist->isNotEmpty())
                               @foreach ($wishlist as $item)

                                @php
                                  $productImage = grtProductImage($item->product_id);
                                @endphp
                                
                                <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                    <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                        <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('front.product', $item->product->slug) }}" style="width: 10rem;">
                                            @if (!empty($productImage))
                                            <img class="card-img-top" src="{{asset('upload/product/small/'.$productImage->image)}}" alt="">
                                            @else
                                            <img class="card-img-top" src="{{ asset('front-assets/images/product-1.jpg') }}" alt="">
                                            @endif
                                        </a>
                                        <div class="pt-2">
                                            <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">{{$item->product->title}}</a></h3>                                        
                                            <div class="price mt-2">
                                                <span class="h5"><strong>&#8377; {{$item->product->price}}</strong></span>
                                                @if ($item->product->compare_price > 0)
                                                <span class="h6 text-underline"><del>&#8377; {{$item->product->compare_price}}</del></span>  
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                        <button class="btn btn-outline-danger btn-sm" onclick="removeWishProduct({{$item->id}})" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                    </div>
                                </div>  
                                @endforeach
                            @else
                                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center text-danger">
                                   Your Product WishList is Empty.
                                </div>
                            @endif
                           
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customjs')
    <script type="text/javascript">
      function removeWishProduct(id) {
    var url = '{{route("account.removeWishProduct", ":id")}}';
    url = url.replace(':id', id); 
    $.ajax({
        url: url,
        type: 'delete',
        data: {},
        dataType: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            window.location.reload();
        },
        error: function(xhr, status, error) {

            alert(error);
            alert('An error occurred while removing the product.');
        }
    });
}

    </script>
@endsection