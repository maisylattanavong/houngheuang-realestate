@extends('frontend.main_master')

@section('frontend')
    <!-- banner -->
    {{-- <div class="inside-banner">
        <div class="container">
            <h2>@lang('frontend.properties_detail')</h2>
        </div>
    </div> --}}
    <!-- banner -->
    <div class="container">
        <div class="properties-listing spacer">

            <div class="row">
                <div class="col-lg-3 col-sm-4 hidden-xs">

                    <div class="hot-properties hidden-xs">
                        <h4>@lang('frontend.hot_properties')</h4>
                        @forelse ($detail->category_id == '1' ? $hot_buy_properties : ($detail->category_id == '2' ?
                                                $hot_sale_properties : $hot_rent_properties) as $item)
                            <div class="row">
                                <div class="col-lg-4 col-sm-5"><img src="{{ asset($item->feature_image) }}"
                                        class="img-responsive img-circle" alt="properties" /></div>
                                <div class="col-lg-8 col-sm-7">
                                    <h5><a href="{{ route('property.detail', $item->id) }}"
                                            class="learnmore">{{ $item->title }}</a></h5>
                                    <p class="price">$ {{ $item->price }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="row">
                                <div class="col-lg-12 col-sm-5">
                                    <h5>@lang('frontend.not_found') !</h5>
                                </div>

                            </div>
                        @endforelse
                    </div>

                    {{-- <div class="advertisement">
                        <h4>@lang('frontend.advertisements')</h4>
                        <img src="{{ asset('frontend/assets/images/advertisements.jpg') }}" class="img-responsive"
                            alt="advertisement">
                    </div> --}}
                </div>

                <div class="col-lg-9 col-sm-8 ">

                    <h2>{{ $detail->title }}</h2>
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="property-images">
                                <!-- Slider Starts -->
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                    <!-- Loop item for dot icon slider-->
                                    @php
                                        $count_single_slides = count($multi_images);
                                    @endphp
                                    <ol class="carousel-indicators hidden-xs">
                                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                        @for ($i = 2; $i <= $count_single_slides; $i++)
                                            <li data-target="#myCarousel" data-slide-to="{{ $i }}"
                                                class=""></li>
                                        @endfor
                                    </ol>

                                    <div class="carousel-inner">
                                        <!-- First image for active slider -->
                                        <div class="item active">
                                            <img src="{{ asset($last_image_slide->image) }}" class="properties"
                                                alt="properties" />
                                        </div>

                                        <!-- Except first image for all sliders -->
                                        @if (!is_null($multi_images_l))
                                            @forelse ($multi_images_l as $item)
                                                <div class="item">
                                                    <img src="{{ asset($item->image) }}" class="properties"
                                                        alt="properties" />
                                                </div>
                                            @empty
                                                <div class="row justify-center">
                                                    <div class="col-lg-12 col-sm-5">
                                                        <h5>Image not found !</h5>
                                                    </div>

                                                </div>
                                            @endforelse
                                        @endif
                                    </div>

                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span
                                            class="glyphicon glyphicon-chevron-left"></span></a>
                                    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span
                                            class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                                <!-- #Slider Ends -->

                            </div>

                            <div class="spacer">
                                <h4><span class="glyphicon glyphicon-th-list"></span> @lang('frontend.detail')</h4>
                                <p>{!! $detail->description !!}</p>

                            </div>
                            @if (!is_null($detail->map))
                                <div>
                                    <h4><span class="glyphicon glyphicon-map-marker"></span> @lang('frontend.location')</h4>
                                    <div class="well">
                                        <iframe width="100%" height="350" frameborder="0" scrolling="no"
                                            marginheight="0" marginwidth="0" src="{{ $detail->map }}"></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="col-lg-12  col-sm-6">
                                <div class="property-info">
                                    <p class="price">$ {{ $detail->price }}</p>
                                    <p class="area"><span class="glyphicon glyphicon-map-marker"></span>
                                        {{ $detail->address }}</p>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12 col-sm-6 ">
                                <div class="enquiry">
                                    <h6><span class="glyphicon glyphicon-envelope"></span> @lang('frontend.post_enquiry')</h6>
                                    <form role="form">
                                        <input type="text" class="form-control" placeholder="@lang('frontend.full_name')" />
                                        <input type="text" class="form-control" placeholder="example@gmail.com" />
                                        <input type="text" class="form-control" placeholder="@lang('frontend.your_number')" />
                                        <textarea rows="6" class="form-control" placeholder="@lang('frontend.whats_on_your_mind')"></textarea>
                                        <button type="submit" class="btn btn-primary"
                                            name="Submit">@lang('frontend.send_message')</button>
                                    </form>
                                </div>
                            </div>
                             --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
