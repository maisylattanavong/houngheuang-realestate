@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div style=" display:flex; align-items:center;justify-content:space-between; mb-3">
                                <h6 style="text-align: start;" class="mt-3">@lang('backend.all_trashed_tags')</h6>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap mt-4"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>@lang('backend.number')</th>
                                        <th>@lang('backend.tag_name')</th>
                                        <th>@lang('backend.slug')</th>
                                        <th>@lang('backend.created_at')</th>
                                        <th class="text-center">@lang('backend.translated')</th>
                                        <th class="text-center">@lang('backend.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach ($trashed as $item)
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>
                                                @if ($item->name == null)
                                                    @if (App::getLocale() == 'la')
                                                        No trans (LA)&nbsp;&nbsp;<i class="fa-solid fa-square-pen"
                                                            style="color: red; cursor: pointer; font-size:18px"></i>
                                                    @elseif(App::getLocale() == 'en')
                                                        No trans (EN)&nbsp;&nbsp;<i class="fa-solid fa-square-pen"
                                                            style="color: red; cursor: pointer; font-size:18px"></i>
                                                    @endif
                                                @else
                                                    {{ Str::limit($item->name, '20') }}
                                                @endif
                                            </td>
                                            <td>{{ Str::limit(URL::to('/') . '/item/' . $item->slug, '35') }}</td>
                                            <td>{{ Str::limit($item->created_at, '10') }}</td>
                                            <td class="text-center"><i class="fas fa-check-circle"
                                                    style="color: {{ $item->status == 'false' ? 'gray' : 'green' }}"></i>
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->can('tag.restore.delete'))
                                                    <a href="{{ route('restore.trashed', $item->id) }}"
                                                        class="btn btn-info sm" title="Edit Data">
                                                        <i class="fa-solid fa-reply"></i>&nbsp;&nbsp;@lang('backend.restore_button')
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('tag.force.delete'))
                                                    <a href="{{ route('force.delete.trashed', $item->id) }}" id="delete"
                                                        class="btn btn-danger sm" title="Delete Data">
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
@endsection
