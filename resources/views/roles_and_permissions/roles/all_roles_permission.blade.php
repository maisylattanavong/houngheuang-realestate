@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@lang('backend.all_roles_permission')</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive" {{-- <table id="datatable" class="table table-centered mb-0 align-middle table-hover table-bordered" --}}
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="table-primary">
                                        <tr class=" justify-center">
                                            <th>@lang('backend.number')</th>
                                            <th>@lang('backend.role_name')</th>
                                            <th>@lang('backend.permission')</th>
                                            <th>@lang('backend.action')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($roles as $key => $item)
                                            <tr style="vertical-align: baseline;">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @foreach ($item->permissions as $perm)
                                                        <span
                                                            class="badge rounded-pill bg-danger">{{ $perm->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if (Auth::user()->can('role.permission.edit'))
                                                        <a href="{{ route('admin.edit.roles', $item->id) }}"
                                                            class="btn btn-info" title="Edit Data">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if (Auth::user()->can('role.permission.delete'))
                                                        <a href="{{ route('admin.delete.roles', $item->id) }}"
                                                            id="delete" class="btn btn-danger sm mt-1"
                                                            title="Delete Data">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div> <!-- container-fluid -->
    </div>
@endsection
