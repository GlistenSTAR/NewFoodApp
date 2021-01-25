@extends('admin.layout.app')

@section('content')


 <ul class="breadcrumb">
                    <li><a href="#">Category</a></li>
                    <li><a>Edit Category </a></li>
                </ul>

                <div class="page-">
                    <h2><span class="fa fa-arrow-circle-o-left"></span>  Edit Category  </h2>
                </div>

                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">

                           @include('layouts.message')


                            <form class="form-horizontal" id="Edit_app" method="post" action="{{ url('admin/category/edit/'.$getrecord->id) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-"> Edit Category</h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Category Name <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="name" value="{{ old('name',$getrecord->name) }}" placeholder="Name" type="text"   required class="form-control" />
                                                     <span style="color:red">{{  $errors->first('name') }}</span>
                                                </div>
                                            </div>
                                        </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Category Order By  <span style="color:red">*</span></label>
        <div class="col-md-8 col-xs-12">
            <div class="">
                <input name="category_order_by" value="{{ old('category_order_by',$getrecord->category_order_by) }}" placeholder="Category Order By " type="text"   required class="form-control" />
                 <span style="color:red">{{  $errors->first('category_order_by') }}</span>
            </div>
        </div>
    </div>

                                          <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Category Image <span style="color:red"></span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="logo" type="file" class="form-control" />
                                                    @if(!empty($getrecord->logo))
                                                        <img src="{{ url('upload/category/'.$getrecord->logo) }}" style="height: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

             @if(!empty(Auth::user()->is_age))
                <div class="form-group">
                 <label class="col-md-2 col-xs-12 control-label">Age 18+<span style="color:red"></span></label>
                 <div class="col-md-8 col-xs-12">
                    <div class="" style="margin-top: 5px;">
                       <input name="is_age" {{ !empty($getrecord->is_age) ? 'checked' : '' }} type="checkbox"  />
                    </div>
                 </div>
                </div>
            @endif


                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Status <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                   <select name="status" class="form-control">
                                                    <option {{ ($getrecord->status == '0')?'selected':'' }} value="0">Active</option>
                                                    <option {{ ($getrecord->status == '1')?'selected':'' }} value="1">Inactive</option>
                                                 </select>
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
