@extends('admin.app')

@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="POST" name="categoryForm" id="categoryForm">
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
                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="text" id="image_id" name="image_id" value="" hidden>
                                <label for="image">Image</label>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                   <option value="1">Active</option>
                                   <option value="0">Block</option>
                                </select>
                                    
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="showHome">Show on Home</label>
                                <select name="showHome" id="showHome" class="form-control">
                                   <option value="No">No</option>
                                   <option value="Yes">Yes</option>
                                </select>
                                    
                            </div>
                        </div>							
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Create</button>
                <a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>

        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customjs') 
<script type="text/javascript">
    $("#categoryForm").submit(function(event) {
        event.preventDefault();
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: 'http://127.0.0.1:8000/admin/categories/store', // corrected 'ulr' to 'url'
            type: 'post',
            data: $(this).serializeArray(), // corrected 'element' to '$(this)'
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response['status'] == true) {

                    window.location.href="{{route('categories.index')}}";
                    
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


    Dropzone.autoDiscover = false;

    const dropzone = new Dropzone("#image", {
    url: "{{ route('temp-images.create') }}",
    method: 'post', // Ensure method is POST
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
        this.on('sending', function(file, xhr, formData) {
            console.log('Sending file:', file);
            console.log('XHR state:', xhr.readyState);
        });
        this.on('success', function(file, response) {
            // console.log('File uploaded successfully:', response);
            $('#image_id').val(response['image_id']);
        });
        this.on('error', function(file, errorMessage) {
            // console.error('File upload error:', errorMessage);
        });
    }
});




</script>

@endsection