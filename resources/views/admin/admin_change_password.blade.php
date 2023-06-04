@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">@lang('backend.change_password_page')</h4><br><br>

                            <form method="POST" action="{{ route('update.password') }}">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">@lang('backend.old_password')
                                        :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="oldpassword" type="password" id="oldpassword"
                                            value="">
                                        @error('oldpassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">@lang('backend.new_password')
                                        :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="newpassword" type="password" id="newpassword"
                                            value="" placeholder="password example: Tq#12345">
                                        @error('newpassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">@lang('backend.confirm_password')
                                        :</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="confirm_password" type="password"
                                            id="confirm_password" value="">
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
