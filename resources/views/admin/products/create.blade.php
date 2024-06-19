@extends('admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('products.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" name="productForm" id="productForm" method="POST">

               @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">								
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                            <p class="error"></p>	
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input readonly type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="">	
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" placeholder="Short Description"></textarea>
                                        </div>
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                        </div>
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_returns">Shipping and Returns</label>
                                            <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" placeholder="Shipping and Returns"></textarea>
                                        </div>
                                    </div>                                           
                                </div>
                            </div>	                                                                      
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>								
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">    
                                        <br>Drop files here or click to upload.<br><br>                                            
                                    </div>
                                </div>
                            </div>	                                                                      
                        </div>
                         <div class="row" id="product-gallery">

                         </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>								
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                            <p class="error"></p>	
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                            </p>	
                                        </div>
                                    </div>                                            
                                </div>
                            </div>	                                                                      
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>								
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">	
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">	
                                        </div>
                                    </div>  
                                    <div class="card col-md-12">
                                        <div class="mb-3">	
                                            <label for="related_product">Related Product</label><h2 class="h4 mb-3"></h2>
                                            
                                            <select class="related_product w-100" name="related_products[]" id="related_product" class="form-control" multiple="multiple">
                                               
                                            </select>
                                            <p class="error"></p>
                                            
                                        </div>
                                    </div>   
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                            <p class="error"></p>	
                                        </div>
                                    </div>                                         
                                </div>
                            </div>	                                                                      
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">	
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="card">
                            <div class="card-body">	
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                               <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        @endif
                                      
                                    </select>
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="sub_category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a Sub Category</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="card mb-3">
                            <div class="card-body">	
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select a Brand</option>
                                         @if ($brands->isNotEmpty())
                                            
                                           @foreach ($brands as $brand)
                                             <option value="{{$brand->id}}">{{$brand->name}}</option>
                                           @endforeach
                                             
                                         @endif
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="card mb-3">
                            <div class="card-body">	
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>                                                
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>                                 
                    </div>
                </div>
                
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
          </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customjs')
    <script type="text/javascript">

        $('.related_product').select2({
            ajax: {
                url: '{{ route('products.getProduct') }}',
                dataType: 'json',
                delay: 250, // Add a delay for better performance
                data: function(params) {
                    return {
                        term: params.term // Search term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                },
                cache: true
            },
            // tags: true,
            minimumInputLength: 3,
            multiple: true // Enable multiple selection
        }); 

        $('#productForm').submit(function(event){
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{route('products.store')}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',

                success: function(response){
                    $("button[type=submit]").prop('disabled', false);
                  if (response['status'] == true) {

                     window.location.href='{{route('products.index')}}';
                    
                  } else {
                     var errors = response['errors'];

                     
                     $('.error').removeClass('invalid-feedback').html("");
                     $("input[type='text'],select,input[type='number']").removeClass('is-invalid');
                    $.each(errors ,function(key, value){
                    $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);

                    } );
                      
                    //  if(errors['title']){
                    //     $('#title').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['title']);
                    //  }else{
                    //     $('#title').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                    //  }
                    //  if(errors['slug']){
                    //     $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
                    //  }else{
                    //     $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                    //  }
                    //  if(errors['price']){
                    //     $('#price').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['price']);
                    //  }else{
                    //     $('#price').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                    //  }
                    //  if(errors['track_qty']){
                    //     $('#track_qty').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['track_qty']);
                    //  }else{
                    //     $('#track_qty').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                    //  }
                    //  if(errors['is_featured']){
                    //     $('#is_featured').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['is_featured']);
                    //  }else{
                    //     $('#is_featured').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                    //  }


                  }
                },
                error: function(){
                    console.log("Something went worg");
                }

            });

        });

        //-------------- slug generate----------

        $('#title').change(function() {
        // console.log("Name field changed");
        
        var element = $(this); // Corrected to properly reference the element
        $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("getslug") }}', // Corrected route method
                type: 'get',
                data: { title: element.val() }, // Pass the value of the name input
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);
                    if (response.status) {
                        $('#slug').val(response.slug); // Set the slug input value
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("Error occurred:", exception); 
                }
            });
        });


        // find sub category js
       $('#category').change(function() {
            var category_id = $(this).val();
            $.ajax({
            url: '{{ route("product-subcategories.index") }}',
            type: 'GET',
            data: { category_id: category_id },
            dataType: 'json',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
            $('#sub_category').find('option').not(':first').remove();

            $.each(response.subCategories, function(key, item) {
                $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`);
              });
           },
            error: function() {
            console.log("Something went wrong");
          }
         });   
       });


    //    dropzone

    
        Dropzone.autoDiscover = false;

        const dropzone = new Dropzone("#image", {
        url: "{{ route('temp-images.create') }}",
        method: 'post', // Ensure method is POST
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response) {
            var html = `
            <div class='col-md-4'>
                <div class="card">
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                    <img src="${response.imagePath}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="btn btn-sm btn-danger delete-image">Delete</a>
                    </div>
                </div>
            </div>`;
            
            $('#product-gallery').append(html);
        }
       

    });
      
      
    </script>
@endsection