@extends('frontend.main_master')
@section('frontend')
    <!-- banner -->
    {{-- <div class="inside-banner">
        <div class="container">
            <span class="pull-right"><a href="{{ route('index') }}">@lang('frontend.home')</a> / @lang('frontend.buy_properties')</span>
            <h2>@lang('frontend.buy_properties')</h2>
        </div>
    </div> --}}
    <!-- banner -->
    <livewire:buy-search />
@endsection
