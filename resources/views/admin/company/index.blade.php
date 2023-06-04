 @extends('admin.admin_master')

 @section('admin')
     <div class="page-content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <div class="card-body">
                             @if (session('status'))
                                 <div class="alert alert-success">
                                     {{ session('status') }}
                                 </div>
                             @endif
                             <div class="row mb-5">
                                 <h4 class="mt-2">@lang('backend.site_information')</h4>
                                 <form method="POST" action="{{ route('update.company') }}" enctype="multipart/form-data">
                                     @csrf
                                     @method('put')
                                     <div class="row">
                                         <div class="col-12 mt-3">
                                             <label for="example-text-input" class="form-label">@lang('backend.site_logo')</label>
                                             <div class="feature-image">
                                                 <div class="site-info-img">
                                                     <label for="feature-img">
                                                         <div class="col-sm-12 img">
                                                             <i class="fas fa-upload"></i>
                                                             <p>@lang('backend.choose_logo')</p><span>(@lang('backend.max_size'):2MB)</span>
                                                         </div>
                                                     </label>
                                                     <input type="file" id="feature-img" name="logo"
                                                         style="display: none; visibility:none" onchange="loadFile(event)">
                                                     <div class="row mb-3 site-show-img">
                                                         <img id="socialOutPut" class="rounded avatar-lg"
                                                             src="{{ $companies->logo ? url($companies->logo) : url('upload/no_image.jpg') }}"
                                                             alt="Card image cap" style="width: 100%">
                                                     </div>
                                                     @error('logo')
                                                         <div class="alert alert-danger mt-1 mb-1">
                                                             {{ $message }}</div>
                                                     @enderror
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-12 mt-4">
                                             <label for="example-text-input" class="form-label">@lang('backend.company_images')</label>

                                             <div class="mb-3 mul_img_upload">
                                                 <div style="width: 20%">
                                                     <label for="images" class="col-sm-2 col-form-label upload_label">
                                                         <i class="fas fa-upload"></i>
                                                         <p>@lang('backend.add_multiple_images')</p></span>&nbsp;&nbsp;<span>(
                                                             @lang('backend.max_size'):
                                                             2MB)</span>
                                                     </label>
                                                     <input class="form-control" multiple name="company_images[]"
                                                         type="file" id="images"
                                                         style="display: none; visibility:none">
                                                 </div>
                                                 <div class="preview_images">
                                                     <div class="images-preview-div">
                                                         @foreach ($company_images as $mul_image)
                                                             <a href="{{ route('delete.company.single.image', $mul_image->id) }}"
                                                                 class="delete_image" id="delete"><i class="fas fa-trash"
                                                                     style="color: rgb(255, 0, 0)"></i></a>
                                                             <img src="{{ asset($mul_image->image) }}" alt="">
                                                         @endforeach
                                                     </div>
                                                 </div>
                                             </div>
                                             @error('company_images')
                                                 <div class="alert alert-danger mt-1 mb-1">
                                                     {{ $message }}</div>
                                             @enderror

                                         </div>
                                         <div class="col-md-12 mt-3">
                                             <div class="row">
                                                 <div class="col-md-4">
                                                     <div class="mb-3">

                                                         <input type="hidden" name="id" value="{{ $companies->id }}">
                                                         <input type="hidden" name="en_id" value="{{ $en_company->id }}">
                                                         <input type="hidden" name="la_id" value="{{ $la_company->id }}">
                                                         <input type="hidden" name="cn_id"
                                                             value="{{ $cn_company->id }}">
                                                         <input type="hidden" name="status"
                                                             value="{{ $companies->status }}">

                                                         <label for="text" class="form-label">@lang('backend.company_name')&nbsp;
                                                             <span class="fi fi-us"></span> (EN)</label>
                                                         <input type="text" name="en_name" class="form-control"
                                                             placeholder="@lang('backend.en_company_name_placeholder')"
                                                             value="{{ $en_company->name }}">
                                                         @error('name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">@lang('backend.company_name')&nbsp;
                                                             <span class="fi fi-la"></span> (LA)</label>
                                                         <input type="text" name="la_name" class="form-control"
                                                             placeholder="@lang('backend.la_company_name_placeholder')"
                                                             value="{{ $la_company->name }}">
                                                         @error('name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">@lang('backend.company_name')&nbsp;
                                                             <span class="fi fi-cn"></span> (CN)</label>
                                                         <input type="text" name="cn_name" class="form-control"
                                                             placeholder="@lang('backend.cn_company_name_placeholder')"
                                                             value="{{ $cn_company->name }}">
                                                         @error('cn_name')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">@lang('backend.address')&nbsp;
                                                             <span class="fi fi-us"></span> (EN)</label>
                                                         <input type="text" name="en_address" class="form-control"
                                                             placeholder="@lang('backend.en_address_placeholder')"
                                                             value="{{ $en_company->address }}">
                                                         @error('en_address')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">@lang('backend.address')&nbsp;
                                                             <span class="fi fi-la"></span> (LA)</label>
                                                         <input type="text" name="la_address" class="form-control"
                                                             placeholder="@lang('backend.la_address_placeholder')"
                                                             value="{{ $la_company->address }}">
                                                         @error('la_address')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">@lang('backend.address')&nbsp;
                                                             <span class="fi fi-cn"></span> (CN)</label>
                                                         <input type="text" name="cn_address" class="form-control"
                                                             placeholder="@lang('backend.cn_address_placeholder')"
                                                             value="{{ $cn_company->address }}">
                                                         @error('cn_address')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <div class="mb-3">
                                                         <label for="text" class="form-label">Map</label>
                                                         <input type="text" name="map" class="form-control"
                                                             placeholder="Enter company map information"
                                                             value="{{ $companies->map }}">

                                                         @error('map')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text"
                                                             class="form-label">@lang('backend.email')</label>
                                                         <input type="email" name="email" class="form-control"
                                                             placeholder="@lang('backend.email_placeholder')"
                                                             value="{{ $companies->email }}">

                                                         @error('email')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="text"
                                                             class="form-label">@lang('backend.website')</label>
                                                         <input type="text" name="website" class="form-control"
                                                             placeholder="@lang('backend.website_placeholder')"
                                                             value="{{ $companies->website }}">

                                                         @error('website')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text"
                                                             class="form-label">@lang('backend.mobile')</label>
                                                         <input type="number" name="mobile" class="form-control"
                                                             placeholder="@lang('backend.mobile_placeholder')"
                                                             value="{{ $companies->mobile }}">

                                                         @error('mobile')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text"
                                                             class="form-label">@lang('backend.telephone')</label>
                                                         <input type="number" name="telephone" class="form-control"
                                                             placeholder="@lang('backend.telephone_placeholder')"
                                                             value="{{ $companies->telephone }}">

                                                         @error('telephone')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                         <label for="text"
                                                             class="form-label">@lang('backend.fax')</label>
                                                         <input type="number" name="fax" class="form-control"
                                                             placeholder="@lang('backend.fax_placeholder')"
                                                             value="{{ $companies->fax }}">

                                                         @error('fax')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>

                                             </div>

                                             <div class="row mt-2">
                                                 <div class="col-md-12">
                                                     <label for="example-text-input" class="form-label">About description
                                                         &nbsp;
                                                         <span class="fi fi-us"></span>&nbsp;(EN)</label>
                                                     <div class="col-md-12 col-sm-12">
                                                         <textarea id="elm1" name="en_about">{!! $en_company->about !!}</textarea>
                                                         @error('en_about')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                     <label for="example-text-input" class="form-label">About description
                                                         &nbsp; <span class="fi fi-la"></span>&nbsp;(LA)</label>
                                                     <div class="col-md-12 col-sm-12">
                                                         <textarea id="elm2" name="la_about">{!! $la_company->about !!}</textarea>
                                                         @error('la_about')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-12">
                                                     <label for="example-text-input" class="form-label">About description
                                                         &nbsp; <span class="fi fi-cn"></span>&nbsp;(CN)</label>
                                                     <div class="col-md-12 col-sm-12">
                                                         <textarea id="elm3" name="cn_about">{!! $cn_company->about !!}</textarea>
                                                         @error('cn_about')
                                                             <div class="alert alert-danger mt-1 mb-1">{{ $message }}
                                                             </div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                             @if (Auth::user()->can('siteInfo.edit'))
                                                 <div>
                                                     <button type="submit" class="btn btn-info my-lg-5"
                                                         style="width: 25%">&nbsp;<i
                                                             class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;@lang('backend.update_button')</button>
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
