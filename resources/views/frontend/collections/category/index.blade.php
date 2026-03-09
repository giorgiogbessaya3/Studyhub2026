@extends('layouts.app')

@section('title', 'All category')

@section('content')
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h3 class="display-3 mb-4 animated slideInDown">Categories de services</h3>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories de Services</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Service Start -->
    <div class="container-xxl service py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block border rounded text-primary fw-semi-bold py-1 px-3">Les Categories De Services</p>
                <h5 class="display-6 mb-2">Les Types De Services Disponible</h5>
            </div>
            <div class="row g-4">
                @forelse($categories as $categoryItem)
                <div class="col-lg-4 col-md-4 mx-auto wow fadeInUp shadow" data-wow-delay="0.1s">
                    <div class="service-item position-relative h-100">
                        <div class="service-text rounded p-5">
                            <div class="btn-square bg-light rounded-circle mx-auto mb-4" style="width: 64px; height: 64px;">
                                <img class="img-fluid" src="{{asset("$categoryItem->image")}}" alt="Icon">
                            </div>
                            <h5 class="mb-3">{{$categoryItem->name}}</h4>
                            <p class="mb-0">{{$categoryItem->description}}</p>
                        </div>
                        <div class="service-btn rounded-0 rounded-bottom m-3">
                            <a class="btn btn-primary text-ligth fw-medium mx-auto" href="{{url('/collections/'.$categoryItem->slug)}}">Voir Plus<i class="bi bi-chevron-double-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12">
                    <h5>Pas de Categories Valable</h5>
                </div>
                @endforelse
                
            </div>
        </div>
    </div>
<!-- Service End -->


@endsection












