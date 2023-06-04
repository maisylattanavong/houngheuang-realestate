@extends('admin.admin_master')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Permission</h4>
                        <form id="myForm" method="POST" action="{{route('update.permission')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$permission->id}}">
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Permission Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" type="text"  id="example-text-input"
                                value="{{$permission->name}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Group Name</label>
                            <div class="col-sm-10">
                                <select class="form-select mb-3" name="group_name" aria-label="Default select example">
                                    <option value="">Open this select Group</option>
                                    <option value="post" {{$permission->group_name == 'post'?'selected':''}}>Posts</option>
                                    <option value="tag" {{$permission->group_name == 'tag'?'selected':''}}>Tags</option>
                                    <option value="about" {{$permission->group_name == 'about'?'selected':''}}>About Page Setup</option>
                                    <option value="companyinfo" {{$permission->group_name == 'companyinfo'?'selected':''}}>Site Settings</option>
                                    <option value="permission" {{$permission->group_name == 'permission'?'selected':''}}>Permission Settings</option>
                                    <option value="role" {{$permission->group_name == 'role'?'selected':''}}>Role Settings</option>
                                    <option value="admin" {{$permission->group_name == 'admin'?'selected':''}}>Admin Management</option>

                                </select>
                                @error('group_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <input type="submit" class="btn btn-info waves-effect waves-light" value="Update">


                        <!-- end row -->
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#myForm').validate({
            rules:{
                name: {
                    required:true,
                },
                group_name:{
                    required:true,
                }
            },
            messages:{
                name:{
                    required:'Please Enter Name',
                },
                name:{
                    required:'Please Select Group Name',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error,element){
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
