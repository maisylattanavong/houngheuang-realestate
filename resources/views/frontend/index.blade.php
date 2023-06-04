@extends('frontend.main_master')

@section('frontend')

    <div class="">
        <div id="slider" class="sl-slider-wrapper">
            @forelse ($slider_properties as $item)
                <div class="sl-slider">
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25"
                        data-slice1-scale="2" data-slice2-scale="2">
                        {{-- <div class="sl-slide-inner">
                            <div class="bg-img">
                            <img class="bg-img" src="{{ asset($item->feature_image) }}" />
                            </div>
                            <h2><a href="{{ route('property.detail', $item->id) }}">{{ $item->title }}</a></h2>
                            <blockquote>
                                <a href="{{ route('property.detail', $item->id) }}">
                                <p class="location"><span class="glyphicon glyphicon-map-marker"></span>{{ $item->address }}
                                </p>
                                    <p>{!! Str::limit(strip_tags($item->description), '300') !!}</p>

                                </a>
                                <a href="{{ route('property.detail', $item->id) }}" class="price-btn"><cite>$
                                        {{ $item->price }}</cite></a>
                            </blockquote>
                        </div> --}}
                        <div class="sl-slide-inner">
                            <div class="bg-img">
                                <img class="bg-img" src="{{ asset($item->feature_image) }}" />
                            </div>

                            <blockquote>
                                <div class="slider">
                                    <a href="{{ route('property.detail', $item->id) }}">
                                        <h3>{{ $item->title }}</h3>
                                        <p class="location"><span
                                                class="glyphicon glyphicon-map-marker"></span>{{ $item->address }}
                                        </p>

                                        <p>{!! Str::limit(strip_tags($item->description), '300') !!}</p>
                                    </a>
                                    <a href="{{ route('property.detail', $item->id) }}" class="price-btn"><cite>$
                                            {{ $item->price }}</cite></a>
                                </div>

                            </blockquote>
                        </div>
                    </div>
                </div><!-- /sl-slider -->
            @empty
                <div class="sl-slider">
                    <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25"
                        data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                        <div class="sl-slide-inner">
                            <p class="notfound">@lang('frontend.not_found')</p>
                        </div>
                    </div>

                </div><!-- /sl-slider -->
            @endforelse
            @php
                $count_five_sliders = count($slider_properties);
            @endphp
            <nav id="nav-dots" class="nav-dots">
                @for ($i = 1; $i <= $count_five_sliders; $i++)
                    {{-- <span class="">{{ $i }}</span> --}}
                    <span class=""></span>
                @endfor
            </nav>

        </div><!-- /slider-wrapper -->

    </div>

    <!-- Search -->

    <div class="properties-listing spacer">
        <livewire:realsearch />
    </div>

    <!-- /Search -->

    <!-- Container -->
    <div class="container">

        <!-- Featured Properties -->
        <div class="properties-listing spacer">
            {{-- <a href="{{ route('buy.sale.rent') }}"
                class="pull-right viewall learnmore">@lang('frontend.view_all_listing')</a> --}}
            <h2>@lang('frontend.featured_properties')</h2>
            <div id="owl-example" class="owl-carousel">
                @forelse ($realestates as $item)
                    <div class="properties">
                        <div class="image-holder"><img src="{{ asset($item->feature_image) }}" class="img-responsive"
                                alt="properties" style="height:160px" />
                            <div class="status sold">
                                {{ $item->category_id == '1' ? 'Buy' : ($item->category_id == '2' ? 'Sale' : 'Rent') }}
                            </div>
                        </div>
                        <h4><a href="{{ route('property.detail', $item->id) }}">{{ $item->title }}</a></h4>
                        <p class="price">@lang('frontend.price') $ {{ $item->price }}</p>
                        <p class="price">@lang('frontend.area') {{ $item->area }} m&sup2</p>
                        <a class="btn btn-primary" href="{{ route('property.detail', $item->id) }}">@lang('frontend.view_details')</a>

                    </div>
                @empty
                    @lang('frontend.not_found')
                @endforelse
            </div>
        </div>

        <div class="spacer">
            <div class="row">
                <div class="col-lg-6 col-sm-9 recent-view">
                    <h3>@lang('frontend.about_us')</h3>
                    @if (is_null($aboutCompany))
                        <p>@lang('frontend.not_found')</p>
                    @else
                        <p>{!! Str::limit(strip_tags($aboutCompany->about), '300') !!}<br><a href="{{ route('about') }}"
                                class="learnmore">@lang('frontend.learn_more')</a></p>
                    @endif
                </div>
                <div class="col-lg-5 col-lg-offset-1 col-sm-3 recommended">
                    @php
                        $count_recommend_sliders = count($recommended_properties);
                    @endphp
                    @if (!is_null($recommended_properties))
                        <h3>@lang('frontend.recommended_properties')</h3>
                        <div id="myCarousel" class="carousel slide">

                            <!-- Loop item for dot icon slider-->
                            <ol class="carousel-indicators">
                                @if ($count_recommend_sliders > 1)
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                @endif
                                @for ($i = 2; $i <= $count_recommend_sliders; $i++)
                                    <li data-target="#myCarousel" data-slide-to="{{ $i }}" class=""></li>
                                @endfor
                            </ol>
                    @endif

                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        @if (!is_null($recommended_properties_latest))
                            <div class="item active">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="{{ route('property.detail', $recommended_properties_latest->id) }}">
                                            <img src="{{ $recommended_properties_latest->feature_image }}"
                                                class="img-responsive" alt="properties" /></a>
                                    </div>
                                    <div class="col-lg-8">
                                        <h5><a href="{{ route('property.detail', $recommended_properties_latest->id) }}"
                                                class="learnmore">{{ $recommended_properties_latest->title }}</a>
                                        </h5>
                                        <p class="price">$ {{ $recommended_properties_latest->price }}</p>
                                        <a href="{{ route('property.detail', $recommended_properties_latest->id) }}"
                                            class="more">@lang('frontend.more_detail')</a>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @forelse ($recommended_properties as $item)
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="{{ route('property.detail', $item->id) }}">
                                            <img src="{{ asset($item->feature_image) }}" class="img-responsive"
                                                alt="properties" /></a>
                                    </div>
                                    <div class="col-lg-8">
                                        <h5><a href="{{ route('property.detail', $item->id) }}"
                                                class="learnmore">{{ $item->title }}</a></h5>
                                        <p class="price">$ {{ $item->price }}</p>
                                        <a href="{{ route('property.detail', $item->id) }}"
                                            class="more">@lang('frontend.more_detail')</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @lang('frontend.not_found')
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
