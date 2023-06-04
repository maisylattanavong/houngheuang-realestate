@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        @if ($isUpdate == null)
                            <h4 class="my-3">@lang('backend.create_new_banner_slide')</h4>
                        @else
                            <h4 class="my-3">@lang('backend.edit_banner_slide')</h4>
                        @endif
                        <form method="POST" class="g-3"
                            action="{{ route($isUpdate == null ? 'banner.store' : 'banner.update') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $isUpdate == null ? '' : $banner->id }}">
                            <input type="hidden" name="en_id" value="{{ $isUpdate == null ? '' : $en_banner->id }}">
                            <input type="hidden" name="la_id" value="{{ $isUpdate == null ? '' : $la_banner->id }}">
                            <div class="modal-body">
                                <div class="col-md-12  mb-3">
                                    <div class="feature-image">
                                        <div class="row p-2 align-items-center">
                                            <div class="col-md-4 mx-auto">
                                                <div class="col-sm-10 img">
                                                    <label for="feature-img">
                                                        <i class="fas fa-upload"></i>
                                                        <p>@lang('backend.choose_image')</p><span>file size: (2MB)</span>
                                                    </label>
                                                    <input type="file" id="feature-img" name="image"
                                                        style="display: none; visibility:none" onchange="loadFile(event)">
                                                </div>
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-8 mx-auto">
                                                <div class="row">
                                                    <img id="showImage"
                                                        src="{{ $isUpdate == null ? '' : url($banner->image) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="entitle"
                                            class="form-label">@lang('backend.slide_title')&nbsp;&nbsp;(EN)&nbsp;&nbsp;<span
                                                class="fi fi-us"></span></label>
                                        <input type="text" class="form-control" name="en_title"
                                            value="{{ $isUpdate == null ? old('en_title') : $en_banner->title }}">
                                        @error('en_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="title"
                                            class="form-label">@lang('backend.description')&nbsp;&nbsp;(EN)&nbsp;&nbsp;<span
                                                class="fi fi-us"></span></label>
                                        <textarea id="elm1" name="en_description"> {{ $isUpdate == null ? old('en_description') : $en_banner->description }}</textarea>
                                        @error('en_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-5 d-flex align-items-center">
                                    <i class="fa-solid fa-down-long" style="color:blue"></i>&nbsp;&nbsp;
                                    <span>Translation
                                    </span>
                                    &nbsp;&nbsp;<i class="fa-solid fa-language" style="color: green"></i>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <label for="latitle"
                                            class="form-label">@lang('backend.slide_title')&nbsp;&nbsp;(LA)&nbsp;&nbsp;<span
                                                class="fi fi-la"></span></label>
                                        <input type="text" class="form-control" name="la_title"
                                            value="{{ $isUpdate == null ? old('la_title') : $la_banner->title }}">
                                        @error('la_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="title"
                                            class="form-label">@lang('backend.description')&nbsp;&nbsp;(LA)&nbsp;&nbsp;<span
                                                class="fi fi-la"></span></label>
                                        <textarea id="elm2" name="la_description">{{ $isUpdate == null ? old('la_description') : $la_banner->description }}</textarea>
                                        @error('la_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <label for="url" class="form-label">@lang('backend.slider_link')</label>
                                        <input type="text" class="form-control" name="link"
                                            value="{{ $isUpdate == null ? old('link') : $banner->link }}">
                                        @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label class="form-label"></label>
                                        <div class="form-check form-switch">
                                            @if ($isUpdate == null)
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault" name="publish">
                                            @else
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault" name="publish"
                                                    {{ $banner->status == 0 ? '' : 'checked' }}>
                                            @endif
                                            <label class="form-check-label"
                                                for="flexSwitchCheckDefault">@lang('backend.public_post')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @if ($isUpdate == null)
                                    <button type="submit" name="action" value="create"
                                        class="btn btn-success">@lang('backend.create_button')</button>
                                    <button type="submit" name="action" value="create-other"
                                        class="btn btn-info">@lang('backend.create_create_other_button')</button>
                                @else
                                    <button type="submit" class="btn btn-info">@lang('backend.update_button')</button>
                                @endif
                                <a type="button" href="{{ route('banner.index') }}"
                                    class="btn btn-secondary">@lang('backend.cancel_button')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#feature-img').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
