@extends('frontend.main_master')
@php
    $firstPost = App\Models\Post::latest()
        ->take(1)
        ->get();
@endphp
@section('main')
    <section class="jumbotron mt-5 pt-5 mb-5">
        <div class="container text-end">
            <form class="form-inline my-2 my-lg-0" action="{{ route('all.post.page') }}" method="GET"
                enctype="multipart/form-data">

                @csrf
                <div class="row">
                    <div class="col-md-6 d-flex text-align-center justify-content-center" style="width:100%">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search"
                            aria-label="Search">&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    {{-- search resualt  --}}
    <div class="container mt-5">
        <div class="row pt-1 pb-5">
            <div class="card border-0">
                {{-- search result --}}
                <div class="card border-0 bg-info text-white mb-3 px-2" style="width: 150px">search result</div>
              </div>
            @forelse($search_post as $item)
                <div class="col-md-3">
                    <div class="card mb-4 box-shadow">
                        <a class="opacity-75"
                            href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}">
                            <img class="card-img-top" src="{{ asset($item->feature_image) }}" alt="Card image cap">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{!! Str::limit(strip_tags($item->description), '100') !!}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a type="button" class="btn btn-outline-primary btn-sm opacity-75"
                                    href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                    style="font-size: 15px"><i class="fas fa-eye"></i>&nbsp;&nbsp;@lang('messages.button')</a>
                                <button type="button" class="btn btn-outline-primary btn-sm opacity-75" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    <i class="fas fa-share-alt"></i>&nbsp;&nbsp;Share
                                </button>
                                <small class="mt-1">{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    class="whatsapp"><i class="fab fa-whatsapp-square" style="color: rgb(0, 177, 0)"
                                        target="_blank"></i>&nbsp;&nbsp;Whatsapp</a>
                                <a href="fb-messenger://share/?link={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"
                                    class="messenger"><i class="fab fa-facebook-messenger"
                                        style="color: rgb(165, 0, 165)"></i>&nbsp;&nbsp;Messenger</a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $SITE_DOMAIN }}/{{ app()->getLocale() }}/{{ $item->slug }}"
                                    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=436,width=626');return false;"
                                    target="_blank" title="Share on Facebook" title="Share on Facebook" class="facebook"><i
                                        class="fab fa-facebook-square"
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
                <div class="not-found">
                    <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                    <h3>Search not found!</h3>
                </div>
            @endforelse
        </div>
    </div>
    {{-- end search resualt  --}}
@endsection
