@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">@lang('backend.edit_profile')</h4>
                            <form method="POST" action="{{ route('store.profile') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="old_image" value="{{ $editData->profile_image }}">
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.name')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ $editData->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.user_email')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="email" type="email" id="example-text-input"
                                            value="{{ $editData->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">@lang('backend.image')
                                        (2MB)</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="image" name="profile_image" type="file"
                                            id="example-text-input">
                                        @error('profile_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img id="showImage" style="width: 90px; height:100%" class="rounded avatar-lg"
                                            src="{{ !empty($editData->profile_image) && file_exists('storage/media/' . $editData->profile_image)
                                                ? url('storage/media/' . $editData->profile_image)
                                                : (!empty(file_exists('storage/media/' . $editData->profile_image))
                                                    ? url('upload/no_image.jpg')
                                                    : url('upload/image_deleted.jpg')) }}"
                                            alt="Card image cap" style="width:10%">
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="@lang('backend.update_button')">


                                <!-- end row -->
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
@endsection
