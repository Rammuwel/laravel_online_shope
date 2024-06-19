@extends('admin.app')

@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('brands.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" name="createBrandForm" id="createBrandForm" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input readonly type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="">
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control"  id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                   	
                                </div>
                            </div>									
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{route('brands.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
          </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->


@endsection



@section('customjs') 
<script type="text/javascript">
    $("#createBrandForm").submit(function(event) {
        event.preventDefault();
       
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{route('brands.store')}}', 
            type: 'post',
            data: $(this).serializeArray(), // 'element' to '$(this)'
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response['status'] == true) {

                    window.location.href="{{route('brands.index')}}";
                    
                } else {
                   
                    
                    // Handle the response from the server
                    var errors = response['error'];
                   
                    if(errors['name']){
                        $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
    
                    }else{
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors['slug']){
                        $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
    
                    }else{
                        console.log('remove')
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            },
            error: function(jqXHR, exception) {
                console.log("Exception:", exception); 
            }
        });
    });

    //-------------- slug generate----------

    $('#name').change(function() {
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


</script>

@endsection