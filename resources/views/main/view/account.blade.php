@extends('main.app')

@section('title')
    {{$service->title}}
@endsection

@section('content')

<style>
        .stars {
            display: flex;
            justify-content: center;
            direction: rtl;
        }
        .stars i {
            font-size: 2rem;
            color: #ddd;
        }
        .filled {
            color: #f5b301;
        }
</style>

<header class="site-header d-flex flex-column justify-content-center align-items-center">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center">

                <h2 class="mb-0">{{$service->title}}</h2>
            </div>

        </div>
    </div>
</header>


<section class="latest-podcast-section section-padding pb-0 mb-5" id="section_2">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-10 col-12">
                <div class="section-title-wrap mb-5">
                    <h4 class="section-title">{{$service->title}} by <a href="/account/{{$service->username}}">{{$service->username}} </a> </h4>
                </div>

                
                <div class="row">
        <div class="col-sx-12 col-sm-12 col-md-8 col-lg-8  pb-3">
            <div class="card border-0 shadow h-100">
                <img src="/images/{{$service->img_folder.$service->image}}" alt="{{$service->title}}" class="card-img-top">
                <div class="card-body pt-40px pb-30px">
                    <div class="d-flex justify-content-between">
                        <div class="text-center mb-2">
                            <span class="text-muted small">{{$service->created_at->format('D d M, Y')}}</span>
                        </div>
                        <div class="">
                            <ul class="social-icon ms-lg-auto ms-md-auto">
                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link bi-facebook"></a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link bi-twitter"></a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link bi-whatsapp"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                   
                    <h4 class="mb-3 text-center">{{$service->title}}</h4>
                    <p> By <a href="/account/{{$service->username}}">{{$service->username}} </a> </p>
                    
                    <h5 class="text-center">Descripion </h5>
                    <div class="">
                    {!!$service->description!!}
                    </div>

                    <div class="mt-3 d-flex flex-column align-items-center">
                        @if (auth()->check())
                        <a class="btn btn-primary mb-3 w-50" href="#service_checkout">
                            CONTINUE
                        </a>
                        <a class="btn btn-primary mb-3 w-50" href="/message?service={{$service->id}}&user={{$service->user_id}}">
                            ASK QUESTION
                        </a>

                        <button class="btn btn-primary mb-3 w-50 trigger" data-iziModal-open="#service_message_user">Message User</button>

                        <div id="service_pay_user" class="iziModal" data-izimodal-title="Payment Method" data-izimodal-subtitle="Pls select your Preferred payment type / method">
                            <div class="d-flex flex-column justify-content-between align-items-center">
                                <div class="d-flex justify-content-center m-2">
                                    <button id="pay_service_monnify" class="btn btn-primary m-2">MONNIFY</button>
                                    <button id="pay_service_paystack" class="btn btn-success m-2">PAYSTACK</button>
                                </div>
                            </div>
                            

                        </div>


                    <div id="service_message_user" class="iziModal" data-izimodal-title="{{$service->title}}" data-izimodal-subtitle="Messaging {{$service->username}}">
                        
                        <div class=" card p-4">
                            <div class="row">
                                <form id="service_message" method="post">
                                    @csrf
                                <div class="col-12">
                                    <textarea class="form-control" name="message" id="urmessage"> Hi {{$service->username}} i want to know more about this service :  {{$service->title}}  </textarea>
                                </div>
                                <input type="hidden" name="creator_id" value="{{$service->user_id}}">
                                <input type="hidden" name="user_id" value="{{Admin('id')}}">
                                <input type="hidden" name="action" value="service_send_message">
                                <div class="col-12 mt-3"><button type="submit" class="btn btn-primary" id="submiturmessage">SEND</button>  </div>
                                </form>
                            </div>
                        </div>
                    </div>

                        @else
                        <a class="btn btn-primary mb-3 w-50" href="/login">
                            Login
                        </a>
                        <a class="btn btn-primary mb-3 w-50" href="/register">
                           Register
                        </a>
                        @endif
                       
                    </div>


                    



                </div>

                
            </div>
            
        </div>
        <div class="col-sx-12 col-sm-12 col-md-4 col-lg-4 pb-3">
            <div class="card border-0 shadow  sticky-top">
                <div class="card-body">
                    <div class="text-center mb-2 d-flex flex-column align-items-center"><h4 class="mb-3 text-center">Details</h4></div>
                    
                    <div class="d-flex align-items-center justify-content-center">
                        <label class="mr-3" for="quantity">Quantity </label>
                        <input type="number" id="service_quantity" class="form-control" value="1">
                        <input type="hidden" id="service_price" class="form-control" value="{{$service->price}}">
                        <input type="hidden" id="service_id" class="form-control" value="{{$service->id}}">
                        <input type="hidden" id="user_id_pay" class="form-control" value="{{Admin('id')}}">
                        <input type="hidden" id="user_fullname" class="form-control" value="{{Admin('fullname')}}">
                        <input type="hidden" id="tite_name" class="form-control" value="{{$service->title}}">
                        <input type="hidden" id="user_email" class="form-control" value="{{Admin('email')}}">
                    </div>
                    <div class="d-flex flex-column align-items-center">
                    <p class="mt-3"> Total : <span class="" id="total_service">{{$service->price}}</span></p>

                    @if(auth()->check()) 

                    <button id="service_checkout" class="btn btn-primary mb-3 w-50">
                        Checkout
                    </button>
                    @else 
                    <button id="" class="btn btn-primary mb-3 w-50" data-iziModal-open="#login-custom">
                        Checkout
                    </button>
                    @endif
                    </div>


                </div>
            </div>
        </div>

        <div class="col-sx-12 col-sm-12 col-md-12 col-lg-12 pb-3">
            <div class="card border-0 shadow">
                <div class="card-body">

                    <div class="profile-block profile-detail-block d-flex flex-wrap align-items-center mt-5">
                        <div class="d-flex mb-3 mb-lg-0 mb-md-0">
                            <img src="/images/{{$service->user_i_folder.$service->u_image}}" class="profile-block-image img-fluid" alt="">
                            <p>
                                {{$service->username}}
                                <img src="/images/verified.png" class="verified-image img-fluid" alt="">
                            </p>
                        </div>
                        <div class="ms-lg-auto ms-md-auto">
                            @for ($i = 5; $i >= 1; $i--)
                                <i class="bi-star {{ $averageRating >= $i ? 'filled' : '' }}"></i>
                            @endfor
                        <p>Average Rating: {{ number_format($averageRating, 1) }} out of 5</p>
                        </div>
                            
         
                            
                       

                        
                    </div>

                    <div class="section-title-wrap mb-5 mt-5">
                        <h4 class="section-title">Creator Reviews</h4>
                    </div>

                    <div class="row">

                        @foreach ($average as $item)
                        <div class="col-lg-1 col-3">
                            <div class="custom-block-icon-wrap">
                                <div class="custom-block-image-wrap custom-block-image-detail-page">
                                    <img src="/images/{{$item->user->image_folder.$item->user->image}}" class=" img-fluid" style="width: 200px;" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-11 col-9">
                            <div class="custom-block-info">
                                <div class="custom-block-top d-flex mb-1">
                                    

                                    <small>
                                        <i class="bi-clock-fill custom-icon"></i>
                                        {{$item->created_at->format('D d M, Y')}}
                                    </small>

                                    <small class="ms-auto">Rating <span class="badge">{{$item->rate}}</span></small>
                                </div>

                                <h4 class="mb-2">{{$item->user->fullname}}</h4>

                                @for ($i = 5; $i >= 1; $i--)
                                <i class="bi-star {{ $item->rate >= $i ? 'filled' : '' }}"></i>
                                 @endfor
                                 <p> {{$item->review}} </p>

                                
                            </div>
                        </div>
                        <hr>
                        @endforeach

                        <div class="col-lg-12 col-12">
                            <div class="text-center mb-5 pb-2">

                                <p class="">view all creator reviews.</p>

                                <a href="/creator-review/{{$service->user_id}}" class="btn custom-btn smoothscroll ">View All</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
    </div>
</section>

</div>
</main>


@endsection
