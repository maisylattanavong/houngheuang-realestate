@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div style=" display:flex; align-items:center;justify-content:space-between;padding:30px 50px 0 0">

                            <h6 style="text-align: start; margin-left:2%" class="mt-3">@lang('backend.total_realestate')</h6>

                            <a href="{{ route('create.real.estate') }}"
                                class="btn btn-sm btn-success rounded">@lang('backend.add_new')</a>

                            @if ($trashed > 1)
                                <p></p>
                            @else
                                <a type="button" href="{{ route('realestate.transhed') }}" class="icon-button"
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
                                        <th>@lang('backend.title')</th>
                                        <th>@lang('backend.description')</th>
                                        <th>@lang('backend.category')</th>
                                        <th>@lang('backend.image')</th>
                                        <th>@lang('backend.translation')</th>
                                        <th>@lang('backend.created_at')</th>
                                        <th>@lang('backend.views')</th>
                                        <th class="text-center">@lang('backend.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($realestates as $item)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ Str::limit($item->title, '10') }}</td>
                                            <td>{!! Str::limit(strip_tags($item->description), '15') !!}</td>
                                            <td>{{ Str::limit($item['category']['name'], '15') }}</td>
                                            <td class="text-center"><img src="{{ asset($item->feature_image) }}"
                                                    style="width: 60px;height:50px;">
                                            <td class="text-center">
                                                <a href="{{ route('edit.realestate.lao', $item->id) }}"
                                                    class="btn btn-link btn-sm btn-outline-primary" title="Edit Data">
                                                    <i class="fi fi-la"
                                                        style="color: {{ $item->status == 'false' ? 'gray' : 'white' }}"></i>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('edit.realestate.chinese', $item->id) }}"
                                                    class="btn btn-link btn-sm btn-outline-primary" title="Edit Data">
                                                    <i class="fi fi-cn"
                                                        style="color: {{ $item->status == 'false' ? 'gray' : 'white' }}"></i>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                            </td>
                                            <td>{{ Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d M Y') }}
                                            </td>
                                            <td>{{ $item->views }}
                                            </td>
                                            <td class="text-center">
                                                @if ($item->publish == 1)
                                                    <a href="{{ route('active.realestate.publish', $item->id) }}"
                                                        class="active1 btn" title="Press To OFF"></a>
                                                @endif
                                                @if ($item->publish == 0)
                                                    <a href="{{ route('active.realestate.publish', $item->id) }}"
                                                        class="inactive2 btn" title="Press To ON"></a>
                                                @endif

                                                @if (Auth::user()->can('property.soft.delete'))
                                                    <a href="{{ route('delete.realestate', $item->id) }}" id="delete"
                                                        class="btn btn-danger btn-sm" title="Delete Data">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

                            @if (!is_null($realestates))
                                {{ $realestates->links() }}
                            @endif
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
