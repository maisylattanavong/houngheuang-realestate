<div>

    <div class="banner-search">


        <!-- banner -->
        <h3 style="padding-top:5px">@lang('frontend.search')</h3>
        <div class="searchbar">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <input type="text" wire:model="search" class="form-control" placeholder="@lang('frontend.search_of_properties')">
                    <div class="row">

                        <div class="col-lg-3 col-sm-3">
                            @php
                                $categories = App\Models\Category::all();
                            @endphp
                            <select class="form-control form-select form-select-sm" aria-label=".form-select-sm example"
                                wire:model="category">
                                <option value="">@lang('frontend.select_category')</option>
                                @forelse ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item['name'] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <select class="form-control" wire:model="price">
                                <option>@lang('frontend.price')</option>
                                <option value="50000">$0 - $50,000</option>
                                <option value="100000">$50,000 - $100,000</option>
                                <option value="200000">$100,000 - $200,000</option>
                                <option value="500000">$200,000 - @lang('frontend.above')</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-3">
                            <select class="form-control form-select form-select-sm" aria-label=".form-select-sm example"
                                wire:model="area">
                                <option value="">@lang('frontend.area') (㎡)</option>
                                <option value="1000"> ... <= 1,000 (㎡)</option>
                                <option value="10000"> 1,001 - 100,00 (㎡)</option>
                                <option value="50000">10,001 - 50,000 (㎡)</option>
                                <option value="50001">50,001 - @lang('frontend.above') (㎡)</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-3 ">
                            <select class="form-control form-select form-select-sm" aria-label=".form-select-sm example"
                                wire:model="orderBy">
                                <option value="asc">ASC</option>
                                <option value="desc">DESC</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-3">
                            <select class="form-control form-select form-select-sm" aria-label=".form-select-sm example"
                                wire:model="perPage">
                                <option value="8">8 @lang('frontend.items')</option>
                                <option value="12">12 @lang('frontend.items')</option>
                                <option value="16">16 @lang('frontend.items')</option>
                            </select>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="col-lg-12 col-sm-12">
            <div class="row">
                <!-- properties -->
                @forelse ($realestates as $item)
                    <div class="col-lg-3 col-sm-6 mt-2">
                        <div class="properties">
                            <div class="image-holder"><img src="{{ asset($item->feature_image) }}"
                                    class="img-responsive" alt="properties" style="height:170px">
                            </div>
                            <h4><a href="">{{ $item->title }}</a></h4>
                            <p class="price">@lang('frontend.price') $ {{ $item->price }}</p>
                            <p class="price">@lang('frontend.area') {{ $item->area }} m&sup2</p>
                            <button class="btn btn-primary"
                                wire:click="propertyDetail({{ $item->id }})">@lang('frontend.view_details')</button>
                        </div>
                    </div>
                @empty
                    <div class="properties">
                        <h4>@lang('frontend.not_found')</h4>
                    </div>
                @endforelse

                <div class="center">
                    {{-- @if (!is_null($realestates))
                {{ $realestates->links() }}
                @endif --}}
                    {{ $realestates->links('vendor.livewire.livewire-pagination-links') }}
                </div>
            </div>
        </div>
    </div>
</div>
