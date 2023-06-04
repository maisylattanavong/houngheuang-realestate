@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container">

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route($isUpdate == null ? 'store.category' : 'update.category') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($isUpdate == null)
                                @if (Auth::user()->can('category.insert'))
                                    <div class="continer"
                                        style="display: flex; align-items:center;justify-content:space-between">
                                        <div class="row">

                                            <div class="row col-sm-4">
                                                <div class="post-attribute-header">
                                                    <span>@lang('backend.category_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-us"></span>&nbsp;&nbsp;(EN)
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="en_name" type="text"
                                                            id="example-text-input"
                                                            value="{{ $isUpdate == null ? old('en_name') : $categories->name }}"
                                                            placeholder="@lang('backend.en_category_placeholder')">
                                                        <span class="text-danger">
                                                            @error('en_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-4">
                                                <div class="post-attribute-header">
                                                    <span>@lang('backend.la_category_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-la"></span>&nbsp;&nbsp;(LA)
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="la_name" type="text"
                                                            id="example-text-input"
                                                            value="{{ $isUpdate == null ? old('la_name') : $categories->name }}"
                                                            placeholder="@lang('backend.la_category_placeholder')">
                                                        <span class="text-danger">
                                                            @error('la_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row col-sm-4">
                                                <div class="post-attribute-header">
                                                    <span>@lang('backend.cn_category_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-cn"></span>&nbsp;&nbsp;(CN)
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <input class="form-control" name="cn_name" type="text"
                                                            id="example-text-input"
                                                            value="{{ $isUpdate == null ? old('cn_name') : $categories->name }}"
                                                            placeholder="@lang('backend.cn_category_placeholder')">
                                                        <span class="text-danger">
                                                            @error('cn_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-sm-12">
                                        <div class="container"
                                            style="display: flex; align-items:center;justify-content:space-between">
                                            <div class="row col-sm-6">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.image')</span>&nbsp;&nbsp;<span
                                                        style="color: blue">(@lang('backend.max_size'):
                                                        2MB)</span>
                                                </div>
                                                <div class="fea-img-upload"
                                                    style="border: 1px solid #ced4da; padding:5% 0; border-radius:6px; width:93%; margin-left:2%">
                                                    <label for="feature-img">
                                                        <div class="col-sm-10 img">
                                                            <i class="fas fa-upload"></i>
                                                            <p>@lang('backend.choose_image')</p>
                                                        </div>
                                                    </label>
                                                    <input type="file" id="feature-img" name="image"
                                                        style="display: none; visibility:none">
                                                    <div class="row mb-3"
                                                        style="display: flex; align-items:center; justify-content:start">
                                                        <div class="col-sm-10">
                                                            <img id="showImage" class="rounded avatar-lg"
                                                                src="{{ $isUpdate == null ? url('upload/no_image.jpg') : url($categories->image) }}"
                                                                alt="Card image cap">
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="text-danger">
                                                    @error('image')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="row col-sm-6">
                                                <button type="submit" class="btn btn-success"
                                                    style="width: 50%; margin:10% 0 0 25%"><i
                                                        class="fas fa-save"></i>&nbsp;&nbsp;
                                                    @lang('backend.save_button')</button>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                @if (Auth::user()->can('category.edit'))
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="continer"
                                        style="display: flex; align-items:center;justify-content:space-between">
                                        <div class="row">
                                            <div class="row col-sm-4">
                                                <div class="post-attribute-header">
                                                    <span>@lang('backend.category_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-us"></span>&nbsp;&nbsp;(EN)
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name='id'
                                                            value="{{ $en_cates->category_id }}">
                                                        <input type="hidden" name="en_id" value="{{ $en_cates->id }}">
                                                        <input class="form-control" name="en_name" type="text"
                                                            id="example-text-input"
                                                            value="{{ $en_cates->name }}"
                                                            placeholder="@lang('backend.en_category_placeholder')">
                                                        <span class="text-danger">
                                                            @error('en_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-sm-4">
                                                <div class="post-attribute-header">
                                                    <span>@lang('backend.la_category_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-la"></span>&nbsp;&nbsp;(LA)
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name="la_id" value="{{ $la_cates->id }}">
                                                        <input class="form-control" name="la_name" type="text"
                                                            id="example-text-input"
                                                            value="{{ $la_cates->name }}"
                                                            placeholder="@lang('backend.la_category_placeholder')">
                                                        <span class="text-danger">
                                                            @error('la_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row col-sm-4">
                                                <div class="post-attribute-header">
                                                    <span>@lang('backend.cn_category_title')</span>&nbsp;&nbsp;<span
                                                        class="fi fi-cn"></span>&nbsp;&nbsp;(CN)
                                                </div>
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name="cn_id" value="{{ $cn_cates->id }}">
                                                        <input class="form-control" name="cn_name" type="text"
                                                            id="example-text-input"
                                                            value="{{ $cn_cates->name }}"
                                                            placeholder="@lang('backend.cn_category_placeholder')">
                                                        <span class="text-danger">
                                                            @error('cn_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-sm-12">
                                        <div class="container"
                                            style="display: flex; align-items:center;justify-content:space-between">
                                            <div class="row col-sm-6">
                                                <div class="fea-img-header">
                                                    <span>@lang('backend.image')</span></span>&nbsp;&nbsp;<span
                                                        style="color: blue">(max-size:
                                                        2MB)</span>
                                                </div>
                                                <div class="fea-img-upload"
                                                    style="border: 1px solid #ced4da; padding:5% 0; border-radius:6px; width:93%; margin-left:2%">
                                                    <label for="feature-img">
                                                        <div class="col-sm-10 img">
                                                            <i class="fas fa-upload"></i>
                                                            <p>@lang('backend.choose_image')</p>
                                                        </div>
                                                    </label>
                                                    <input type="file" id="feature-img" name="image"
                                                        style="display: none; visibility:none">
                                                    <div class="row mb-3"
                                                        style="display: flex; align-items:center; justify-content:start">
                                                        <div class="col-sm-10">
                                                            <img id="showImage" class="rounded avatar-lg"
                                                                src="{{ $isUpdate == null ? url('upload/no_image.jpg') : url($data->image) }}"
                                                                alt="Card image cap">
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="text-danger">
                                                    @error('image')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="row col-sm-6">
                                                <a type="button" href="{{ route('category') }}"
                                                    class="btn btn-secondary" style="width: 40%; margin:10% 0 0 5%"><i
                                                        class="fas fa-xmark"></i>&nbsp;&nbsp;
                                                    @lang('backend.cancel_button')</a>
                                                <button type="submit" class="btn btn-info"
                                                    style="width: 40%; margin:10% 0 0 12%"><i
                                                        class="fas fa-save"></i>&nbsp;&nbsp;
                                                    @lang('backend.update_button')</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div style=" display:flex; align-items:center;justify-content:space-between">
                                <h6 style="text-align: start; margin-left:2%" class="mt-3">@lang('backend.categories')</h6>
                                @if ($trashed < 1)
                                    <p></p>
                                @else
                                    <a type="button" href="{{ route('cates.index.trashed') }}" class="icon-button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Trashed">
                                        <span class="material-icons">
                                            <i class="fa-solid fa-trash"></i>
                                        </span>
                                        <span class="icon-button__badge">{{ $trashed }}</span>
                                    </a>
                                @endif
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
                                    @forelse ($categories as $item)
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
                                                @if (Auth::user()->can('category.edit'))
                                                    <a href="{{ route('edit.category', $item->id) }}"
                                                        class="btn btn-info btn-sm edit-category">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('category.soft.delete'))
                                                    <a href="{{ route('delete.category', $item->id) }}" id="delete"
                                                        class="btn btn-danger btn-sm" title="Delete Data">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <p>@lang('backend.no_data_available_in_table')</p>
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
