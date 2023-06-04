{{-- <div class="nav">
    <div class="container navbar">
        <a class="navbar-brand" href="{{ route('index.page') }}">
            <div class="itech-logo">
                @forelse($footer as $item)
                    <img src="{{ asset($item->logo) }}" alt="">

                @empty
                    <img src="{{ url('upload/no_image.jpg') }}" alt="">
                @endforelse
            </div>
        </a>

        <a href="#" class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </a>
        <div class="navbar-links">
            <ul>
                <li>
                    <a href="{{ route('index.page') }}">@lang('header.home')</a>
                </li>
                <div class="vertical"></div>
                <li><a href="{{route('home.about')}}" class="nav-links"
                        data-href="{{ route('home.about') }}">@lang('header.aboutus')</a></li>
                <div class="vertical"></div>
                <li><a href="{{ route('home.contact') }}" class="nav-links">@lang('header.contact')</a>
                </li>
                <div class="vertical"></div>
                <li><a href="{{ route('all.post.page') }}" class="nav-links">@lang('header.events')</a>
                </li>
                <div class="d-lg-inline-block">
                    <a href="#" class="nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown">
                        @php
                            $lang = App::getLocale();
                        @endphp
                        <span class="{{ $lang == 'en' ? 'fi fi-us' : ($lang == 'la'?'fi fi-la':'fi fi-cn') }}"></span>
                        {{ $lang == 'en' ? 'English' : ($lang == 'la' ? 'ລາວ':'中国人') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 190px">
                        @foreach (config('app.available_locales') as $locale)
                            <a class="btn-sm" style="text-decoration: none"
                                href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => $locale])) }}">
                                @if ($lang == 'en')
                                    @if ($locale == 'cn')
                                        <span class="fi fi-cn"></span><span> 中国人</span>
                                    @endif
                                    @if ($locale == 'la')
                                        <span class="fi fi-la"></span><span> ລາວ</span>
                                    @endif
                                @endif

                                @if ($lang == 'la')
                                    @if ($locale == 'en')
                                        <span class="fi fi-us"></span><span> English</span>
                                    @endif
                                    @if ($locale == 'cn')
                                        <span class="fi fi-cn"></span><span> 中国人</span>
                                    @endif
                                @endif
                                @if ($lang == 'cn')
                                    @if ($locale == 'en')
                                        <span class="fi fi-us"></span><span> English</span>
                                    @endif
                                    @if ($locale == 'la')
                                        <span class="fi fi-la"></span><span> ລາວ</span>
                                    @endif
                                @endif

                            </a>
                        @endforeach

                    </div>
                </div>
            </ul>
        </div>
    </div>
</div> --}}

<!-- Header Starts -->
<div class="navbar-wrapper">

    <div class="navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>


            <!-- Nav Starts -->
            <div class="navbar-collapse  collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Agents</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </div>
            <!-- #Nav Ends -->

        </div>
    </div>

</div>
<!-- #Header Starts -->



<div class="container">

    <!-- Header Starts -->
    <div class="header">
        <a href="/"><img src="{{ asset('frontend/assets/images/logo.png') }}" alt="Realestate"></a>

        <ul class="pull-right">
            <li><a href="">Buy</a></li>
            <li><a href="">Sale</a></li>
            <li><a href="">Rent</a></li>
        </ul>
    </div>
    <!-- #Header Starts -->
</div>
