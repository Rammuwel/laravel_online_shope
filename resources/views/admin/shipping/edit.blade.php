@extends('admin.app')

@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Shipping Charges</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('shipping.create')}}" class="btn btn-primary">Back</a>
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
        <form action="#" method="POST" name="shippingEditForm" id="shippingEditForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select Coutry</option>
                                    @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                     <option {{$shippingCharge->country_id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach  
                                    @endif
                                </select> 
                                <p></p>   
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount in &#8377;" value="{{$shippingCharge->amount}}">
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

    </div>
    <!-- /.card -->
    
</section>
<!-- /.content -->
@endsection

@section('customjs') 
<script type="text/javascript">
    $("#shippingEditForm").submit(function(event) {

        event.preventDefault();

        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{route('shipping.update', $shippingCharge->id)}}',
            type: 'put',
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


</script>

@endsection