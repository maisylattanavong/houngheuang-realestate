 @extends('admin.admin_master')

 @section('admin')
     <div class="page-content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <div class="card-body">
                             {{-- @if (session('status'))
                                 <div class="alert alert-success">
                                     {{ session('status') }}
                                 </div>
                             @endif --}}
                             <div class="row mb-5">
                                 <h4 class="mt-2 mb-3">@lang('backend.guide')</h4>
                                 <form method="POST" action="{{ route('guide.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <div class="row mt-2">

                                                <div class="col-md-12 mb-4">
                                                   <label for="example-text-input" class="form-label">@lang('backend.en_content')
                                                       &nbsp;
                                                       <span class="fi fi-us"></span>&nbsp;(EN)</label>
                                                   <div class="col-md-12 col-sm-12">
                                                       <textarea id="elm1" name="en_content" placeholder="@lang('backend.en_content_placeholder')">{{ $en_content->content }}</textarea>
                                                       @error('en_content')
                                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                           </div>
                                                       @enderror
                                                   </div>
                                                   <input type="hidden" name="en_id" value="{{ $en_content->id }}"/>
                                                   <input type="hidden" name="guide_id" value="{{ $en_content->guide_id }}"/>
                                               </div>
                                               <div class="col-md-12 mb-4">
                                                   <label for="example-text-input" class="form-label">@lang('backend.la_content')
                                                       &nbsp; <span class="fi fi-la"></span>&nbsp;(LA)</label>
                                                   <div class="col-md-12 col-sm-12">
                                                       <textarea id="elm2" name="la_content" placeholder="@lang('backend.la_content_placeholder')">{{ $la_content->content }}</textarea>
                                                       @error('la_content')
                                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                           </div>
                                                       @enderror
                                                   </div>
                                                   <input type="hidden" name="la_id" value="{{ $la_content->id }}"/>
                                               </div>
                                               <div class="col-md-12">
                                                   <label for="example-text-input" class="form-label">@lang('backend.cn_content')
                                                       &nbsp; <span class="fi fi-cn"></span>&nbsp;(CN)</label>
                                                   <div class="col-md-12 col-sm-12">
                                                       <textarea id="elm3" name="cn_content" placeholder="@lang('backend.cn_content_placeholder')">{{ $cn_content->content }}</textarea>
                                                       @error('cn_content')
                                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                           </div>
                                                       @enderror
                                                   </div>
                                                   <input type="hidden" name="cn_id" value="{{ $cn_content->id }}"/>
                                               </div>

                                            </div>
                                            @if (Auth::user()->can('guide.edit'))
                                                <div>
                                                    <button type="submit" class="btn btn-success my-lg-5"
                                                        style="width: 25%">&nbsp;<i
                                                            class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;@lang('backend.save_button')</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
