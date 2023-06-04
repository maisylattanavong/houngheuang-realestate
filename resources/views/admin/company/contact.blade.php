@if(Auth::user()->can('contact.add'))
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('store.contact', app()->getLocale()) }}">
            @csrf

            <div class="col-md-8">
                <div class="mb-3">
                    <label for="text" class="form-label">Username</label>
                    <input type="text" name="contactName" class="form-control" placeholder="Username">
                    @error('contactName')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="text" class="form-label">Email</label>
                        <input type="email" name="contactEmail" class="form-control" placeholder="email@gmail.com">
                        @error('contactEmail')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="text" class="form-label">Phone</label>
                        <input type="tel" name="contactPhone" class="form-control" placeholder="20555....">
                        @error('contactPhone')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tel" class="form-label">What App</label>
                        <input type="tel" name="conWhatsapp" class="form-control" placeholder="20555...">
                        @error('conWhatsapp')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="text" class="form-label">Line</label>
                        <input type="text" name="conlineId" class="form-control" placeholder="Line">
                        @error('conlineId')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endif

<div class="card mt-5">
    <div class="card-body">
        <table id="contactTable" class="table table-bordered dt-responsive nowrap"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">WhatsApp</th>
                    <th scope="col">Line</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($contact as $value)
                    <tr>
                        <td scope="row">{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->whatsapp }}</td>
                        <td>{{ $value->lineid }}</td>
                        <td>
                            @if(Auth::user()->can('siteInfo.delete'))
                            <a href="{{ route('delete.contact', $value->id) }}" id="delete"
                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            @endif

                            @if(Auth::user()->can('siteInfo.edit'))
                            <a href="#" class="btn btn-success btn-sm editModal" data-bs-toggle="modal"
                                data-bs-target="#contactEditModal" data-id="{{ $value->id }}"
                                data-name="{{ $value->name }}" data-email="{{ $value->email }}"
                                data-phone="{{ $value->phone }}" data-whatsapp="{{ $value->whatsapp }}"
                                data-lineId="{{ $value->lineid }}"><i class="fa fa-edit"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="contactEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update.contact', count($contact) == 0 ? 0 : $value->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id">
                            <label for="text" class="form-label">Username</label>
                            <input type="text" id="name" name="updateName" class="form-control">
                            @error('updateName')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">Email</label>
                                <input type="email" name="updateEmail" id="email" class="form-control">
                                @error('updateEmail')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">Phone</label>
                                <input type="tel" name="updatePhone" id="phone" class="form-control">
                                @error('updatePhone')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tel" class="form-label">What App</label>
                                <input type="tel" name="updateWhatsapp" id="whatsapp" class="form-control">
                                @error('updateWhatsapp')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="text" class="form-label">Line</label>
                                <input type="text" name="updateLineId" id="conlineId" class="form-control">
                                @error('updateLineId')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
