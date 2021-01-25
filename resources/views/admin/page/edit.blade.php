@extends('admin.layout.app')
@section('content')

<ul class="breadcrumb">
    <li><a href="#">Page</a></li>
    <li><a>Edit Page </a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span>  Edit Page  </h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

           @include('layouts.message')


            <form class="form-horizontal" id="Edit_app" method="post" action="{{ url('admin/page/edit/'.$getrecord->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Edit Page</h3>
                    </div>
                    <div class="panel-body">





                        <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">Page Name <span style="color:red"></span></label>
                            <div class="col-md-8 col-xs-12">
                                <div class="">
                                    <input name="name" value="{{ old('name',$getrecord->name) }}" placeholder="Page Name" type="text" class="form-control" />
                                     <span style="color:red">{{  $errors->first('name') }}</span>
                                </div>
                            </div>
                        </div>

                    

                       <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">Page Description <span style="color:red"> </span></label>
                            <div class="col-md-8 col-xs-12">
                                <div class="">
                                    <textarea name="description" placeholder="Page Description" type="text" class="form-control editor" />{{ old('description',$getrecord->description) }}</textarea>
                                     <span style="color:red">{{  $errors->first('description') }}</span>
                                </div>
                            </div>
                        </div>


                   

                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection