@extends('admin.admin_master')

@section('admin')
    @php
        $id = Auth::user()->id;
        $userId = App\Models\User::find($id);
        $role = $userId->role;
        $users = Auth::user();
    @endphp
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-3">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">@lang('backend.all_users')</h4>
                            <div class="btn-group">
                                @if (Auth::user()->can('user.add'))
                                    <a href="{{ route('add.admin') }}"
                                        class="btn btn-success rounded">@lang('backend.add_user')</a>&nbsp;&nbsp;
                                @endif
                                @if ($trashed < 1)
                                    <p></p>
                                @else
                                    <a type="button" href="{{ route('admin.trashed') }}" class="icon-button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Trashed">
                                        <span class="material-icons">
                                            <i class="fa-solid fa-trash"></i>
                                        </span>
                                        <span class="icon-button__badge">{{ $trashed }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%; text-align: center;">
                                <thead class=" table-primary">
                                    <tr>
                                        <th>@lang('backend.number')</th>
                                        <th>@lang('backend.full_name')</th>
                                        <th>@lang('backend.email')</th>
                                        <th>@lang('backend.image')</th>
                                        <th>@lang('backend.role')</th>
                                        @if (Auth::user()->can('user.active'))
                                            <th>@lang('backend.status')</th>
                                        @endif
                                        <th>@lang('backend.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php($i = 1)

                                    @foreach ($alladminuser as $item)
                                        <tr style="vertical-align: baseline;">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td><img src="{{ !empty($item->profile_image && Storage::url('media/' . $item->profile_image))
                                                ? Storage::url('media/' . $item->profile_image)
                                                : (Storage::url('media/' . $item->profile_image)
                                                    ? url('upload/no_image.jpg')
                                                    : url('upload/image_deleted.jpg')) }}"
                                                    style="width: 90px; height: 100%">
                                            </td>

                                            <td>
                                                @foreach ($item->roles as $role)
                                                    <span class="badge badge-pill bg-info">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            @if (Auth::user()->can('user.active'))
                                                <td class=" justify-center">

                                                    @if ($item->status == 1 && $item->id != 1)
                                                        <a href="{{ route('active.admin.status', $item->id) }}"
                                                            class="active1 btn" title="Press To OFF"></a>
                                                    @endif
                                                    @if ($item->status == 0 && $item->id != 1)
                                                        <a href="{{ route('active.admin.status', $item->id) }}"
                                                            class="inactive2 btn" title="Press To ON"></a>
                                                    @endif
                                                </td>
                                            @endif

                                            <td>
                                                @if (Auth::user()->can('user.edit'))
                                                    <a href="{{ route('edit.admin.role', $item->id) }}"
                                                        class="btn btn-info btn-sm" title="Edit Data">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('user.soft.delete'))
                                                    <a href="{{ route('delete.admin.role', $item->id) }}" id="delete"
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
