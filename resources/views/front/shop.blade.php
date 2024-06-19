@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-6 pt-5">
    <div class="container">
        <div class="row">            
            <div class="col-md-3 sidebar">
                <div class="sub-title">
                    <h2>Categories</h3>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="accordion accordion-flush" id="accordionExample">
                            @if ($categories->isNotEmpty())
                               @foreach ($categories as $key => $category)
                                    <div class="accordion-item">
                                        @if ($category->sub_category->isNotEmpty())
                                        <h2 class="accordion-header" id="headingOne-{{$key}}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$key}}" aria-expanded="false" aria-controls="collapseOne-{{$key}}">
                                                {{$category->name}}
                                            </button>
                                        </h2>
                                        @else
                                         <a href="{{route('front.shop', $category->slug)}}" class="nav-item nav-link {{ $categorySelected == $category->id ? 'text-primary' : ''}}">{{$category->name}}</a>
                                        @endif 
                                        @if ($category->sub_category->isNotEmpty())
                                          <div id="collapseOne-{{$key}}" class="accordion-collapse collapse {{$categorySelected == $category->id? 'show' : ''}}" aria-labelledby="headingOne-{{$key}}" data-bs-parent="#accordionExample" style="">
                                               <div class="accordion-body">
                                                   <div class="navbar-nav">
                                                        @foreach ($category->sub_category as $subCategory)   
                                                        <a href="{{route('front.shop',[$category->slug, $subCategory->slug])}}" class="nav-item nav-link {{$subCategorySelected == $subCategory->id? 'text-primary': ''}}">{{$subCategory->name}}</a>
                                                        @endforeach
                                     
                                                    </div>
                                                </div>
                                           </div>
                                        @endif                                           
                                    </div>  
                               @endforeach
                            @endif                     
                        </div>
                    </div>
                </div>

                <div class="sub-title mt-5">
                    <h2>Brand</h3>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        @if ($brands->isNotEmpty())
                            @foreach ($brands as $brand)
                                <div class="form-check mb-2">
                                    <input {{(in_array($brand->id, $brandArray)) ? 'checked' : ''}} class="form-check-input brand-label" type="checkbox" name="brand[]" value="{{$brand->id}}" id="brand-{{$brand->id}}">
                                    <label class="form-check-label" for="brand-{{$brand->id}}">
                                    {{$brand->name}}
                                    </label>
                                </div>
                            @endforeach
                        @endif                 
                    </div>
                </div>

                <div class="sub-title mt-5">
                    <h2>Price</h3>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />               
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-end mb-4">
                            <div class="ml-2">
                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Price High</a>
                                        <a class="dropdown-item" href="#">Price Low</a>
                                    </div>
                                </div>                                     --}}

                                <select name="sort" id="sort" class="form-control">
                                    <option {{$sort == "latest" ? "selected" : ""}} value="latest">Latest</option>
                                    <option {{$sort == "sort_desc" ? "selected" : ""}} value="sort_desc">High Price</option>
                                    <option {{$sort == "sort_asc" ? "selected" : ""}} value="sort_asc">Low Price</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                    @php
                    //   $productImage = grtProductImage($product->id);
                      
                      $productImage = $product->product_images->first();
                     
                    @endphp
                    <div class="col-md-4">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="{{ route('front.product', $product->slug) }}" class="product-img">
                                    @if (!empty($productImage))  
                                     <img class="card-img-top" src="{{asset('upload/product/small/'.$productImage->image)}}" alt="">
                                    @else
                                    <img class="card-img-top" src="{{ asset('front-assets/images/product-1.jpg') }}" alt="">
                                    @endif
                                </a>   
                                <a class="whishlist" onclick="addToWishList({{$product->id}})" href="javascript:void(0);"><i class="far fa-heart"></i></a>   
                                @if ($product->track_qty == 'Yes')
                                    @if ($product->qty > 0) 
                                    <div class="product-action">
                                        <a class="btn btn-dark" href="javascript:void[0]" onclick="addToCart({{$product->id}})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>                            
                                    </div> 
                                    @else
                                    <div class="product-action">
                                        <a class="btn btn-dark"  href="javascript:void[0]">
                                            Out Of Stock
                                        </a>
                                    </div>  
                                    @endif
                                @else
                                <div class="product-action">
                                    <a class="btn btn-dark" href="javascript:void[0]" onclick="addToCart({{$product->id}})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>                            
                                </div>
                                @endif                     
                               
                            </div>                        
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="{{ route('front.product', $product->slug) }}" >{{$product->title}}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>&#8377; {{$product->price}}</strong></span>
                                    @if ($product->compare_price > 0)
                                    <span class="h6 text-underline"><del>&#8377; {{$product->compare_price}}</del></span>   
                                    @endif
                                </div>
                            </div>                        
                        </div>                                               
                    </div>  
                    @endforeach
                    @endif
                    <div class="col-md-12 pt-5">
                        <nav aria-label="Page navigation example">

                            {{$products->withQueryString()->links()}}
                            {{-- <ul class="pagination justify-content-end">
                                <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                                </li>
                            </ul> --}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customjs')


    <script type="text/javascript">
        $(document).ready(function() {
            console.log({{$priceMin}});
            console.log({{$priceMax}});
            $(".js-range-slider").ionRangeSlider({
                type: "double",
                min: 0,
                max: 10000,
                from: {{$priceMin}},
                to: {{$priceMax}},
                skin: "round",
                max_postfix: "+",
                prefix: "&#8377;",
                grid: true,
                onFinish: function() {
                    apply_filter();
                }
            });

            // Saving range slider's instance to variable
            var slider = $(".js-range-slider").data("ionRangeSlider");

            $(".brand-label").change(function() {
                apply_filter();
            });

            $("#sort").change(function(){
                apply_filter();
            });

            function apply_filter() {
                var brands = [];

                $(".brand-label").each(function() {
                    if ($(this).is(":checked")) {
                        brands.push($(this).val());
                    }
                });

                var url = '{{ url()->current() }}?';

                // Add price parameters to the URL
                url += "price_min=" + slider.result.from + "&price_max=" + slider.result.to;

                // Add brand parameters to the URL if any
                if (brands.length > 0) {
                    url += "&brand=" + brands.join(',');
                }

                var keybord = $('#search').val();
                if(keybord.length > 0){
                    url += '&search='+keybord; 
                }
                //sortingfilter
                url += '&sort='+$("#sort").val();

                // Redirect to the new URL
                window.location.href = url;
            }
        });
    </script>

        
@endsection