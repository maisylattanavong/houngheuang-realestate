@extends('frontend.main_master')
<section class="top_page_space">
</section>

@section('main')

    @if ($search_post == null)
        <section>
            <div class="container single-product-container">
                <div class="row">
                    <div class="card p-0">
                        <div class="card-header text-center">
                            <h4> {{ $data->title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p>
                                    {!! $data->description !!}
                                </p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                <div class="container gallery-container">
                                    <div class="gallery">
                                        @forelse ($images as $item)
                                            <a href="{{ asset($item->name) }}" data-lightbox="models" data-title="">
                                                <img src="{{ asset($item->name) }}" alt="" />
                                            </a>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center">
                            <b>Published &nbsp; (<span
                                    style="font-size: 15px; padding:0 5px">{{ $data->created_at->diffForHumans() }}</span>)
                            </b> | <span><i class="fa fa-eye"></i> {{ $data->views +500 }} </span>
                            <div class="mt-2 text-center d-flex justify-content-center">
                                @forelse ($data->tags as $tag)
                                    <form class="form-inline my-2 my-lg-0"
                                        action="{{ route('single.post', ['locale' => app()->getLocale(), 'post_id' => $data->slug]) }}"
                                        method="GET">

                                        <input type="hidden" name="search" value="{{ $tag->name }}">
                                        <button type="submit" class="showing-tags-content" style="border:none">
                                            #&nbsp;{{ $tag->name }}
                                        </button>
                                    </form>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-3 mt-5">
            <div class="container mt-5">
                @if ($postData->count() > 0)
                    <h4 class="mb-4">@lang('messages.relative_post')</h4>
                @endif
                <div class="row">
                    @forelse ($postData as $item)
                        <div class="col-sm-3">
                            <div class="card-columns">
                                <div class="card">
                                    <img class="card-img-top" src="{{ asset($item->feature_image) }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->title }}</h5>
                                        <p class="card-text">{!! Str::limit(strip_tags($item->description), '100') !!}</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between text-center">
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
                    @empty
                    @endforelse
                    <div class="row d-flex justify-content-center">
                        {{ $postData->links() }}
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="container mt-5 pt-5">
            <div class="row pt-3 pb-5">
                @php
                    $datas = App\Models\PostTag::where('tag_id', $tag_id)->get();
                @endphp
                @foreach ($datas as $data)
                    @php
                        $items = App\Models\Post::where('id', $data->post_id)->get();
                    @endphp
                    @forelse($items as $item)
                        <div class="col-md-3">
                            <div class="card mb-4 box-shadow">
                                <img class="card-img-top" src="{{ asset($item->feature_image) }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text">{!! Str::limit(strip_tags($item->description), '100') !!}</p>
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
                    @empty
                        <div class="not-found">
                            <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                            <h3>No data yet!!</h3>
                        </div>
                    @endforelse
                @endforeach
            </div>
        </div>
    @endif

@endsection
