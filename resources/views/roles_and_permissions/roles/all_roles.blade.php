@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@lang('backend.all_roles')</h4>
                                @if(Auth::user()->can('role.add'))
                                <div class="btn-group">
                                    <a href="{{ route('add.roles', app()->getLocale()) }}"
                                        class="btn btn-primary">@lang('backend.add_role')</a>
                                </div>
                                @endif
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%; text-align: center;">
                                <thead class="table-primary">
                                    <tr>
                                        <th>@lang('backend.number')</th>
                                        <th>@lang('backend.role_name')</th>
                                        <th>@lang('backend.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($roles as $key => $item)
                                        <tr style="vertical-align: baseline;">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if (Auth::user()->can('role.edit'))
                                                    <a href="{{ route('edit.roles', $item->id) }}"
                                                        class="btn btn-info btn-sm" title="Edit Data">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('role.delete'))
                                                    <a href="{{ route('delete.roles', $item->id) }}" id="delete"
                                                        class="btn btn-danger btn-sm" title="Delete Data">
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
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div> <!-- container-fluid -->
    </div>
@endsection
