@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div id="alerts"></div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4> @lang('backend.banner_title')</h4>
                            <div class="row mb-3">
                                @if (Auth::user()->can('bannerSlide.add'))
                                    <div class="col-sm-4 d-flex text-center">
                                        <a type="button" class="btn btn-success" href="{{ route('banner.create') }}">
                                            <i class="fas fa-plus-circle"></i> @lang('backend.add_new')
                                        </a>
                                    </div>
                                @endif
                                <div class="col-sm-8 d-flex justify-content-end">
                                    @if ($unpublish < 1)
                                        <p></p>
                                    @else
                                        <button class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Unpublished">{{ $unpublish }}</button>&nbsp;
                                    @endif
                                    @if ($trashed < 1)
                                        <p></p>
                                    @else
                                        <a type="button" href="{{ route('banner.trashed') }}" class="icon-button"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Trashed">

                                            <span class="material-icons">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                            <span class="icon-button__badge">{{ $trashed }}</span>
                                        </a>&nbsp;&nbsp;
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        @php($i = 1)

                                        <tr>
                                            <th>@lang('backend.number')</th>
                                            <th>@lang('backend.title')</th>
                                            <th>@lang('backend.description')</th>
                                            <th>@lang('backend.image')</th>
                                            <th class="text-center">@lang('backend.public_post')</th>
                                            <th>@lang('backend.created_at')</th>
                                            <th class="text-center">@lang('backend.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($banner as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{!! Str::limit(strip_tags($item->description), '15') !!}</td>
                                                <td><img src="{{ asset($item->image) }}" style="width:120px;">
                                                </td>
                                                <td class="text-center">
                                                    @if (Auth::user()->can('bannerSlide.onOff'))
                                                        <input type="checkbox" data-id="{{ $item->id }}" name="status"
                                                            class="js-switch" {{ $item->status == 1 ? 'checked' : '' }}>
                                                    @endif
                                                </td>
                                                <td>{{ $item->created_at }}</td>
                                                <td class="text-center">
                                                    @if (Auth::user()->can('bannerSlide.edit'))
                                                        <a href="{{ route('banner.edit', $item->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if (Auth::user()->can('bannerSlide.soft.delete'))
                                                        <a href="{{ route('banner.delete', $item->id) }}"
                                                            class="btn btn-danger btn-sm" id="delete">
                                                            <i class="fas fa-trash"></i>
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
                                <div id="test" class="test">

                                </div>
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

        {{-- <script>
            let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

            elems.forEach(function(html) {
                let switchery = new Switchery(html, {
                    size: 'small'
                });
            });

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.js-switch').change(function() {
                    let status = $(this).prop('checked') === true ? 1 : 0;
                    let bannerId = $(this).data('id');
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '{{ route('banner.update.status') }}',
                        data: {
                            'status': status,
                            'banner_id': bannerId
                        },
                        success: function(data) {
                            // alertSuccess('sdfgsdfgd');
                        },
                        error: function(data) {
                            alert("fail");
                        }
                    });
                });
            });


            fucntion alertSuccess(message) {
                $('#alerts').append(
                    '<div class="alert alert-success alert-dismissible fade show">' +
                    '<strong > Success! </strong> Example sdfgsdfg. <button type="button" class="close" data-dismiss="alert">&times;</button >' +
                    message + '</div>'
                );

                $(window).scrollTop(0);
            }
        </script> --}}
    @endsection
