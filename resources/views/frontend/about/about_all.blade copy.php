 @extends('frontend.main_master')
 @section('main')
     <section class="top_page_space">
     </section>
     <main>
         <div class="about-page">
             @if ($aboutpage == null || $aboutpage == '')
                 <div class="not-found">
                     <img src="{{ asset('frontend/assets/img/not-found.png') }}" alt="">
                     <h3>No about data yet!! <a href="{{ route('status.login', 2) }}" type="button"
                             class="btn btn-light">Create
                             new</a>
                     </h3>
                 </div>
             @else
                 <div class="container">
                     <p>{!! $aboutpage->about !!}</p>
                 </div>
             @endif
         </div>
     </main>
 @endsection
