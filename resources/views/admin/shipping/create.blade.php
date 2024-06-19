@extends('admin.app')

@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping Charges</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('shipping.create')}}" class="btn btn-primary">Reset</a>
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
        <form action="#" method="POST" name="shippingForm" id="shippingForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select Coutry</option>
                                    @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                     <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach 
                                    <option value="rest_of_the_word">Rest of the Word</option> 
                                    @endif
                                </select> 
                                <p></p>   
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount in &#8377;">
                                <p></p>	
                            </div>
                        </div> 	
                        <div class="col-md-4">
                            <div class="mb-3">
                               <button class="btn btn-primary" type="submit">Create</button>
                            </div>
                        </div> 						
                    </div>
                </div>							
            </div>

           

        </form>

        {{-- shipping charges list  --}}

        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Country Name</th>
                <th scope="col">Shipping Amount</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @if ($shippingCharges->isNotEmpty())
                    @foreach ($shippingCharges as $shippingCharge)
                    <tr>
                        <th scope="row">{{$shippingCharge->id}}</th>
                        <td>{{$shippingCharge->country_name}}</td>
                        <td>&#8377;{{$shippingCharge->amount}}</td>
                        <td>
                            <a href="{{ route('shipping.edit', $shippingCharge->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="#" onclick="deleteProduct({{$shippingCharge->id}})" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                 <tr class="p-2">
                      <p class="text-center">
                          No Shipping Recourd Found.
                          
                      </p>
                    
                 </tr>
                @endif
             
            </tbody>
        </table>
    </div>
    <!-- /.card -->
    
</section>
<!-- /.content -->
@endsection

@section('customjs') 
<script type="text/javascript">
    $("#shippingForm").submit(function(event) {

        event.preventDefault();

        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{route('shipping.store')}}',
            type: 'post',
            data: $(this).serializeArray(), 
            dataType: 'json',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);

                if (response.status == true) {

                    $('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    window.location.href="{{route('shipping.create')}}";
                    
                } else { 
                    
                    // Handle the response from the server
                    var errors = response.errors;
                   
                    if(errors['country']){
                        $('#country').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['country']);
    
                    }else{
                        $('#country').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors['amount']){
                        $('#amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['amount']);
    
                    }else{
                       
                        $('#amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            },
            error: function(jqXHR, exception) {
                console.log("Exception:", exception); 
            }
        });
    });


    function deleteProduct(id){
                 

        var url = '{{ route("shipping.delete", "ID") }}';
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
                    
                    location.reload();
                },
                error: function(jqXHR, exception) {
                    console.log("Exception:", exception); 
                }
            });
        }
    }


</script>

@endsection