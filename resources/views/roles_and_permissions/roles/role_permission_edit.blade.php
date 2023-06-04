@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style type="text/css">
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">@lang('backend.assign_role_permission')</h4>
                            <form id="myForm" method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                                @csrf

                                <div class="row mb-3 mt-3">
                                    <label for="example-text-input"
                                        class="col-sm-2 col-form-label">@lang('backend.role_name')</label>
                                    <div class="form-group col-sm-10">
                                        {{-- <input type="text" name="name" value="{{$role->name}}"> --}}
                                        <span class="badge rounded-pill bg-warning justify-content-center"
                                            style="width: 100px;height:25px">
                                            <h6 style="color: white">{{ $role->name }}</h6>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="flexCheckDefaultAll">
                                    <label class="form-check-label" for="flexCheckDefaultAll">Permission All</label>
                                </div>

                                <hr>

                                @foreach ($permission_groups as $group)
                                    <div class="row">
                                        <div class="col-3">
                                            @php
                                                $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
                                            @endphp
                                            <div class="form-check">
                                                {{-- <input type="checkbox" class="form-check-input" id="flexCheckDefault"
                                    {{App\Models\User::roleHasPermissions($role, $permissions) ? 'checked': ''}}> --}}

                                                <label class="form-check-label" for="flexCheckDefault">
                                                    <h6 style="color: black">{{ $group->group_name }}</h6>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="col-9 mb-5">

                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permission[]"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                        class="form-check-input" id="flexCheckDefault{{ $permission->id }}"
                                                        value="{{ $permission->id }}">
                                                    <label class="form-check-label"
                                                        for="flexCheckDefault{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!--end row-->
                                @endforeach

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
    <script type="text/javascript">
        $('#flexCheckDefaultAll').click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });
    </script>
@endsection
