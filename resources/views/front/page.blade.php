@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item">{{$page->name}}</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    @include('front.message')
    <div class="container">
        @if($page->name == 'Contact Us')
        <div class="row">
            <div class="col-md-6 mt-3 pe-lg-5">
                @if (!empty($page))
                <h1 class="my-3">{{$page->name}}</h1>
                {!! $page->content !!}    
                @else
                    <h4>Data not found!</h4>
                @endif
            </div>
            <div class="col-md-6">
                <form class="shake" role="form" method="post" id="contactForm" name="contact-form">
                    <div class="mb-3">
                        <label class="mb-2" for="name">Name</label>
                        <input class="form-control" id="name" type="text" name="name" placeholder="Name">
                        <p></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="mb-2" for="email">Email</label>
                        <input class="form-control" id="email" type="email" name="email" placeholder="Email">
                        <p></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="mb-2">Subject</label>
                        <input class="form-control" id="subject" type="text" name="subject" placeholder="Subject">
                         <p></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="mb-2">Message</label>
                        <textarea class="form-control" rows="3" id="message" name="message" placeholder="Message"></textarea>
                        <p></p>
                    </div>
                  
                    <div class="form-submit">
                        <button class="btn btn-dark" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                        {{-- <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div> --}}
                    </div>
                </form>
            </div>
        </div>
        @else
        @if (!empty($page))
        <h1 class="my-3">{{$page->name}}</h1>
        {!! $page->content !!}    
        @else
            <h4>Data not found!</h4>
        @endif
        @endif
    </div>
</section>
@endsection

@section('customjs')
     <script type="text/javascript">
         $('#contactForm').submit(function(event){
            
            event.preventDefault();
            
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '{{ route('account.contactUs')}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);

                    if (response.status) {  
                        // window.location.href = '{{route('account.changePassword')}}';
                    }
                   else {
                        var errors = response.errors;
                       //name error
                        if(errors['name']){
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        }else{
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                        }

                        //email error
                        if(errors['email']){
                        $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        }else{
                        $('#email').removeClass('is-invalid').siblings('p').removeClass ('invalid-feedback').html(""); 
                        }

                      //phone error
                      if(errors['subject']){
                        $('#subject').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['subject']);
                      }else{
                        $('#subject').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                        }

                      //phone error
                      if(errors['message']){
                        $('#message').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['message']);
                      }else{
                        $('#message').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html(""); 
                        }
                    }
               
                }
            });
       

        });

     </script> 
@endsection