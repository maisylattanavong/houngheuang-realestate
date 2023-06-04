@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route($aboutpage == null ? 'store.about' : 'update.about') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id"
                                    value="{{ $aboutpage == null ? '' : $en_aboutpage->about_id }}">
                                <input type="hidden" name="en_id"
                                    value="{{ $aboutpage == null ? '' : $en_aboutpage->id }}">
                                <input type="hidden" name="la_id"
                                    value="{{ $aboutpage == null ? '' : $la_aboutpage->id }}">

                                <div class="row mb-3">
                                    <label class="col-sm-12">@lang('backend.en_about_title')&nbsp;<span
                                            class="fi fi-us"></span>&nbsp;(EN)</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="en_title" type="text" id="example-text-input"
                                            value="{{ $aboutpage == null ? old('en_title') : $en_aboutpage->title }}">
                                        <span class="text-danger">
                                            @error('en_title')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-12 col-form-label">@lang('backend.en_about_long_description')&nbsp;<span
                                            class="fi fi-us"></span>&nbsp;(EN)</label>
                                    <div class="col-sm-12">
                                        <textarea id="elm1" name="en_long_description">
                                            {{ $aboutpage == null ? old('en_long_description') : $en_aboutpage->long_description }}
                                        </textarea>
                                        <span class="text-danger">
                                            @error('en_long_description')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-12">@lang('backend.la_about_title')&nbsp;<span
                                            class="fi fi-la"></span>&nbsp;(EN)</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="la_title" type="text" id="example-text-input"
                                            value="{{ $aboutpage == null ? old('la_title') : $la_aboutpage->title }}">
                                        <span class="text-danger">
                                            @error('la_title')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-12 col-form-label">@lang('backend.la_about_long_description')&nbsp;<span
                                            class="fi fi-la"></span>&nbsp;(EN)s</label>
                                    <div class="col-sm-12">
                                        <textarea id="elm2" name="la_long_description">
                                            {{ $aboutpage == null ? old('la_long_description') : $la_aboutpage->long_description }}
                                        </textarea>
                                        <span class="text-danger">
                                            @error('la_long_description')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <div class="fea-img-upload"
                                        style="border: 1px solid #ced4da; padding:5% 0; border-radius:6px; margin-left:1%">
                                        <label for="image">
                                            <div class="col-sm-12 img" style="width:100%">
                                                <i class="fas fa-upload"></i>
                                                <p>@lang('backend.choose_image')</p></span>&nbsp;&nbsp;<span
                                                    style="color: blue">(max-size:
                                                    2MB)</span>
                                            </div>
                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="file" id="image" name="about_image"
                                            value="{{ old('about_image') }}" style="display: none; visibility:none">
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <img id="showImage" class="rounded avatar-lg"
                                                    src="{{ !empty($aboutpage->about_image) ? url($aboutpage->about_image) : url('upload/no_image.jpg') }}"
                                                    alt="Card image cap">
                                            </div>
                                        </div>
                                        <span class="text-danger">
                                            @error('about_image')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <span class="text-danger">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                @if (Auth::user()->can('aboutPage.update'))
                                <div class="mt-3">
                                    @if ($aboutpage == null)
                                        <input type="submit" class="btn btn-success" style="width: 150px"
                                            value="@lang('backend.save_button')">
                                    @else
                                        <input type="submit" class="btn btn-info" style="width: 150px"
                                            value="@lang('backend.update_button')">
                                    @endif
                                </div>
                                @endif
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
