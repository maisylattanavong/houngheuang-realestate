<div>
    <div class="row">
        @php

            // $cat = App\Models\CategoryTranslation::where('name', request()->segment(3))->first();
            // $propertyCats = App\Models\Realestate::where('publish', '1')
            //     ->where('category_id', $cat->category_id)
            //     ->paginate(6);
            // $hot_properties = App\Models\Realestate::where('publish', '1')
            //     ->where('hot_property', '1')
            //     ->where('category_id', $cat->category_id)
            //     ->latest()
            //     ->take(4)
            //     ->get();
            $hot_properties = App\Models\Realestate::where('publish', '1')->where('hot_property', '1')->latest()->take(4)->get();

        @endphp

        <!-- search and hot property -->
        <div class="col-lg-3 col-sm-4 ">

            <div class="search-form">
                <h4><span class="glyphicon glyphicon-search"></span> @lang('frontend.search_for')</h4>
                <input type="text" wire:model="search" class="form-control" placeholder="Search of Properties">
                {{-- <input type="hidden" wire:model="category" value="{{ $cat->category_id }}"> --}}
                <div class="row">
                    <div class="col-lg-6">
                        @php
                            $categories = App\Models\Category::all();
                        @endphp
                        <select class="form-control form-select form-select-sm" aria-label=".form-select-sm example"
                            wire:model="category">
                            {{-- <option value="">Category</option> --}}
                            @forelse ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item['name'] }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" wire:model="price">
                            <option>Price</option>
                            <option value="50000">$0 - $50,000</option>
                            <option value="100000">$50,000 - $100,000</option>
                            <option value="200000">$100,000 - $200,000</option>
                            <option value="500000">$200,000 - above</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" wire:model="area">
                            <option value="">Area (㎡)</option>
                            <option value="1000"> 0 - 1,000 (㎡)</option>
                            <option value="10000"> 10,001 - 10,000 (㎡)</option>
                            <option value="50000">10,001 - 50,000 (㎡)</option>
                            <option value="50001">50,001 - above (㎡)</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control form-select form-select-sm "
                            aria-label=".form-select-sm example" wire:model="orderBy">
                            <option value="asc">ASC</option>
                            <option value="desc">DESC</option>
                        </select>
                    </div>
                </div>

            </div>


            <div class="hot-properties hidden-xs">
                <h4>@lang('frontend.hot_properties')</h4>
                @forelse ($hot_properties as $item)

                    <div class="row">
                        <div class="col-lg-4 col-sm-5"><img src="{{ asset($item->feature_image) }}"
                                class="img-responsive img-circle" alt="properties"></div>
                        <div class="col-lg-8 col-sm-7">
                            {{-- <h5><a
                                    href="{{ route('property.detail', $item->id) }}"class="learnmore">{{ $item->title }}</a>
                            </h5> --}}
                            <button class="button_hot"
                            wire:click="propertyDetail({{ $item->id }})">{{ $item->title }}</button>
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
            <div class="row">
                @forelse ($propertyCats as $item)
                    <div class="col-lg-4 col-sm-6">
                        <div class="properties">
                            <div class="image-holder"><img src="{{ asset($item->feature_image) }}"
                                    class="img-responsive" alt="properties"style="height:160px">
                            </div>
                            <h4><a href="">{{ $item->title }}</a></h4>
                            <p class="price">@lang('frontend.price') $ {{ $item->price }}</p>
                            <p class="price">@lang('frontend.area') {{ $item->area }} m&sup2</p>
                            {{-- <a class="btn btn-primary"
                                href="{{ route('property.detail', $item->id) }}">@lang('frontend.view_details')</a> --}}
                                <button class="btn btn-primary"
                            wire:click="propertyDetail({{ $item->id }})">@lang('frontend.view_details')</button>
                        </div>
                    </div>
                @empty
                    <div class="properties">
                        <h4>@lang('frontend.not_found')</h4>
                    </div>
                @endforelse
            </div>
            <!-- properties -->
            @if (!is_null($propertyCats))
                <div class="center">
                    {{ $propertyCats->links('vendor.livewire.livewire-pagination-links') }}
                </div>
            @endif
        </div>
    </div>
</div>
