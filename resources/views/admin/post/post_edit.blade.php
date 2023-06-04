@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @if (Auth::user()->can('post.edit'))
        <div class="page-content">
            <div class="container post-container">
                <form method="post" action="{{ route('update.post') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="postId" value="{{ $post->id }}">
                    <div class="row">
                        <div class="col-lg-12 left-container">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body">
                                            <h3 class="card-title">@lang('backend.edit_post')</h3>
                                            <input type="hidden" name="id" value="">
                                            <div class="row mb-3" style="display: flex; flex-direction:column">
                                                <label for="example-text-input"
                                                    class="col-sm-2 col-form-label">@lang('backend.post_title')
                                                    &nbsp; <span class="fi fi-us"></span>&nbsp; (EN)</label>
                                                <div class="col-sm-12">
                                                    <input type="hidden" name="en_id" value="{{ $en_post->id }}">
                                                    <input class="form-control" name="en_title" type="text"
                                                        id="example-text-input" value="{{ $en_post->title }}">
                                                    <span class="text-danger">
                                                        @error('en_title')
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
                                                    <textarea id="elm1" name="en_description">
                                                    {{ $en_post->description }}
                                                </textarea>
                                                </div>
                                                <span class="text-danger">
                                                    @error('en_description')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="row mb-3" style="display: flex; flex-direction:column">
                                                <label for="example-text-input"
                                                    class="col-sm-12 col-form-label">@lang('backend.la_post_title') &nbsp;
                                                    <span class="fi fi-la"></span>&nbsp; (LA)</label>
                                                <div class="col-sm-12">
                                                    <input type="hidden" name="la_id" value="{{ $la_post->id }}">
                                                    <input class="form-control" name="la_title" type="text"
                                                        id="example-text-input" placeholder="Translate post title to Lao..."
                                                        value="{{ $la_post->title }}">
                                                    <span class="text-danger">
                                                        @error('la_title')
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
                                                    <textarea id="elm2" name="la_description" placeholder="Translate post description to Lao...">
                                                    {{ $la_post->description }}
                                                </textarea>
                                                </div>
                                                <span class="text-danger">
                                                    @error('la_description')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="mb-3 mul_img_upload">
                                                <div style="width: 20%">
                                                    <label for="post_images" class="col-sm-2 col-form-label upload_label">
                                                        <i class="fas fa-upload"></i>
                                                        <p>@lang('backend.add_multiple_images')</p>
                                                    </label>
                                                    <input class="form-control" multiple name="post_images[]" type="file"
                                                        id="post_images" style="display: none; visibility:none">
                                                </div>
                                                <div class="preview_images">
                                                    <div class="images-preview-div">
                                                        @foreach ($post_images as $mul_image)
                                                            <a href="{{ route('delete.single.image', $mul_image->id) }}"
                                                                class="delete_image" id="delete"><i class="fas fa-trash"
                                                                    style="color: rgb(255, 0, 0)"></i></a>
                                                            <img src="{{ asset($mul_image->name) }}" alt="">
                                                        @endforeach
                                                    </div>
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
                                            <div class="col-8">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.select_category')</span>&nbsp;&nbsp;<a
                                                        href="{{ route('category') }}" type="button"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fas fa-plus"></i>&nbsp;@lang('backend.create_button')</a>
                                                </div>
                                                <div
                                                    style="display: flex; align-items:center; justify-content:space-between">
                                                    <select class="mt-3 custom-select" name="category" value=""
                                                        style="width:90%; padding:10px; border-radius:5px">
                                                        <option value="{{ $category->category_id }}"
                                                            style="background: gray">
                                                            {{ $category->name }}
                                                        </option>
                                                        @foreach ($categories as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
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
                                            <div class="col-4">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.public_post')</span>
                                                </div>
                                                <div class="mt-3 publish-status">
                                                    <span>Publish</span>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status"
                                                            role="switch" id="flexSwitchCheckChecked"
                                                            {{ $post->publish == '0' ? '' : 'checked' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-8">
                                                <div class="post-attribute">
                                                    <div class="post-select">
                                                        <div class="mt-3"
                                                            style="display: flex; justify-content:space-between">
                                                            <div style="width:40%">
                                                                <label class="ms-2">@lang('backend.select_tags')</label>
                                                                <div class="showing-tags">
                                                                    @foreach ($post->tags as $tag)
                                                                        <p class="showing-tags-content">
                                                                            <span
                                                                                style="margin-right: 10px">{{ $tag->name }}</span>
                                                                            <a
                                                                                href="{{ route('delete.post.tag', ['post_id' => $post->id, 'tag_id' => $tag->id]) }}"><i
                                                                                    class="fas fa-times"></i></a>
                                                                        </p>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div style="width: 50%">
                                                                <label
                                                                    for="">@lang('backend.select_more_tags')</label>&nbsp;&nbsp;<a
                                                                    href="{{ route('tag') }}" type="button"
                                                                    class="btn btn-success btn-sm"><i
                                                                        class="fas fa-plus"></i>&nbsp;@lang('backend.create_button')</a>
                                                                <select class="tag-selector" name="tags[]" multiple
                                                                    style="width:100%">
                                                                    @foreach ($tags as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            style="font-family:Noto Sans Lao">
                                                                            #{{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.image')</span>
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
                                                                src="{{ asset($post->feature_image) }}"
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
                                    </div>
                                    <button type="submit" class="mt-5 btn btn-info"><i
                                            class="fas fa-save"></i>&nbsp;&nbsp;@lang('backend.update_button')</button>
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
@endsection
