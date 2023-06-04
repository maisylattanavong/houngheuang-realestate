@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body mt-3">
                            <form method="POST" action="{{ route('update.social', $social->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                @method('PUT')
                                <div class="mb-3">
                                    <label for="text" class="form-label">@lang('backend.update_social_name')</label>
                                    <input type="text" name="name" class="form-control" value="{{ $social->name }}">
                                    @error('name')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex row justify-between">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <a href="https://fontawesome.com/v5/search" target="_blank"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Change icon">
                                                <i class="fas fa-search"></i> @lang('backend.change_icon')</a>
                                            <span style="color: {{ $social->color }}">{!! $social->icons_image !!}</span>
                                            <input type="text" name="icon" class="form-control mt-2"
                                                placeholder="input icon" value="{{ $social->icon }}">
                                            @error('icon')
                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4 mr-1">
                                        <div class="mb-3">
                                            <label for="text">@lang('backend.color')</label>
                                            <div class="d-flex">
                                                <input type="color" name="color" id=""
                                                    value="{{ $social->color }}" class="form-control-color">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="text" class="form-label">@lang('backend.update_url')</label>
                                    <input type="text" name="url" class="form-control" value="{{ $social->url }}">
                                    @error('url')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <a type="button" href="{{ route('index.social') }}"
                                    class="btn btn-secondary">@lang('backend.back_button')</a>
                                <button type="submit" class="btn btn-info">@lang('backend.update_button')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
