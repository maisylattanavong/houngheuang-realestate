@extends('frontend.main_master')
@section('main')
    <section>
        <div class="container single-product-container">
            <div class="row">
                @if ($postData == null || $postData == '' || count($postData) == '0')
                    <div class="not-found">
                        <div class="not-found">
                            <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                            <h3>No posts in this category yet!!</h3>
                        </div>
                    </div>
                @else
                    <h3 class="text-center">@lang('messages.all_include_post') {{ $categoryName }}.</h3>
                    @foreach ($postData as $item)
                        <div class="row mt-5 mb-3 category-post">
                            <div class="col-md-6 cat-post-left-cont">
                                <img src="{{ asset($item->feature_image) }}" alt="" class="rounded">
                            </div>
                            <div class="col-md-6 cat-post-right-cont">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text" style="display:flex; text-align:justify; text-indent:10px">
                                        {!! Str::limit(strip_tags($item->description), '300') !!}
                                    </p>
                                    <p class="card-text">
                                    </p>
                                    <div class="card-footers">
                                        <div class="view-more">
                                            <a type="button"
                                                href="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $item->slug]) }}"
                                                class="btn btn-outline-primary btn-sm opacity-75"><i
                                                    class="fas fa-eye"></i>&nbsp;
                                                @lang('messages.button')
                                            </a>
                                            <button type="button" class="btn btn-outline-primary btn-sm opacity-75"
                                                data-toggle="modal" data-target="#exampleModalCenter">
                                                <i class="fas fa-share-alt"></i>&nbsp;&nbsp;Share
                                            </button>
                                        </div>
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
                @endif
            </div>
        </div>
    </section>
@endsection
