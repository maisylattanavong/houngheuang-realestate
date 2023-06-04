@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('store.social') }}" enctype="multipart/form-data">
                                @csrf
                                @if (Auth::user()->can('socialMedia.insert'))
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="text" class="form-label">@lang('backend.social_name')</label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="name">
                                                    <option selected value="Phone">Phone</option>
                                                    <option value="Whatsapp">Whatsapp</option>
                                                    <option value="Facebook">Facbook</option>
                                                    <option value="Line">Line</option>
                                                </select>
                                                @error('name')
                                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="text" class="form-label">@lang('backend.url')</label>
                                                <input type="text" name="url" class="form-control"
                                                    placeholder="Enter social detail" value="{{ old('url') }}">
                                                @error('url')
                                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-md-flex row justify-between">
                                        <div class="col-9">
                                            <div class="mb-3">
                                                <label for="">@lang('backend.icon')</label>
                                                <div class="d-flex" role="search">
                                                    <div class="col-9">
                                                        <input class="form-control me-2" name="icon" type="text"
                                                            placeholder='<i class="fas fa-search"></i>'
                                                            value="{{ old('icon') }}">
                                                    </div>&nbsp;&nbsp;
                                                    <a href="https://fontawesome.com/v5/search" target="_blank"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Free icon" class="form-control"
                                                        placeholder="search icon">
                                                        <i class="fas fa-search"></i> Search icon</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3 mr-1">
                                            <div class="mb-3">
                                                <label for="text">@lang('backend.color')</label>
                                                <div class="d-flex">
                                                    <input type="color" name="color" id=""
                                                        class="form-control-color" value="{{ old('color') }}">
                                                    @error('color')
                                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success"><i
                                            class="fas fa-save"></i>&nbsp;&nbsp;@lang('backend.save_button')</button>
                                @endif

                                <div class="card mt-5">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">@lang('backend.social_name')</th>
                                                    <th scope="col">@lang('backend.icon')</th>
                                                    <th scope="col" class="text-center">@lang('backend.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($social as $value)
                                                    <tr>
                                                        <th scope="row">{{ $value->name }}</th>
                                                        <td style="font-size:25px">
                                                            <a href="{{ $value->url }}">
                                                                <i class="{{ $value->icon }}"
                                                                    style="color:{!! $value->color !!}"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            @if (Auth::user()->can('socialMedia.edit'))
                                                                <a href="{{ route('edit.social', $value->id) }}"
                                                                    class="btn btn-info btn-sm"><i
                                                                        class="fa fa-edit"></i></a>
                                                            @endif

                                                            @if (Auth::user()->can('socialMedia.delete'))
                                                                <a href="{{ route('delete.social', $value->id) }}"
                                                                    id="delete" class="btn btn-danger btn-sm"><i
                                                                        class="fa fa-trash"></i></a>
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
        </div>
    </div>
@endsection
