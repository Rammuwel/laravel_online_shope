@extends('admin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    
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
            <div class="card">
                <form action="{{route('orders.index')}}" method="GET">
                    <div class="card-header">
                        <div class="card-title">
                            <button class="btn btn-default tbn-sm" type="button" onclick="window.location.href='{{route('orders.index')}}'">Reset</button>
                        </div>
                       <div class="card-tools">
                          <div class="input-group input-group" style="width: 250px;">
                              <input type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{Request::get('keyword')}}">
        
                              <div class="input-group-append">
                                  <button type="submit" class="btn btn-default">
                                  <i class="fas fa-search"></i>
                                  </button>
                               </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body table-responsive p-0">								
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">Order#</th>
                                <th>Custmer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th width="100">Status</th>
                                <th>Total</th>
                                <th>Purchasrd Date</th>   
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isNotEmpty())
                              @foreach ($orders as $order)
                                  
                              <tr>
                                  <td>
                                    <a href="{{ route('orders.details', $order->id) }}">{{ $order->id }}</a>
                                  </td>
                                  <td >
                                   <a class="  text-bold text-dark" href="#">{{$order->first_name.' '.$order->last_name}}</a>  
                                </td>
                                  <td>{{$order->email}}</td>
                                  <td>{{$order->mobile}}</td>
                                  <td>
                                    @if ($order->status == 'panding')
                                        <span class="badge bg-danger">{{$order->status}}</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-info">{{$order->status}}</span>
                                    @else
                                        <span class="badge bg-success">{{$order->status}}</span>
                                    @endif
                                    <td> &#8377; {{number_format($order->grand_total, 2)}}</td>
                                    <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M, y')}}</td>
                              </tr>

                              @endforeach  
                            @else
                            <tr> 
                                <td colspan="7">
                                    <p class="text-danger text-center"> Data Not Found</p>
                                </td> 
                             </tr>
                            @endif
                             
                        </tbody>
                    </table>										
                </div>
                <div class="card-footer clearfix">

                    {{$orders->links()}}
                     

                    {{-- <ul class="pagination pagination m-0 float-right">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul> --}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
   
@endsection

@section('customjs')
    {{-- custom js --}}
    <script>
        function deleteCategory(id){

           var url = '{{ route("categories.delete", "ID") }}';
           var newUrl = url.replace("ID", id);
          //    alert(newUrl);
            
           if (confirm('Are you sure you want to delete id '+id+' ?')) {
                    $.ajax({
                    url: newUrl, 
                    type: 'delete',
                    data: {}, 
                    dataType: 'json',
                    headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                    success: function(response) {
                        $("button[type=submit]").prop('disabled', false);
                        if (response['status'] == true) {

                            window.location.href="{{route('categories.index')}}";
                            
                        } else {
                        
                            
                            
                            
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log("Exception:", exception); 
                    }
                });
           
           
            }
        }


        



    </script>
@endsection