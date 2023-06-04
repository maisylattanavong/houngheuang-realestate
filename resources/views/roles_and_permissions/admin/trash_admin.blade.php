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
                            <h4 class="mb-sm-0">All Users In Trashed</h4>
                            <a href="{{ route('all.admin') }}" class="btn btn-secondary rounded"><i
                                    class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Go back</a>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%; text-align: center;">
                                <thead class=" table-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>User Image</th>
                                        <th>Role</th>
                                        @if (Auth::user()->can('user.active'))
                                            <th>Status</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php($i = 1)
                                    @foreach ($trashed as $item)
                                        <tr style="vertical-align: baseline;">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td><img src="{{ !empty($item->profile_image && file_exists('storage/media/' . $item->profile_image))
                                                ? url('storage/media/' . $item->profile_image)
                                                : (!empty(file_exists('storage/media/' . $item->profile_image))
                                                    ? url('upload/no_image.jpg')
                                                    : url('upload/image_deleted.jpg')) }}"
                                                    style="width: 90px; height: 100%"></td>

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
                                                    <a href="{{ route('admin.restored.trashed', $item->id) }}"
                                                        class="btn btn-info sm" data-toggle="tooltip" data-placement="top"
                                                        title="Restore">
                                                        <i class="fa-solid fa-reply"></i>
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('user.force.delete'))
                                                    <a href="{{ route('admin.force.delete.trashed', $item->id) }}"
                                                        id="delete" class="btn btn-danger sm" data-toggle="tooltip"
                                                        data-placement="top" title="Force delete">
                                                        <i class="fa-solid fa-trash"></i>
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
