@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div style=" display:flex; align-items:center;justify-content:space-between;padding:30px 50px 0 0">
                            <h6 style="text-align: start; margin-left:2%" class="mt-3">@lang('backend.total_post')</h6>
                            @if ($trashed < 1)
                                <p></p>
                            @else
                                <a type="button" href="{{ route('post.transhed') }}" class="icon-button"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Trashed">
                                    <span class="material-icons">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                    <span class="icon-button__badge">{{ $trashed }}</span>
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>@lang('backend.number')</th>
                                        <th>@lang('backend.post_title')</th>
                                        <th>@lang('backend.description')</th>
                                        <th>@lang('backend.slug')</th>
                                        <th>@lang('backend.category')</th>
                                        <th>@lang('backend.image')</th>
                                        <th>@lang('backend.translated')</th>
                                        <th>@lang('backend.created_at')</th>
                                        <th>@lang('backend.views')</th>
                                        <th class="text-center">@lang('backend.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($posts as $item)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ Str::limit($item->title, '10') }}</td>
                                            <td>{!! Str::limit(strip_tags($item->description), '15') !!}</td>
                                            <td>{{ Str::limit(URL::to('/') . '/item/' . $item->slug, '10') }}</td>
                                            <td>{{ Str::limit($item['category']['name'], '15') }}</td>
                                            <td class="text-center"><img src="{{ asset($item->feature_image) }}"
                                                    style="width: 60px;height:50px;">
                                            <td class="text-center"><i class="fas fa-check-circle"
                                                    style="color: {{ $item->status == 'false' ? 'gray' : 'green' }}"></i>
                                            </td>
                                            <td>{{ Str::limit($item->created_at, '10') }}</td>
                                            <td>{{$item->views}}
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->can('post.edit'))
                                                    <a href="{{ route('edit.post', $item->id) }}"
                                                        class="btn btn-info btn-sm" title="Edit Data">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('post.soft.delete'))
                                                    <a href="{{ route('delete.post', $item->id) }}" id="delete"
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
