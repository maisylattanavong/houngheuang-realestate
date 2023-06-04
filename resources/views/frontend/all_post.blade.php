@extends('frontend.main_master')
@php
    $firstPost = App\Models\Post::latest()
        ->take(1)
        ->get();
@endphp
@section('main')
    <section class="top_page_space">
    </section>
    <main>
        <section class="jumbotron jumbotron-container">
            <div class="container text-end">
                <form class="form-inline my-2 my-lg-0" action="{{ route('all.post.page') }}" method="GET"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-flex text-align-center justify-content-center" style="width:100%">
                            <input class="form-control input-sm" id="inputsm" type="search" placeholder="Search........"
                                name="search" aria-label="Search">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-outline-secondary btn-lg" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="jumbotron text-center pt-4 pb-5 bg-light">
            <div class="container event-header-container">
                <div class="row" style="width:100%">
                    <div class="col-md-6 single-event-thumnail">
                        @forelse($firstPost as $item)
                            <a href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                class="event-header-left-container">
                                <img src="{{ asset($item->feature_image) }}" alt="{{ $item->title }}">
                                <div class="ms-4 mt-3 d-flex align-items-start flex-column">
                                    <div><button
                                            style="border:none; border-radius:5px; padding:2px 15px; color:gray">published</button>
                                        &nbsp;
                                        <span
                                            style="font-size:12px; color:rgb(167, 167, 167)">({{ $item->created_at->diffForHumans() }})</span>
                                    </div>
                                    <b class="text-black mt-2">{!! Str::limit(strip_tags($item->title), '20') !!}</b>
                                    <p class="card-text">{!! Str::limit(strip_tags($item->description), '60') !!}</p>
                                </div>

                            </a>
                        @empty
                        @endforelse
                    </div>
                    <div class="col-md-6">
                        <div class="event-header-right-container">
                            @forelse($posts as $item)
                                <a href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                    class="d-flex align-items-center justify-content-start mt-2 event-thumnail"
                                    style="cursor: pointer; text-decoration: none;">
                                    <img src="{{ asset($item->feature_image) }}" alt="{{ $item->title }}"
                                        style="width: 150px; height:100px">
                                    <div class="ms-3 d-flex align-items-start flex-column event-thumnail-content">
                                        <div class="published"><button
                                                style="border:none; border-radius:5px; padding:2px 15px; color:gray">published</button>
                                            &nbsp;
                                            <span
                                                style="font-size:12px; color:rgb(167, 167, 167)">({{ $item->created_at->diffForHumans() }})</span>
                                        </div>
                                        <b class="text-black mt-2">{!! Str::limit(strip_tags($item->title), '20') !!}</b>
                                        <p class="card-text" style="display:flex; text-align:justify; text-indent:20px">
                                            {!! Str::limit(strip_tags($item->description), '45') !!}</p>
                                    </div>

                                </a>
                            @empty
                                <div class="not-found">
                                    <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                                    <h3>No event data yet!!</h3>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container mt-5">
            @forelse($categories as $item)
                @php
                    $postbycategory = App\Models\Post::where('category_id', $item->id)->get();
                @endphp
                @if (count($postbycategory) == 0)
                @else
                    <div style="width:100%; border-bottom:1px solid black; margin:0; padding-bottom:5px">
                        <span class="block-post-title">{{ $item->name }}</span>
                    </div>
                    <div class="row pt-3 pb-5">
                        @forelse ($postbycategory as $item)
                            <div class="col-md-3">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top" src="{{ asset($item->feature_image) }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->title }}</h5>
                                        <p class="card-text" style="display:flex; text-align:justify; text-indent:10px">
                                            {!! Str::limit(strip_tags($item->description), '100') !!}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a type="button" class="btn btn-outline-primary btn-sm opacity-75"
                                                href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                                style="font-size: 15px"><i
                                                    class="fas fa-eye"></i>&nbsp;&nbsp;@lang('messages.button')</a>
                                            <button type="button" class="btn btn-outline-primary btn-sm opacity-75"
                                                data-toggle="modal" data-target="#exampleModalCenter">
                                                <i class="fas fa-share-alt"></i>&nbsp;&nbsp;Share
                                            </button>
                                            <small class="mt-1">{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- share model start here  --}}
                            <div class="modal fade" id="exampleModalCenter" name="bb" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Share to social media.</h5>
                                        </div>
                                        <div class="modal-body">
                                            <a class="copy_text" data-dismiss="modal" aria-hidden="true"
                                                href="{{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"><i
                                                    class="fas fa-copy"></i>&nbsp;&nbsp;Copy link</a>
                                            <a href="https://wa.me/?text={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"
                                                class="whatsapp"><i class="fab fa-whatsapp-square"
                                                    style="color: rgb(0, 177, 0)"
                                                    target="_blank"></i>&nbsp;&nbsp;Whatsapp</a>
                                            <a href="fb-messenger://share/?link={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"
                                                class="messenger"><i class="fab fa-facebook-messenger"
                                                    style="color: rgb(165, 0, 165)"></i>&nbsp;&nbsp;Messenger</a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"
                                                onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=436,width=626');return false;"
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
                        @empty
                            <h4>No post available!</h4>
                        @endforelse
                    </div>
                @endif

            @empty
            @endforelse
        </div>
    </main>
@endsection
