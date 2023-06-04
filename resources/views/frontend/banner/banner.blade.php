@extends('frontend.main_master')
@section('main')
<section class="top_page_space">
</section>
<main>
    <div class="company-info-image">
        <img src="{{ asset($banner->image) }}" alt="about image">
    </div>
    <div class="container mt-3 mb-5">
        <h3 class="text-center">{{ $banner->title }}</h3>
        <div>
            <p>{!! $banner->description !!}</p>
        </div>
        <a href="{{ $banner->link }}" target="_blank">Reference Information</a>
    </div>
</main>
@endsection
