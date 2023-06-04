@extends('frontend.main_master')

@section('frontend')

    <div class="container">
        <div class="spacer">
            <div class="row">
                <div class="col-lg-8  col-lg-offset-2">
                    {{-- @forelse ($company_images as $item)
                        <img src="{{ asset($item->image) }}" class="img-responsive thumbnail" alt="realestate">
                    @empty
                        <div class=" justify-items-center">
                            <p>@lang('frontend.not_found')</p>
                        </div>
                    @endforelse
                    @if (!is_null($aboutCompany))
                        {!! $aboutCompany->about !!}
                    @endif

                    @if (!is_null($aboutCompany))
                        <p><b>{{ $aboutCompany->name }}</b><br>
                            <span class="glyphicon glyphicon-map-marker"></span> {{ $aboutCompany->address }}<br>
                            <span class="glyphicon glyphicon-envelope"></span> {{ $aboutCompany->email }}<br>
                            <span class="glyphicon glyphicon-earphone"></span> {{ $aboutCompany->mobile }}
                        </p>
                    @else
                        <p>@lang('frontend.not_found')</p>
                    @endif --}}
                    @if (!is_null($content))
                    {!! $content->content !!}
                    @else
                        not found
                    @endif


                </div>
                {{-- <div class="col-lg-8  col-lg-offset-2">
                    <div class="well">
                        @php
                            $aboutCompany = App\Models\Company::first();
                        @endphp
                        @if (!is_null($aboutCompany))
                            <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0" src="{{ $aboutCompany->map }}"></iframe>
                        @else
                            @lang('frontend.not_found')
                        @endif
                    </div>


                </div> --}}
            </div>



        </div>
    </div>

    {{-- <div class="container">
        <div class="spacer">
            <div class="row contact">
                <div class="col-lg-6 col-sm-6 ">
                    @forelse ($company_images as $item)
                        <img src="{{ asset($item->image) }}" class="img-responsive thumbnail" alt="realestate">
                    @empty
                        <div class=" justify-items-center">
                            <p>@lang('frontend.not_found')</p>
                        </div>
                    @endforelse

                </div>

                <div class="col-lg-6 col-sm-6 ">
                    @if (!is_null($aboutCompany))
                        {!! $aboutCompany->about !!}
                    @endif
                </div>
            </div>
            <div class="row contact">
                <div class="col-lg-6 col-sm-6 ">
                    <div class="well">
                        @php
                            $aboutCompany = App\Models\Company::first();
                        @endphp
                        @if (!is_null($aboutCompany))
                            <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0" src="{{ $aboutCompany->map }}"></iframe>
                        @else
                            @lang('frontend.not_found')
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 ">
                    @if (!is_null($aboutCompany))
                        {!! $aboutCompany->about !!}
                    @endif
                </div>


            </div>
        </div>
    </div> --}}
@endsection
