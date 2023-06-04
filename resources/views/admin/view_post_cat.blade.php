@extends('admin.admin_master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            {{-- <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">DASHBOARD</h4>
                    </div>
                </div>
            </div> --}}
            <!-- end page title -->

            {{-- <div class="row justify-content-between">
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">Total Categories</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($categories) }} items
                                    </h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-shopping-cart-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">Total Posts</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($allposts) }} items
                                    </h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="ri-stack-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4 class="text-truncate font-size-14 mb-2 text-primary">Total Users</h4>
                                    <h5 class="text-truncate font-size-14 mb-2" style="color: rgb(123, 0, 247)">
                                        {{ count($users) }} Users</h5>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-user-3-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row --> --}}


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>

                            </div>

                            <h4 class="card-title mb-4 text-info">Posts of {{$cat_name}}</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-primary">
                                        <tr class="text-info">
                                            <th>No</th>
                                            <th>Post Title</th>
                                            <th>Feature Image</th>
                                            <th>Posted By</th>
                                            <th>Create Date</th>
                                            <th style="width: 120px;">Action</th>
                                        </tr>
                                    </thead><!-- end thead -->

                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($post_cats as $post_cat)
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0">{{ $i++ }}</h6>
                                                </td>
                                                <td>{{ $post_cat['title'] }}</td>
                                                <td><img src="{{ !empty($post_cat->feature_image && file_exists($post_cat->feature_image))
                                                    ? url($post_cat->feature_image)
                                                    : (!empty(file_exists($post_cat->feature_image))
                                                        ? url('upload/no_image.jpg')
                                                        : url('upload/image_deleted.jpg')) }}"
                                                        style="width: 90px; height: 100%"></td>
                                                <td>{{ $post_cat['user']['name'] }}</td>
                                                {{-- <td>{{Carbon\Carbon::parse($post_cat->created_at)->format('h:i:s A \ d-m-Y')}}</td> --}}
                                                <td>{{$post_cat->created_at}}</td>
                                                <td>
                                                    <a href="{{ route('edit.post', $post_cat->id) }}" class="btn btn-info sm"
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
