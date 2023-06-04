<!-- Header Starts -->
<div class="navbar-wrapper">

    <div class="navbar-inverse" role="navigation">
        <div class="container">

            <div class="navbar-header">
                @if (!is_null($aboutCompany))
                    <a href="{{ route('index') }}"><img src="{{ asset($aboutCompany->logo) }}" alt="Realestate"
                            style="height: 70px;"></a>
                @else
                    <img src="{{ asset('upload/no_image.jpg') }}" alt="Realestate" style="height: 70px;">
                @endif
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            @php
                $currenturl = request();
            @endphp

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    @php
                        $categories = App\Models\Category::all();
                    @endphp
                    @forelse ($categories as $item)
                        <li class="{{ request()->segment(3) == Str::lower($item['name']) ? 'active' : '' }}"><a
                                href="{{ route('property.cat', Str::lower($item['name'])) }}">
                                {{ $item['name'] }}</a></li>
                    @empty
                    @endforelse

                    <li class="{{ request()->segment(2) == 'about' ? 'active' : '' }}"><a
                            href="{{ route('about') }}">@lang('frontend.about')</a></li>
                    <li class="{{ request()->segment(2) == 'guide' ? 'active' : '' }}"><a
                            href="{{ route('guide') }}">@lang('frontend.guide')</a></li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" id="navbarDropdownMenuLink"
                            data-toggle="dropdown">
                            @php
                                $lang = App::getLocale();
                            @endphp
                            <span
                                class="{{ $lang == 'en' ? 'fi fi-us' : ($lang == 'la' ? 'fi fi-la' : 'fi fi-cn') }}"></span>
                            {{ $lang == 'en' ? 'English' : ($lang == 'la' ? 'ລາວ' : '中国人') }} <i
                                class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            @foreach (config('app.available_locales') as $locale)
                                <a class="dropdown-item " style="text-decoration: none"
                                    href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => $locale])) }}">

                                    @if ($lang == 'en')
                                        @if ($locale == 'la')
                                            &nbsp;&nbsp;<span class="fi fi-la"></span><span> ລາວ</span><br />
                                        @endif
                                        @if ($locale == 'cn')
                                            &nbsp;&nbsp;<span class="fi fi-cn"></span><span> 中国人</span>
                                        @endif
                                    @endif

                                    @if ($lang == 'la')
                                        @if ($locale == 'en')
                                            &nbsp;&nbsp;<span class="fi fi-us"></span><span> English</span><br />
                                        @endif
                                        @if ($locale == 'cn')
                                            &nbsp;&nbsp;<span class="fi fi-cn"></span><span> 中国人</span>
                                        @endif
                                    @endif
                                    @if ($lang == 'cn')
                                        @if ($locale == 'en')
                                            &nbsp;&nbsp;<span class="fi fi-us"></span><span> English</span><br />
                                        @endif
                                        @if ($locale == 'la')
                                            &nbsp;&nbsp;<span class="fi fi-la"></span><span> ລາວ</span>
                                        @endif
                                    @endif

                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</div>
<!-- #Header Starts -->
