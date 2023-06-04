@extends('frontend.main_master')
@section('main')
    <section class="top_page_space">
    </section>

    <main class="contact-page">
        @if ($contact == null || $contact == '')
            <div class="not-found">
                <div class="not-found">
                    <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                    <h3>No contact data yet!! <a href="{{ route('status.login', 3) }}" type="button"
                            class="btn btn-light">Create new</a></h3>
                </div>
            </div>
        @else
            <div class="contact-header">
                <h2 class="typing" text="Have Any Quetions?, Contact Us Below!!, Thank You Very much!!" char_per_sec="8"
                    cursorColor="red"></h2>
            </div>
            <div id="container" class="mt-3">
                <div class="product-details">
                    <h1>" @lang('messages.slogan') "</h1>
                    <p class="information mt-3">@lang('messages.highlight')</p>
                </div>
                <div class="product-image">
                    <img src="{{ asset('frontend/assets/img/contact.png') }}" alt="">
                    <div class="info">
                        <h4 class="pt-2 pb-2">@lang('messages.information')</h4>
                        <ul>
                            <li>
                                <strong><i class="fas fa-envelope"></i>&nbsp;&nbsp; {{ $contact->email }}</strong><br />
                            </li>
                            <li>
                                <strong><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp; {{ $contact->mobile }}</strong><br />
                            </li>
                            <li>
                                <strong><i class="fas fa-phone"></i>&nbsp;&nbsp; {{ $contact->telephone }}</strong><br />
                            </li>
                            <li>
                                <strong><i class="fas fa-globe"></i>&nbsp;&nbsp; {{ $contact->website }}</strong><br />
                            </li>
                            <li>
                                <strong><i class="fas fa-fax"></i>&nbsp;&nbsp; {{ $contact->fax }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


            {{-- </div> --}}
        @endif
    </main>
@endsection
