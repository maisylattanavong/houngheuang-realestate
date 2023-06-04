<div class="footer" style="color: white">

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-4">
                <h4>@lang('frontend.copyright')</h4>
                <ul class="row">
                    <li class="col-lg-12 col-sm-12 col-xs-3">Copyright 2023. All rights reserved. </li>
                    {{-- <li class="col-lg-12 col-sm-12 col-xs-3"><a class="information" href="{{ route('home.contact') }}">@lang('frontend.contact')</a>
                    </li> --}}
                </ul>
            </div>

            {{-- <div class="col-lg-3 col-sm-3">
                <h4>@lang('frontend.newsletter')</h4>
                <p>@lang('frontend.get_notified')</p>
                <form class="form-inline" role="form">
                    <input type="email" name="email" placeholder="@lang('frontend.enter_email')" class="form-control">
                    <button class="btn btn-primary" type="button">@lang('frontend.notify_me')!</button>
                </form>
            </div> --}}

            <div class="col-lg-4 col-sm-4">
                <h4>@lang('frontend.follow_us')</h4>
                @php
                    $socialMedia = App\Models\Socialmedia::latest()->take(4)->get();
                @endphp
                {{-- <a href="#"><img src="{{ asset('frontend/assets/images/facebook.png') }}" alt="facebook"></a>
                <a href="#"><img src="{{ asset('frontend/assets/images/twitter.png') }}" alt="twitter"></a>
                <a href="#"><img src="{{ asset('frontend/assets/images/linkedin.png') }}" alt="linkedin"></a>
                <a href="#"><img src="{{ asset('frontend/assets/images/instagram.png') }}" alt="instagram"></a> --}}
                @forelse ($socialMedia as $item)
                    <a href="{{ $item->url }}" target="_blank" class="btn btn-lg">
                        <span>
                            <i class="{{ $item->icon }}" style="color: {!! $item->color !!}; font-size:30px"></i>
                        </span>
                    </a>
                @empty
                    <div style="width:100%">
                        @lang('frontend.not_found')
                    </div>
                @endforelse
            </div>

            <div class="col-lg-4 col-sm-4">
                <h4>@lang('frontend.information')</h4>
                @if (!is_null($aboutCompany))
                    <p><b>{{ $aboutCompany->name }}</b><br>
                        <span class="glyphicon glyphicon-map-marker"></span> {{ $aboutCompany->address }}<br>
                        <span class="glyphicon glyphicon-envelope"></span> {{ $aboutCompany->email }}<br>
                        <span class="glyphicon glyphicon-earphone"></span> {{ $aboutCompany->mobile }}
                    </p>
                @else
                    <p>@lang('frontend.not_found')</p>
                @endif

            </div>

        </div>
        {{-- <p class="copyright">Copyright 2023. All rights reserved. </p> --}}
    </div>
</div>
