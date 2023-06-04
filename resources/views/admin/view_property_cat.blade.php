@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{-- <i class="mdi mdi-dots-vertical"></i> --}}
                                </a>

                            </div>

                            <h4 class="card-title mb-4 text-info">Properties of {{$cat_name}}</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-primary">
                                        <tr class="text-info">
                                            <th>@lang('backend.number')</th>
                                            <th>@lang('backend.title')</th>
                                            <th>@lang('backend.image')</th>
                                            <th>@lang('backend.created_by')</th>
                                            <th>@lang('backend.created_at')</th>
                                            <th style="width: 120px;">@lang('backend.action')</th>
                                        </tr>
                                    </thead><!-- end thead -->

                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($property_cats as $item)
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0">{{ $i++ }}</h6>
                                                </td>
                                                <td>{{ $item['title'] }}</td>
                                                <td><img src="{{ !empty($item->feature_image && file_exists($item->feature_image))
                                                    ? url($item->feature_image)
                                                    : (!empty(file_exists($item->feature_image))
                                                        ? url('upload/no_image.jpg')
                                                        : url('upload/image_deleted.jpg')) }}"
                                                        style="width: 90px; height: 100%"></td>
                                                <td>{{ $item['user']['name'] }}</td>
                                                {{-- <td>{{Carbon\Carbon::parse($item->created_at)->format('h:i:s A \ d-m-Y')}}</td> --}}
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <a href="{{ route('edit.realestate.lao', $item->id) }}" class="btn btn-info sm"
                                                        title="Edit Data">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <h4 class="d-flex justify-content-center text-muted">No data available
                                                        in table</h4>
                                                </td>
                                            </tr>

                                    </tbody><!-- end tbody -->
                                    @endforelse

                                </table> <!-- end table -->
                            </div>
                        </div><!-- end card -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->

            </div>
            <!-- end row -->

        </div>
    @endsection
