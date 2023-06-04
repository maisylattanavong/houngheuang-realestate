@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div style=" display:flex; align-items:center;justify-content:space-between">
                                <h6 style="text-align: start; margin-left:2%" class="mt-3">@lang('backend.all_trased_post')</h6>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>@lang('backend.number')</th>
                                        <th>@lang('backend.post_title')</th>
                                        <th>@lang('backend.description')</th>
                                        <th>@lang('backend.slug')</th>
                                        <th>@lang('backend.image')</th>
                                        <th>@lang('backend.translated')</th>
                                        <th>@lang('backend.created_at')</th>
                                        <th class="text-center">@lang('backend.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($trashed as $item)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ Str::limit($item->title, '10') }}</td>
                                            <td>{!! Str::limit(strip_tags($item->description), '15') !!}</td>
                                            <td>{{ Str::limit(URL::to('/') . '/item/' . $item->slug, '10') }}</td>
                                            <td class="text-center"><img src="{{ asset($item->feature_image) }}"
                                                    style="width: 60px;height:50px;">
                                            <td class="text-center"><i class="fas fa-check-circle"
                                                    style="color: {{ $item->status == 'false' ? 'gray' : 'green' }}"></i>
                                            </td>
                                            <td>{{ Str::limit($item->created_at, '10') }}</td>
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->can('post.restore.delete'))
                                                <a href="{{ route('post.restore.trashed', $item->id) }}"
                                                    class="btn btn-info btn-sm" title="Edit Data">
                                                    <i class="fa-solid fa-reply"></i>&nbsp;&nbsp;@lang('backend.restore_button')
                                                </a>
                                                @endif

                                                @if (Auth::user()->can('post.force.delete'))
                                                <a href="{{ route('post.force.delete.trashed', $item->id) }}" id="delete"
                                                    class="btn btn-danger btn-sm" title="Delete Data">
                                                    <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;@lang('backend.force_delete_button')
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
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
