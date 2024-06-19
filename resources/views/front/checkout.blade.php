@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    @include('front.message')
    <div class="container">
        <form action="#" method="post" name="checkoutFrom" id="checkoutFrom">
        <div class="row">
            <div class="col-md-8">
                <div class="sub-title">
                    <h2>Shipping Address</h2>
                </div>
                <div class="card shadow-lg border-0">
                    <div class="card-body checkout-form">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{!empty($customerAdress) ? $customerAdress->first_name: ''}}">
                                    <p></p>
                                </div>            
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{!empty($customerAdress) ? $customerAdress->last_name : ''}}">
                                    <p></p>
                                </div>            
                            </div>
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{!empty($customerAdress) ? $customerAdress->email : ''}}">
                                    <p></p>
                                </div>            
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select a Country</option>
                                        @if ($countries->isNotEmpty())
                                        @foreach ($countries as $country)
                                        <option {{!empty($customerAdress) && ($customerAdress->country_id == $country->id) ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>   
                                        @endforeach 
                                        @endif
                                        
                                    </select>
                                    <p></p>
                                </div>            
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{!empty($customerAdress) ? $customerAdress->address : ''}}</textarea>
                                     <p></p>
                                </div>            
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{!empty($customerAdress) ? $customerAdress->apartment : ''}}">
                                </div>            
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{!empty($customerAdress) ? $customerAdress->city: ''}}">
                                    <p></p>
                                </div>            
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{!empty($customerAdress) ? $customerAdress->state : ''}}">
                                    <p></p>
                                </div>            
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{!empty($customerAdress) ? $customerAdress->zip : ''}}">
                                    <p></p>
                                </div>            
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{!empty($customerAdress) ? $customerAdress->mobile : ''}}">
                                    <p></p>
                                </div>            
                            </div>
                            

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control">{{!empty($customerAdress) ? $customerAdress->name : ''}}</textarea>
                                </div>            
                            </div>

                        </div>
                    </div>
                </div>    
            </div>
            <div class="col-md-4">
                <div class="sub-title">
                    <h2>Order Summery</h3>
                </div>                    
                <div class="card cart-summery">
                    <div class="card-body">
                        @foreach (Cart::content() as $item)
                        <div class="d-flex justify-content-between pb-2">
                            <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                            <div class="h6">&#8377;{{$item->price}}</div>
                        </div> 
                        @endforeach
                       
                        <div class="d-flex justify-content-between summery-end">
                            <div class="h6"><strong>Subtotal</strong></div>
                            <div class="h6"><strong>&#8377;{{Cart::subtotal()}}</strong></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="h6"><strong>Discount</strong></div>
                            <div class="h6" id="discoount_amount"><strong >&#8377;{{$discount}}</strong></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="h6"><strong>Shipping</strong></div>
                            <div class="h6" id="shippingCharge"><strong >&#8377;{{$shippingCharge}}</strong></div>
                        </div>

                        <div class="d-flex justify-content-between mt-2 summery-end">
                            <div class="h5"><strong>Total</strong></div>
                            <div class="h5" id="grandtotal"><strong>&#8377;{{$grandtotal}}</strong></div>
                        </div>                            
                    </div>
                </div>   
                <div class="input-group apply-coupan mt-4">
                    <input type="text" placeholder="Coupon Code" class="form-control" name="coupon_code" id="coupon_code" value="">
                    <button class="btn btn-dark" type="button" id="coupon_code_button">Apply Coupon</button>
                    
                   
                </div>
                <div class="mt-2 row gap-0 m-0 p-0" id="has-coupon-box">
                   @if (Session::has('coupon'))
                        <div class="col-md-5 gap-0 m-0 p-0">
                            <strong>{{Session::get('coupon')->code}}</strong>
                            <a class="btn-sm btn-danger" id="removeCoupon"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="col-md-7 gap-0 m-0 p-0">
                            <span class="text-success">Congratulations! You got {{ Session::get('coupon')->type == 'percent' ? Session::get('coupon')->discount_amount . '%' : '₹' . Session::get('coupon')->discount_amount }} discount.</span>
                        </div>
                    @endif
                </div>
                <div class="card payment-form ">
                    
                    <h3 class="card-title h5 mb-3 mt-0">Payment Method</h3>
                    <div class="">
                        <input checked type="radio" name="payment_type" id="payment_method_one" value="cod">
                        <label for="payment_method_one">COD</label>
                    </div>
                    <div class="">
                        <input type="radio" name="payment_type" id="payment_method_two" value="strim">
                        <label for="payment_method_two">Stripe</label>
                    </div>
                    
                    <div class="card-body p-0 mt-3 d-none" id="car-payment-form">
                        <div class="mb-3">
                            <label for="card_number" class="mb-2">Card Number</label>
                            <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="expiry_date" class="mb-2">Expiry Date</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="expiry_date" class="mb-2">CVV Code</label>
                                <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                            </div>
                        </div>
                       
                    </div>
                    <div class="pt-4">
                        {{-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> --}}
                        <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                    </div>                        
                </div>

                      
                <!-- CREDIT CARD FORM ENDS HERE -->
                
            </div>
        </div>
        </form>
    </div>
</section>
@endsection

@section('customjs')
  <script type="text/javascript">
       $('#payment_method_two').click(function(){
            if($(this).is(":checked") == true){
                $('#car-payment-form').removeClass('d-none'); 
            } 
        });

        $('#payment_method_one').click(function(){
            if($(this).is(":checked") == true){
                $('#car-payment-form').addClass('d-none'); 
            } 
        });

        $('#checkoutFrom').submit(function(event){
            
            event.preventDefault();
            
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('front.processChackout' )}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);
                if (response.status == true) {
                 
                    window.location.href = "{{url('/thankyou/')}}/"+response.orderId;

                } else {


                    if(response.message != null){
                      alert(response.message);
                      window.location.href = '{{route('front.cart')}}';
                    }
                    
                    var errors = response.errors;
             
                   
                    if(errors['first_name']){
                       $('#first_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['first_name']);
   
                   }else{
                       $('#first_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['last_name']){
                       $('#last_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['last_name']);
   
                   }else{
                       $('#last_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['email']){
                       $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
   
                   }else{
                       $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['mobile']){
                       $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['mobile']);
   
                   }else{
                       $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['country']){
                       $('#country').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['country']);
   
                   }else{
                       $('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['address']){
                       $('#address').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['address']);
   
                   }else{
                       $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['city']){
                       $('#city').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['city']);
   
                   }else{
                       $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['state']){
                       $('#state').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['state']);
   
                   }else{
                       $('#state').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   if(errors['zip']){
                       $('#zip').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['zip']);
   
                   }else{
                       $('#zip').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                   }
                   
                   
                  
                    
                }
                },
                error: function(){
                    console.log("Something went worg");
     
                }

            });


          

        });

        $('#country').change(function(){
               
               $.ajax({
                   url: '{{route("front.getOrderSummery")}}',
                   type: 'post',
                   data: {country_id: $(this).val()},
                   dataType: 'json',
                   headers: {
                     'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                   },
                   success: function(response){
                    $('#shippingCharge').html('<strong>&#8377; ' + response.shippingCharge  + '</strong>');
                    $('#grandtotal').html('<strong>&#8377; ' + response.grandTotal + '</strong>');

                   }
               });
           });


           $('#coupon_code_button').click(function(){
                $.ajax({
                  url: '{{route('front.applyDiscount')}}',
                  type: 'post',
                  data: {coupon_code: $('#coupon_code').val(), country_id: $('#country').val()},
                  dataType: 'json',
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response){
                    if(response.status){
                      $('#shippingCharge').html('<strong>&#8377; ' + response.shippingCharge  + '</strong>');
                      $('#grandtotal').html('<strong>&#8377; ' + response.grandTotal + '</strong>');
                      $('#discoount_amount').html('<strong>&#8377; ' + response.discount + '</strong>');

                      $('#has-coupon-box').html(response.discountString);
                     
                    }else{
                        
                        $('#has-coupon-box').html( '<span class="text-danger text-center m-0 p-0">' + response.message + '</span>');
                        
                       
                    }
                  },
                  error: function(jqXHR,exception){
                    console.log("Exception:", exception);
                  }
                });
           });


           // remove appled coupon
           $('body').on('click', '#removeCoupon', function(){
                $.ajax({
                  url: '{{route('front.removeDiscount')}}',
                  type: 'post',
                  data: {country_id: $('#country').val()},
                  dataType: 'json',
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(response){
                     $('#shippingCharge').html('<strong>&#8377; ' + response.shippingCharge  + '</strong>');
                     $('#grandtotal').html('<strong>&#8377; ' + response.grandTotal + '</strong>');
                     $('#discoount_amount').html('<strong>&#8377; ' + response.discount + '</strong>');
                     $('#has-coupon-box').html('');
                     $('#coupon_code').val('');
                   
                  },
                  error: function(jqXHR,exception){
                    console.log("Exception:", exception);
                  }
                });
           });
           
             
  </script>
@endsection