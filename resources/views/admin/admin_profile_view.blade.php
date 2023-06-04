@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card"><br><br>
                        <div class="card-body">
                            {{-- <center> --}}
                            <img {{-- class="rounded-circle avatar-xl" --}} class="rounded-circle"
                                src="{{ !empty($adminData->profile_image) && file_exists('storage/media/' . $adminData->profile_image)
                                    ? url('storage/media/' . $adminData->profile_image)
                                    : (!empty(file_exists('storage/media/' . $adminData->profile_image))
                                        ? url('upload/no_image.jpg')
                                        : url('upload/image_deleted.jpg')) }}"
                                {{-- alt="Card image cap" --}} alt="Header Avatar" style="height: 120px">
                            {{-- </center> --}}
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">@lang('backend.name') : {{ $adminData->name }}</h4>
                            <hr>
                            <h4 class="card-title">@lang('backend.user_email') : {{ $adminData->email }}</h4>
                            <hr>
                            <a href="{{ route('edit.profile') }}" class="btn btn-info btn-rounded waved-effect waves-light"
                                style="height: 36px">
                                @lang('backend.edit_profile') </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
