@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                @if (Auth::user()->can('bannerSlide.force.delete'))
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All trashed banner sliders</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            @php($i = 1)

                                            <tr>
                                                <th>No</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Image Slides</th>
                                                <th>Active</th>
                                                <th>Created At</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($trashed as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>{!! Str::limit(strip_tags($item->description), '15') !!}</td>
                                                    <td><img src="{{ asset($item->image) }}" style="width:120px;">
                                                    </td>

                                                    <td>
                                                        @if (Auth::user()->can('bannerSlide.onOff'))
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                id="flexSwitchCheckDefault"
                                                                {{ $item->status == '0' ? '' : 'checked' }}>
                                                            <label class="form-check-label"
                                                                for="flexSwitchCheckDefault">Published</label>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td class="text-center">
                                                        @if (Auth::user()->can('bannerSlide.restore.delete'))
                                                            <a href="{{ route('banner.restore', $item->id) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-edit"></i>&nbsp;&nbsp;restore
                                                            </a>
                                                        @endif
                                                        @if (Auth::user()->can('bannerSlide.force.delete'))
                                                            <a href="{{ route('banner.force.delete', $item->id) }}"
                                                                class="btn btn-danger btn-sm" id="delete">
                                                                <i class="fas fa-trash"></i>&nbsp;&nbsp;
                                                                force-delete
                                                            </a>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" style="text-align: center; "><small>No data
                                                            avilable!</small></td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#feature-img').change(function(e) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });
        </script>
    @endsection
