@extends('main.app')



@section('title')
    {{$query}} Search results
@endsection

@section('content')

<header class="site-header d-flex flex-column justify-content-center align-items-center">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center">

                <h2 class="mb-0">@if (count($services) > 0)
                    {{$query}} Search {{count($services)}} results found
                    @else 
                    No results found
                @endif</h2>
            </div>

        </div>
    </div>
</header>
    
@include('main.components.service')



@endsection

