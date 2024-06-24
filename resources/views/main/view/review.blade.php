@extends('main.app')

@section('title')
    {{$user->fullname}} Reviews
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

                <h2 class="mb-0">{{$user->fullname}}</h2>
            </div>

        </div>
    </div>
</header>


<section class="latest-podcast-section section-padding pb-0 mb-5" id="section_2">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-10 col-12">
                



                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <div class="custom-block-icon-wrap">
                                <div class="custom-block-image-wrap custom-block-image-detail-page">
                                    <img src="/images/{{$user->image_folder.$user->image}}" class=" img-fluid" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-9 col-12">
                            <div class="custom-block-info">
                                <div class="custom-block-top d-flex mb-1">
                                   

                                    <small>
                                        @for ($i = 5; $i >= 1; $i--)
                                <i class="bi-star {{ $averageRating >= $i ? 'filled' : '' }}"></i>
                            @endfor
                                    </small>

                                    <small class="ms-auto">Rating <span class="badge">{{ number_format($sumRate, 1) }} </span></small>
                                </div>

                                <h2 class="mb-2">{{$user->username}}</h2>

                                <p>Average Rating: {{ number_format($averageRating, 1) }} out of 5</p>

                                
                            </div>
                        </div>

                        <div class="section-title-wrap mb-5 mt-5">
                            <h4 class="section-title">Creator Reviews</h4>
                        </div>
    
                        <div class="row">
    
                            @foreach ($average as $item)
                            <div class="col-lg-3 col-3">
                                <div class="custom-block-icon-wrap">
                                    <div class="custom-block-image-wrap custom-block-image-detail-page">
                                        <img src="/images/{{$item->user->image_folder.$item->user->image}}" class=" img-fluid" style="width: 200px;" alt="">
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-lg-9 col-9">
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
                            @php
                                $paginator = $average;
                            @endphp
    
                            <div class="col-lg-12 col-12">
                                    @include('main.components.pagination')
                            </div>
                        </div>



                    </div>

</div>
    </div>
</section>

</div>
</main>


@endsection
