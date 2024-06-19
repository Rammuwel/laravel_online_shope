@extends('admin.app')

@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Coupon</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('coupons.index')}}" class="btn btn-primary">Back</a>
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
        <form action="" method="POST" name="couponForm" id="couponForm">
             @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Code</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Coupon Code">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text"  name="name" id="name" class="form-control" placeholder="Coupon Code Name">
                                <p></p>	
                            </div>
                        </div>
                        
                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_uses">Max Uses</label>
                                <input type="number"  name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_uses_user">Max Uses User</label>
                                <input type="number"  name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max Uses User">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type">Discount Type</label>
                                <select name="type" id="type" class="form-control">
                                   <option value="percent">Percent</option>
                                   <option value="fixed">Fixed</option>
                                </select>
                                    
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_amount">Discount Amount</label>
                                <input type="text"  name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="min_amount">Minnimum Amount</label>
                                <input type="text"  name="min_amount" id="min_amount" class="form-control" placeholder="Minnimum Amount">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                   <option value="active">Active</option>
                                   <option value="expired">Expired</option>
                                   <option value="inactive">Inactive</option>
                                </select>       
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_at">Start Time</label>
                                <input type="datetime-local" name="start_at" id="start_at" class="form-control" placeholder="Start Time" min="2000-12-31T23:59">
                                <p></p>    
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expires_at">Expires Time</label>
                                <input type="datetime-local"  name="expires_at" id="expires_at" class="form-control" placeholder="Expires Time" min="2000-12-31T23:59">
                                <p></p>	
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="descrption">Description</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Coupon Code Description"></textarea>
                                <p></p>	
                            </div>
                        </div>
                    						
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Create</button>
                <a href="{{route('coupons.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>

        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customjs') 
<script type="text/javascript">

$("#couponForm").submit(function(event) {
        event.preventDefault();
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{route('coupons.store')}}',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response['status'] == true) {
                    window.location.href = "{{route('coupons.index')}}";
                } else {
                    var errors = response['errors'];
                    if (errors['code']) {
                        $('#code').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['code']);
                    } else {
                        $('#code').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['name']) {
                        $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['description']) {
                        $('#description').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['description']);
                    } else {
                        $('#description').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['max_uses']) {
                        $('#max_uses').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['max_uses']);
                    } else {
                        $('#max_uses').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['max_uses_user']) {
                        $('#max_uses_user').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['max_uses_user']);
                    } else {
                        $('#max_uses_user').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['type']) {
                        $('#type').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['type']);
                    } else {
                        $('#type').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['discount_amount']) {
                        $('#discount_amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['discount_amount']);
                    } else {
                        $('#discount_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['min_amount']) {
                        $('#min_amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['min_amount']);
                    } else {
                        $('#min_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['status']) {
                        $('#status').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['status']);
                    } else {
                        $('#status').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['start_at']) {
                        $('#start_at').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['start_at']);
                    } else {
                        $('#start_at').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if (errors['expires_at']) {
                        $('#expires_at').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['expires_at']);
                    } else {
                        $('#expires_at').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
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