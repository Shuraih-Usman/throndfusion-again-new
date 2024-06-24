@extends('main.app')

@section('title')
  {{$catsname}}  Services
@endsection

@section('content')

<header class="site-header d-flex flex-column justify-content-center align-items-center">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center">

                <h2 class="mb-0">Latest  {{$catsname}} Services</h2>
            </div>

        </div>
    </div>
</header>
    
@include('main.components.service')




@endsection

