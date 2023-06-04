@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">@lang('backend.create_user')</h4>
                            <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.name')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.email')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="email" type="email" id="example-text-input"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.password')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="password" type="password" id="example-text-input"
                                            placeholder="password example: Tq#12345" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.confirm_password')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="confirm_password" type="password"
                                            id="example-text-input" value="{{ old('confirm_password') }}">
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.assign_role')</label>
                                    <div class="col-sm-10">

                                        <select name="roles" class="form-select mb-3" aria-label="Default select example"
                                            value="{{ old('roles') }}">
                                            <option value="">@lang('backend.select_role_name')</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('roles')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.image')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="image" name="profile_image" type="file"
                                            id="example-text-input">
                                        @error('profile_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label" style="color: blue">file
                                        size: (2MB)</label>
                                    <div class="col-sm-10">
                                        <img id="showImage" style="width: 100px;height:100%" class="rounded avatar-lg"
                                            src="{{ url('upload/no_image.jpg') }}" alt="Card image cap">
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-success waves-effect waves-light" style="width: 100px"
                                    value="@lang('backend.save_button')">

                                <!-- end row -->
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>

@endsection
