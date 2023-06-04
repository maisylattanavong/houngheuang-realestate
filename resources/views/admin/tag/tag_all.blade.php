@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="card">
                    @if ($update == null)
                        <h6 style="text-align: start; margin-left:2%" class="mt-3">
                            @lang('backend.create_translate_tag_form')</h6>
                    @else
                        <h6 style="text-align: start; margin-left:2%" class="mt-3">
                            @lang('backend.update_tag_form')</h6>
                    @endif
                    <div class="card-body">
                        @if (Auth::user()->can('tag.insert'))
                            <div class="col-lg-12">
                                <form method="post" action="{{ route($update == null ? 'store.tag' : 'update.tag') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    @if ($update == null)
                                        <div class="row post-attribute mb-5">
                                            <div class="col-sm-12">
                                                <div class="post-attribute-header">
                                                    <span> @lang('backend.en_tag_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-us"></span>
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12" style="padding: 0 20px">
                                                        <input type="hidden" name="en_locale" value="en">
                                                        <input class="form-control" name="en_tag" type="text"
                                                            id="example-text-input" value="{{ old('en_tag') }}"
                                                            placeholder=" @lang('backend.en_tag_placeholder')">
                                                        <span class="text-danger">
                                                            @error('en_tag')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="post-attribute-header">
                                                    <span></span>
                                                    <span> @lang('backend.la_tag_title') </span>&nbsp;&nbsp;<span
                                                        class="fi fi-la"></span>
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12" style="padding: 0 20px">
                                                        <input type="hidden" name="la_locale" value="la">
                                                        <input class="form-control" name="la_tag" type="text"
                                                            id="example-text-input" value="{{ old('la_tag') }}"
                                                            placeholder=" @lang('backend.la_tag_placeholder')">
                                                        <span class="text-danger">
                                                            @error('la_tag')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="post-attribute-header">
                                                    <span></span>
                                                    <span> @lang('backend.cn_tag_title') </span>&nbsp;&nbsp;<span
                                                        class="fi fi-cn"></span>
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12" style="padding: 0 20px">
                                                        <input type="hidden" name="cn_locale" value="cn">
                                                        <input class="form-control" name="cn_tag" type="text"
                                                            id="example-text-input" value="{{ old('cn_tag') }}"
                                                            placeholder=" @lang('backend.cn_tag_placeholder')">
                                                        <span class="text-danger">
                                                            @error('cn_tag')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row mb-3 mt-3">
                                                <button type="submit" class="btn btn-success"
                                                    style="width: 150px; margin-left:2%"><i
                                                        class="fas fa-save"></i>&nbsp;&nbsp;@lang('backend.save_button')</button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row post-attribute mb-5">
                                            <div class="col-sm-12">
                                                <div class="post-attribute-header">
                                                    <span> @lang('backend.update_en_tag_title')</span>
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12" style="padding: 0 20px">
                                                        <input type="hidden" name="id" value="{{ $en_tags->tag_id }}">
                                                        <input type="hidden" name="en_id" value="{{ $en_tags->id }}">
                                                        <input type="hidden" name="en_locale"
                                                            value="{{ $en_tags->locale }}">

                                                        <input class="form-control" name="en_tag" type="text"
                                                            id="example-text-input" value="{{ $en_tags->name }}"
                                                            placeholder="@lang('backend.en_tag_placeholder')">
                                                        <span class="text-danger">
                                                            @error('en_tag')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="post-attribute-header">
                                                    <span></span>
                                                    <span>@lang('backend.la_tag_title')</span>
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12" style="padding: 0 20px">
                                                        <input type="hidden" name="la_id" value="{{ $la_tags->id }}">
                                                        <input type="hidden" name="la_locale"
                                                            value="{{ $la_tags->locale }}">
                                                        <input class="form-control" name="la_tag" type="text"
                                                            id="example-text-input" value="{{ $la_tags->name }}"
                                                            placeholder="@lang('backend.la_tag_placeholder')">
                                                        <span class="text-danger">
                                                            @error('la_tag')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="post-attribute-header">
                                                    <span></span>
                                                    <span>@lang('backend.cn_tag_title')</span>
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12" style="padding: 0 20px">
                                                        <input type="hidden" name="cn_id" value="{{ $cn_tags->id }}">
                                                        <input type="hidden" name="cn_locale"
                                                            value="{{ $cn_tags->locale }}">
                                                        <input class="form-control" name="cn_tag" type="text"
                                                            id="example-text-input" value="{{ $cn_tags->name }}"
                                                            placeholder="@lang('backend.cn_tag_placeholder')">
                                                        <span class="text-danger">
                                                            @error('cn_tag')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a type="button" href="{{ route('tag') }}" class="btn btn-secondary"
                                                style="width: 46%; margin-left:2%"><i
                                                    class="fas fa-xmark"></i>&nbsp;&nbsp;@lang('backend.cancel_button')</a>
                                            <button type="submit" class="btn btn-info"
                                                style="width: 46%; margin-left:4%"><i
                                                    class="fas fa-save"></i>&nbsp;&nbsp;@lang('backend.update_button')</button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div style=" display:flex; align-items:center;justify-content:space-between">
                                <h6 style="text-align: start; margin-left:2%" class="mt-3"></h6>
                                @if ($trashed < 1)
                                    <p></p>
                                @else
                                    <a type="button" href="{{ route('index.trashed') }}" class="icon-button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Trashed">
                                        <span class="material-icons">
                                            <i class="fa-solid fa-trash"></i>
                                        </span>
                                        <span class="icon-button__badge">{{ $trashed }}</span>
                                    </a>
                                @endif
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
                                    @foreach ($tags as $item)
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
                                                @if (Auth::user()->can('tag.edit'))
                                                    <a href="{{ route('edit.tag', $item->id) }}"
                                                        class="btn btn-info btn-sm" title="Edit Data">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('tag.soft.delete'))
                                                    <a href="{{ route('delete.tag', $item->id) }}" id="delete"
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
@endsection
