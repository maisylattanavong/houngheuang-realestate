@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Translate to Laos</h4>

                            <form method="POST" action="{{ route('about.translate') }}" enctype="multipart/form-data"
                                class="mt-3">
                                @csrf

                                @if ($about->status == 'true')
                                    @foreach ($aboutTrans as $item)
                                        <input type="hidden" name="id" value="{{ $about->id }}">
                                        <input type="hidden" name="status" value="{{ $about->status }}">
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Choose
                                                Language</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" name="locale"
                                                    aria-label="Default select example" value="{{ $about->locale }}">
                                                    <option value="la" style="background:rgb(214, 214, 214)">
                                                        Lao
                                                    </option>
                                                    @foreach (config('app.available_locales') as $locale)
                                                        @if ($locale == 'la')
                                                            <option value="la">Lao</option>
                                                        @elseif($locale == 'en')
                                                            <option value="en">English</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="title" type="text"
                                                    placeholder="{{ $about->title }}"
                                                    value="{{ $count > 0 ? $item->title : '' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Short
                                                Title</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="short_title" type="text"
                                                    id="example-text-input"
                                                    value="{{ $count > 0 ? $item->short_title : '' }}"
                                                    placeholder="{{ $about->short_title }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Short
                                                Description</label>
                                            <div class="col-sm-10">
                                                <textarea required="" name="short_description" class="form-control" rows="5"
                                                    placeholder="{{ $about->short_description }}">
                                            {{ $count > 0 ? $item->short_description : '' }}
                                    </textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Long
                                                Description</label>
                                            <div class="col-sm-10">
                                                <textarea id="elm1" name="long_description" placeholder="{{ $about->long_description }}">
                                            {{ $count > 0 ? $item->long_description : '' }}
                                        </textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <input type="hidden" name="id" value="{{ $about->id }}">
                                    <input type="hidden" name="status" value="{{ $about->status }}">
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Choose
                                            Language</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" name="locale" aria-label="Default select example"
                                                value="{{ $about->locale }}">
                                                <option value="la" style="background:rgb(214, 214, 214)">
                                                    Lao
                                                </option>
                                                @foreach (config('app.available_locales') as $locale)
                                                    @if ($locale == 'la')
                                                        <option value="la">Lao</option>
                                                    @elseif($locale == 'en')
                                                        <option value="en">English</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="title" type="text"
                                                placeholder="{{ $about->title }}"
                                                value="{{ $count > 0 ? $aboutTrans->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Short
                                            Title</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="short_title" type="text"
                                                id="example-text-input"
                                                value="{{ $count > 0 ? $aboutTrans->short_title : '' }}"
                                                placeholder="{{ $about->short_title }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Short
                                            Description</label>
                                        <div class="col-sm-10">
                                            <textarea required="" name="short_description" class="form-control" rows="5"
                                                placeholder="{{ $about->short_description }}">
                                            {{ $count > 0 ? $aboutTrans->short_description : '' }}
                                    </textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Long
                                            Description</label>
                                        <div class="col-sm-10">
                                            <textarea id="elm1" name="long_description" placeholder="{{ $about->long_description }}">
                                            {{ $count > 0 ? $aboutTrans->long_description : '' }}
                                        </textarea>
                                        </div>
                                    </div>
                                @endif
                                <input type="submit" class="btn btn-success"
                                    value="{{ $count > 0 ? 'Save Update Translate' : 'Save Translate' }}"
                                    style="margin-left: 17%">
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
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
