@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">@lang('backend.edit_user')</h4>
                            <form method="POST" action="{{ route('admin.user.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="old_image" value="{{ $user->profile_image }}">
                                <input type="hidden" name="old_password" value="{{ $user->password }}">
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.name')</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ $user->name }}">
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
                                            value="{{ $user->email }}">
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
                                            placeholder="password example: Tq#12345">
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
                                            id="example-text-input">
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.asign_role')</label>
                                    <div class="col-sm-10">

                                        <select name="roles" class="form-select mb-3" aria-label="Default select example">
                                            <option value="">Open this select menu</option>
                                            @foreach ($roles as $role)
                                                <option
                                                    value="{{ $role->id }}"{{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
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
                                        size:
                                        (2MB)</label>
                                    <div class="col-sm-10">
                                        <img id="showImage" style="width: 100px;height:100%" class="rounded avatar-lg"
                                            src="{{ !empty($user->profile_image && file_exists('storage/media/' . $user->profile_image))
                                                ? url('storage/media/' . $user->profile_image)
                                                : url('upload/no_image.jpg') }}"
                                            alt="Card image cap">
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
