
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible">
   <a href="#" class="close text-decoration-none" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Error! </strong> {{Session::get('error')}}
 </div>
@endif

@if (Session::has('success'))
<div class="alert alert-success alert-dismissible">
   <a href="#" class="close text-decoration-none" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Success! </strong> {{Session::get('success')}}
 </div>
@endif