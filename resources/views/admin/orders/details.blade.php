@extends('admin.app')

@section('content')
    	<!-- Content Header (Page header) -->
        <section class="content-header">					
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order: #{{$order->id}}</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{route('orders.index')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                @include('admin.message')
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header pt-3">
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                    <h1 class="h5 mb-3">Shipping Address</h1>
                                    <address>
                                        <strong>{{ $order->first_name." ".$order->last_name}}</strong><br>
                                        {{$order->address}}<br>
                                        {{$order->city}},{{$order->zip}} {{$order->country_name}}<br>
                                        Phone: {{$order->mobile}}<br>
                                        Email: {{$order->email}}
                                    </address>
                                    <strong>Shipped Date: {{(!empty($order->shipped_at)) ? \Carbon\Carbon::parse($order->shipped_at)->format('d M, y') :' N/A'}}</strong>
                                   
                                    </div>
                                    
                                    
                                    
                                    <div class="col-sm-4 invoice-col">
                                        {{-- <b>Invoice #007612</b><br>
                                        <br> --}}
                                        <b>Order ID:</b>#{{$order->id}}<br>
                                        <b>Total:</b>  &#8377; {{number_format($order->grand_total, 2)}}<br>
                                        <b>Status:</b> @if ($order->status == 'panding')
                                            <span class="badge bg-cyan ">{{$order->status}}</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">{{$order->status}}</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">{{$order->status}}</span>
                                        @else
                                            <span class="badge bg-success">{{$order->status}}</span>
                                        @endif
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-3">								
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th width="100">Price</th>
                                            <th width="100">Qty</th>                                        
                                            <th width="100">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($orderItem->isNotEmpty())
                                            @foreach ($orderItem as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>&#8377; {{ number_format($item->price, 2) }}</td>                                        
                                                <td>{{$item->qty}}</td>
                                                <td>&#8377; {{ number_format($item->price * $item->qty, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                       
                                        
                                        <tr>
                                            <th colspan="3" class="text-right">Subtotal:</th>
                                            <td>&#8377; {{number_format($order->subtotal, 2)}}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="3" class="text-right">Discount{{$order->coupon_code != "" > 0?'('.$order->coupon_code.')': ''}}:</th>
                                            <td>&#8377; {{number_format($order->descount, 2)}}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="3" class="text-right">Shipping:</th>
                                            <td>&#8377; {{number_format($order->shipping, 2)}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Grand Total:</th>
                                            <td>&#8377; {{number_format($order->grand_total, 2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>								
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <form action="#" id="changeOrderStatus" name="changeOrderStatus">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Order Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="panding" {{ ($order->status == 'pending' ? 'selected' : '') }}>Pending</option>
                                        <option value="shipped" {{ ($order->status == 'shipped' ? 'selected' : '') }}>Shipped</option>
                                        <option value="delivered" {{ ($order->status == 'delivered' ? 'selected' : '') }}>Delivered</option>
                                        <option value="cancelled" {{ ($order->status == 'cancelled' ? 'selected' : '') }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="md-3">
                                    <label for="shipped_at">Shipped Date</label>
                                    <input type="datetime-local" name="shipped_at" value="{{ $order->shipped_at ? $order->shipped_at : '' }}" id="shipped_at" class="form-control" placeholder="Shipped Date" min="2000-12-31T23:59">
                                    <p></p>	
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                           </form>
                        </div>
                       
                        <div class="card">
                            <form action="#"  name="sendInvoiceEmail" id="sendInvoiceEmail">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Send Inovice Email</h2>
                                <div class="mb-3">
                                    <select name="userType" id="userType" class="form-control">
                                        <option value="customer">Customer</option>                                                
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>                           
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
@endsection

@section('customjs')
    <script type="text/javascript">
        $('#changeOrderStatus').submit(function(event){
        event.preventDefault(); // Prevent the default form submission

        if(confirm('Realy you want to update Order Status?')){
        $.ajax({
            url: '{{ route('orders.changeOrderStatus', $order->id) }}', // The route for changing order status
            type: 'POST', // HTTP method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json', // Expected response data type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for protection
            },
            success: function(response) {
                if (response.status) {
                    // Handle success response
                    window.location.href = '{{ route("orders.details", $order->id) }}';
                } else {
                    // Handle failure response
                    console.log('Failed to change order status.');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error
                console.error('AJAX error:', status, error);
            }
        });
        }
    });



    //ajax for  sending  invoice email

    $('#sendInvoiceEmail').submit(function(event){
        event.preventDefault(); 
       if(confirm('You want to sent Order Email')){
        $.ajax({
            url: '{{ route('orders.senInvoiceEmail', $order->id) }}', 
            type: 'POST', 
            data: $(this).serialize(),
            dataType: 'json', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                window.location.href = '{{ route("orders.details", $order->id) }}';
            },
            
        });
       }
        
    });

    </script>
@endsection