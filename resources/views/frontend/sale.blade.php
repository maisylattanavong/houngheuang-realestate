@extends('frontend.main_master')
@section('frontend')

    <!-- banner -->
    <div class="container">
        <div class="properties-listing spacer">
            <div class="row">

                <!-- search and hot property -->
                <div class="col-lg-3 col-sm-4 ">
                    <div class="search-form">
                        <h4><span class="glyphicon glyphicon-search"></span> @lang('frontend.search_for')</h4>
                        <input type="text" class="form-control" placeholder="Search of Properties">
                        <div class="row">
                            <div class="col-lg-5">
                                <select class="form-control">
                                    <option>Buy</option>
                                    <option>Rent</option>
                                    <option>Sale</option>
                                </select>
                            </div>
                            <div class="col-lg-7">
                                <select class="form-control">
                                    <option>Price</option>
                                    <option>$150,000 - $200,000</option>
                                    <option>$200,000 - $250,000</option>
                                    <option>$250,000 - $300,000</option>
                                    <option>$300,000 - above</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <select class="form-control">
                                    <option>Property Type</option>
                                    <option>Apartment</option>
                                    <option>Building</option>
                                    <option>Office Space</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary">@lang('frontend.find_now')</button>

                    </div>


                    <div class="hot-properties hidden-xs">
                        <h4>Hot Properties</h4>
                        @forelse ($hot_sale_properties as $item)
                            <div class="row">
                                <div class="col-lg-4 col-sm-5"><img src="{{ asset($item->feature_image) }}"
                                        class="img-responsive img-circle" alt="properties"></div>
                                <div class="col-lg-8 col-sm-7">
                                    <h5><a
                                            href="{{ route('property.detail', $item->id) }}"class="learnmore">{{ $item->title }}</a>
                                    </h5>
                                    <p class="price">$ {{ $item->price }}</p>
                                </div>
                            </div>
                        @empty
                            @lang('frontend.not_found')
                        @endforelse

                    </div>
                </div>


                <!-- properties -->
                <div class="col-lg-9 col-sm-8">
                    <div class="sortby clearfix">
                        <div class="pull-right">
                            <select class="form-control">
                                <option>@lang('frontend.sort_by')</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        @forelse ($sales as $item)
                            <div class="col-lg-4 col-sm-6">
                                <div class="properties">
                                    <div class="image-holder"><img src="{{ asset($item->feature_image) }}"
                                            class="img-responsive" alt="properties"style="height:160px">
                                    </div>
                                    <h4><a href="">{{ $item->title }}</a></h4>
                                    <p class="price">@lang('frontend.price') $ {{ $item->price }}</p>
                                    <p class="price">@lang('frontend.area') {{ $item->area }} m&sup2</p>
                                    <a class="btn btn-primary"
                                        href="{{ route('property.detail', $item->id) }}">@lang('frontend.view_details')</a>
                                </div>
                            </div>
                        @empty
                            <div class="properties">
                                <h4>@lang('frontend.not_found')</h4>
                            </div>
                        @endforelse
                    </div>
                    <!-- properties -->
                    @if (!is_null($sales))
                        <div class="center">
                            {{ $sales->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
