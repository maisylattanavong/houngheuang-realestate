@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">@lang('backend.edit_role')</h4>
                            <form id="myForm" method="POST" action="{{ route('update.roles') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $roles->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.role_name')</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="name" type="text" id="example-text-input"
                                            value="{{ $roles->name }}">
                                        @error('name')
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
