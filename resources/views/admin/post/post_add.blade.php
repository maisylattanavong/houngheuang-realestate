@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @if (Auth::user()->can('post.add'))
        <div class="page-content">
            <div class="container post-container">
                <form method="post" action="{{ route('store.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 left-container">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h3 class="card-title">@lang('backend.add_new_post')</h3>
                                            <input type="hidden" name="id" value="">
                                            <div class="row mb-3" style="display: flex; flex-direction:column">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">@lang('backend.post_title')
                                                    &nbsp; <span class="fi fi-us"></span>&nbsp; (EN)</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="en_title" type="text"
                                                        value="{{ old('en_title') }}" id="example-text-input"
                                                        placeholder=" @lang('backend.en_post_title_placeholder') ">
                                                    <span class="text-danger">
                                                        @error('title')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-3" style="display: flex; flex-direction:column">
                                                <label for="example-text-input" class="col-sm-6 col-form-label">
                                                    @lang('backend.description') &nbsp; <span class="fi fi-us"></span>&nbsp;
                                                    (EN)</label>
                                                <div class="col-sm-12">
                                                    <textarea id="elm1" name="en_description" placeholder="@lang('backend.en_post_desc_placeholder')" style="border: 1px solid red">{{ old('en_description') }}</textarea>
                                                </div>
                                                <span class="text-danger">
                                                    @error('description')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="row mb-3" style="display: flex; flex-direction:column">
                                                <label for="example-text-input"
                                                    class="col-sm-12 col-form-label">@lang('backend.la_post_title') &nbsp;
                                                    <span class="fi fi-la"></span>&nbsp; (LA)</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="la_title" type="text"
                                                        value="{{ old('la_title') }}" id="example-text-input"
                                                        placeholder="@lang('backend.la_post_title_placeholder')">
                                                    <span class="text-danger">
                                                        @error('title')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-3" style="display: flex; flex-direction:column">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">
                                                    @lang('backend.la_post_desc') &nbsp;
                                                    <span class="fi fi-la"></span>&nbsp; (LA)</label>
                                                <div class="col-sm-12">
                                                    <textarea id="elm2" name="la_description" placeholder="@lang('backend.la_post_desc_placeholder')">{{ old('la_description') }}</textarea>
                                                </div>
                                                <span class="text-danger">
                                                    @error('description')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mb-3 mul_img_upload">
                                                <div style="width: 20%">
                                                    <label for="post_images" class="col-sm-2 col-form-label upload_label">
                                                        <i class="fas fa-upload"></i>
                                                        <p>@lang('backend.add_multiple_images')</p></span>&nbsp;&nbsp;<span>(max-size:
                                                            2MB)</span>
                                                    </label>
                                                    <input class="form-control" multiple name="post_images[]" type="file"
                                                        id="post_images" style="display: none; visibility:none">
                                                </div>
                                                <div class="preview_images">
                                                    <div class="images-preview-div"></div>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                @error('post_images')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 right-container" style="border-radius:6px;">
                            <div class="container">
                                <div class="card-body">
                                    <div class="feature-image">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.select_category')</span>&nbsp;&nbsp;
                                                    <a href="{{ route('category') }}" type="button"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fas fa-plus"></i>&nbsp;@lang('backend.create_button')</a>
                                                </div>
                                                <div class="mt-3"
                                                    style="display: flex; align-items:center; justify-content:space-between">
                                                    <select class="custom-select" name="category"
                                                        value="{{ old('category') }}"
                                                        style="width:100%; padding:10px; border-radius:5px">
                                                        <option value=""></option>
                                                        @foreach ($categories as $item)
                                                            <option value="{{ $item->category_id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    @error('category')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.public_post')</span>
                                                </div>
                                                <div class="mt-3 publish-status">
                                                    <span>Publish</span>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status"
                                                            value="{{ old('status') }}" role="switch"
                                                            id="flexSwitchCheckChecked" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-6">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.select_tags')</span>&nbsp;&nbsp;<a
                                                        href="{{ route('tag') }}" type="button"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fas fa-plus"></i>&nbsp;@lang('backend.create_button')</a>
                                                </div>
                                                <select class="select mt-3 tag-selector" name="tags[]" multiple
                                                    style="width:100%">
                                                    @foreach ($tags as $item)
                                                        <option value="{{ $item->id }}" {{-- style="font-family:Noto Sans Lao" class="data-toggle="tooltip" --}}
                                                            style="font-family:Noto Sans Lao" data-toggle="tooltip"
                                                            data-placement="top" title="Multiple select: Ctrl + click">
                                                            #{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.image')</span>&nbsp;&nbsp;</span>&nbsp;&nbsp;<span>(max-size:
                                                        2MB)</span>
                                                </div>
                                                <div class="fea-img-upload">
                                                    <label for="feature-img">
                                                        <div class="col-sm-10 img">
                                                            <i class="fas fa-upload"></i>
                                                            <p>@lang('backend.choose_image')</p>
                                                        </div>
                                                    </label>
                                                    <input type="file" id="feature-img" name="image"
                                                        style="display: none; visibility:none">
                                                    <div class="row mb-3"
                                                        style="display: flex; align-items:center; justify-content:start">
                                                        <div class="col-sm-10">
                                                            <img id="showImage" class="rounded avatar-lg"
                                                                src="{{ !empty($homeslide->home_slide) ? url($homeslide->home_slide) : url('upload/no_image.jpg') }}"
                                                                alt="Card image cap">
                                                        </div>
                                                    </div>
                                                    <span class="text-danger">
                                                        @error('image')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6 offset-md-3 form-group">
                                            <h6 class="pt-2">Tags:</h6>
                                            <select class="tags form-control" id="tags" name="tags[]"></select>
                                            @error('tags')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div> --}}
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-5 w-5"><i
                                            class="fas fa-save"></i>&nbsp;&nbsp;@lang('backend.save_button')</button>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif


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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(function() {
            var previewImages = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#post_images').on('change', function() {
                previewImages(this, 'div.images-preview-div');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var max_fields = 10;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");

            var x = 1;

            $(add_button).click(function(e) {
                e.preventDefault();
                if (x < max_fields) {
                    $(wrapper).append(
                        '<div style="width:98%;margin-top:10px; display:flex; align-items:center; justify-content:space-between"> <input class="form-control" name="mytext[]" type="text" style="width:75%"><a type="button" href="#" class="btn btn-danger remove_field" style="margin-right:6%"><i class="fas fa-minus"></i></a></div>'
                    );
                    x++;
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })
        })
    </script>

    {{-- Select 2 script  --}}
    <script>
        $(document).ready(function() {
            $('.tags').select2({
                placeholder: "select",
                allowClear: true,
            });

            $("#tags").select2({
                ajax: {
                    url: "{{ route('get-tags') }}",
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            name: params.term,
                            "_token": "{{ csrf_token() }}",
                        };
                    },

                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.post_id,
                                    text: item.name
                                }
                            })
                        };
                    },
                },
            });
        });
    </script>

@endsection
