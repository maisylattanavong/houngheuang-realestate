@extends('frontend.main_master')

@section('frontend')
    <!-- banner -->
    <div class="inside-banner">
        <div class="container">
            <span class="pull-right"><a href="{{ route('index') }}">@lang('frontend.home')</a> / @lang('frontend.contact_us')</span>
            <h2>@lang('frontend.contact_us')</h2>
        </div>
    </div>
    <!-- banner -->

    <div class="container">
        <div class="spacer">
            <div class="row contact">
                <div class="col-lg-6 col-sm-6 ">
                    <input type="text" class="form-control" placeholder="@lang('frontend.full_name')">
                    <input type="text" class="form-control" placeholder="@lang('frontend.enter_email')">
                    <input type="text" class="form-control" placeholder="@lang('frontend.your_number')">
                    <textarea rows="6" class="form-control" placeholder="@lang('frontend.message')"></textarea>
                    <button type="submit" class="btn btn-success" name="Submit">@lang('frontend.send_message')</button>
                </div>
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
            </div>
        </div>
    </div>
@endsection
