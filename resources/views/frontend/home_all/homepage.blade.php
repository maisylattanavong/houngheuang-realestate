@extends('frontend.main_master')

@section('main')
    <main>
        @if ($count == 0)
            <section class="container_fluid">
                <div class="slider-container">
                    <button type="button" class="previous">
                        <i class="fas fa-chevron-left" style="font-size: 25px"></i>
                    </button>
                    <div class="slider">
                        <div class="banner-slider">
                            <a href="#">
                                <img src="{{ asset('frontend/assets/img/No-slider.png') }}" alt=""
                                    style="width: 100%">
                            </a>
                        </div>
                    </div>
                    <button type="button" class="next">
                        <i class="fas fa-chevron-right" style="font-size: 25px"></i>
                    </button>
                </div>
            </section>
        @else
            <section class="container_fluid">
                <div class="slider-container">
                    <button type="button" class="previous">
                        <i class="fas fa-chevron-left" style="font-size: 25px"></i>
                    </button>
                    <div class="slider">
                        <div class="banner-slider">
                            @forelse ($banner_slide as $item)
                                <a href="{{ route('home.banner', $item->id) }}">
                                    <img src="{{ asset($item->image) }}" alt="" style="width:100%">
                                </a>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <button type="button" class="next">
                        <i class="fas fa-chevron-right" style="font-size: 25px"></i>
                    </button>
                </div>
            </section>
        @endif

        @if ($category == '' || $category == null || count($category) == 0)
            <div class="not-found">
                <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                <h3>No category yet!! <a href="{{ route('status.login', 5) }}" type="button" class="btn btn-light">Create
                        new</a></h3>
            </div>
        @else
            <section class="section2 bg-light">
                <h2 class="mt-4">@lang('header.products_category')</h2>
                <div class="container">
                    @if (count($category) > 4)
                        <button type="button" class="btn btn-outline-secondary cat-previous">
                            <i class="fas fa-chevron-left" style="font-size: 25px"></i>
                        </button>
                    @else
                        <p></p>
                    @endif
                    @if ($category == '')
                        <h1 style="color: black">There is no banner slide yet!!</h1>
                    @else
                        <div class="slider">
                            <div class="category-slider">
                                @foreach ($category as $item)
                                    <div class="wrapper">
                                        <div class="card">
                                            <img src="{{ asset($item->image) }}" />
                                            <div class="info">
                                                <h3>{{ $item->name }}</h3>
                                                <a type="button"
                                                    href="{{ route('category.post', ['locale' => app()->getLocale(), 'category_id' => $item->slug]) }}"
                                                    class="button"><i class="fas fa-eye"></i>
                                                    @lang('messages.button')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (count($category) > 4)
                        <button type="button" class="btn btn-outline-secondary cat-next">
                            <i class="fas fa-chevron-right" style="font-size: 25px"></i>
                        </button>
                    @else
                        <p></p>
                    @endif
                </div>
            </section>
        @endif


        @if ($post == '' || $post == null || count($post) == 0)
            <div class="not-found">
                <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                <h3>No post data yet!! <a href="{{ route('status.login', 1) }}" type="button" class="btn btn-light">Create
                        new</a></h3>
            </div>
        @else
            <section class="section3">
                <div class="container product-container">
                    <h5>@lang('header.top4post')</h5>
                    <div class="row">
                        @foreach ($post as $item)
                            @if ($loop->iteration % 2 == 0)
                                <div class="verti-reverse mt-5">
                                    <div class="col-md-6 content">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $item->title }}</h4>
                                            <p class="card-text" style="display:flex; text-align:justify; text-indent:20px">
                                                {!! Str::limit(strip_tags($item->description), '600') !!}
                                            </p>
                                            <p class="card-text">
                                            </p>
                                            <div class="card-footers">
                                                <div class="view-more">
                                                    <a type="button"
                                                        href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                                        class="btn btn-outline-primary btn-sm opacity-75"><i
                                                            class="fas fa-eye"></i>
                                                        @lang('messages.button')
                                                    </a>&nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="btn btn-outline-primary btn-sm opacity-75"
                                                        data-toggle="modal" data-target="#exampleModalCenter">
                                                        <i class="fas fa-share-alt"></i>&nbsp;&nbsp;Share
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset($item->feature_image) }}" alt="" class="rounded">
                                    </div>
                                </div>
                            @else
                                <div class="reverse">
                                    <div class="col-md-6 content">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $item->title }}</h4>

                                            <p class="card-text" style="display:flex; text-align:justify; text-indent:20px">
                                                {!! Str::limit(strip_tags($item->description), '600') !!}

                                            </p>
                                            <p class="card-text">
                                            </p>
                                            <div class="card-footers">
                                                <div class="view-more">
                                                    <a type="button"
                                                        href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                                        class="btn btn-outline-primary btn-sm opacity-75"><i
                                                            class="fas fa-eye"></i>
                                                        @lang('messages.button')
                                                    </a>&nbsp;&nbsp;&nbsp;
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm opacity-75"
                                                        data-toggle="modal" data-target="#exampleModalCenter">
                                                        <i class="fas fa-share-alt"></i>&nbsp;&nbsp;Share
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset($item->feature_image) }}" alt="" class="rounded">
                                    </div>
                                </div>
                            @endif

                            {{-- share model start here  --}}
                            <div class="modal fade" id="exampleModalCenter" name="bb" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Share to social media.
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <a class="copy_text" data-dismiss="modal" aria-hidden="true"
                                                href="{{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"><i
                                                    class="fas fa-copy"></i>&nbsp;&nbsp;Copy link</a>
                                            <a
                                                href="https://wa.me/?text={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"class="whatsapp"><i
                                                    class="fab fa-whatsapp-square" style="color: rgb(0, 177, 0)"
                                                    target="_blank"></i>&nbsp;&nbsp;Whatsapp</a>
                                            <a href="fb-messenger://share/?link={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"
                                                class="messenger"><i class="fab fa-facebook-messenger"
                                                    style="color: rgb(165, 0, 165)"></i>&nbsp;&nbsp;Messenger</a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=436,width=626');return false;"
                                                target="_blank" title="Share on Facebook" title="Share on Facebook"
                                                class="facebook"><i class="fab fa-facebook-square"
                                                    style="color: rgb(0, 29, 176)"></i>&nbsp;&nbsp;Facebook</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                                                    class="fas fa-times"></i>&nbsp;&nbsp;Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Messenger ปลั๊กอินแชท Code -->
                <div id="fb-root"></div>

                <!-- Your ปลั๊กอินแชท code -->
                <div id="fb-customer-chat" class="fb-customerchat">
                </div>
            </section>
        @endif
    </main>
@endsection
