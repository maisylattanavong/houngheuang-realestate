<div>
    <div class="row">
        <!-- search and hot property -->
        <div class="col-lg-3 col-sm-4 ">

            <div class="search-form">
                <h4><span class="glyphicon glyphicon-search"></span> @lang('frontend.search_for')</h4>
                <input type="text" wire:model="search" class="form-control" placeholder="@lang('frontend.search_of_properties')">
                <div class="row">
                    <div class="col-lg-6">
                        <select class="form-control" wire:model="price">
                            <option>@lang('frontend.price')</option>
                            <option value="50000" >$0 - $50,000</option>
                            <option value="100000">$50,000 - $100,000</option>
                            <option value="200000">$100,000 - $200,000</option>
                            <option value="500000">$200,000 - above</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" wire:model="area">
                            <option value="">@lang('frontend.area') (㎡)</option>
                            <option value="1000"> 0 - 1,000 (㎡)</option>
                            <option value="10000"> 10,001 - 10,000 (㎡)</option>
                            <option value="50000">10,001 - 50,000 (㎡)</option>
                            <option value="50001">50,001 - above (㎡)</option>
                        </select>
                    </div>
                    <div class="col-lg-5">
                        <select class="form-control form-select form-select-sm "
                            aria-label=".form-select-sm example" wire:model="orderBy">
                            <option value="asc">ASC</option>
                            <option value="desc">DESC</option>
                        </select>
                    </div>
                    <div class="col-lg-7">
                        <select class="form-control form-select form-select-sm "
                            aria-label=".form-select-sm example" wire:model="orderByPrice">
                            <option value="asc">@lang('frontend.price'): @lang('frontend.low_high')</option>
                            <option value="desc">@lang('frontend.price'): @lang('frontend.high_low')</option>
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
