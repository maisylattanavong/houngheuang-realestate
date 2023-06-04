@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div style=" display:flex; align-items:center;justify-content:space-between">
                                <h6 style="text-align: start; margin-left:2%" class="mt-3">@lang('backend.all_trashed_categories')</h6>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap mt-3"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>@lang('backend.number')</th>
                                        <th>@lang('backend.category_name')</th>
                                        <th>@lang('backend.slug')</th>
                                        <th class="text-center">@lang('backend.image')</th>
                                        <th class="text-center">@lang('backend.translated')</th>
                                        <th class="text-center">@lang('backend.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @forelse ($trashed as $item)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ Str::limit($item->name, '20') }}</td>
                                            <td>{{ Str::limit(URL::to('/') . '/item/' . $item->slug, '35') }}
                                            </td>
                                            <td class="text-center"><img src="{{ asset($item->image) }}"
                                                    style="width: 60px;height:50px;">
                                            </td>
                                            <td class="text-center"><i class="fas fa-check-circle"
                                                    style="color: {{ $item->status == 'false' ? 'gray' : 'green' }}"></i>
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->can('category.restore.delete'))
                                                <a href="{{ route('cates.restore.trashed', $item->id) }}"
                                                    class="btn btn-info sm" title="Edit Data">
                                                    <i class="fa-solid fa-reply"></i>&nbsp;&nbsp;@lang('backend.restore_button')
                                                </a>
                                                <a href="{{ route('cates.force.delete.trashed', $item->id) }}"
                                                    id="delete" class="btn btn-danger sm" title="Delete Data">
                                                    <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;@lang('backend.force_delete_button')
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <p>No Category data fetch from database!!</p>
                                    @endforelse
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
            $('#feature-img').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#update-img').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showUpdateImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
