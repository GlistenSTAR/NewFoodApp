@extends('admin.layout.app')
@section('content')

<ul class="breadcrumb">
    <li><a href="#">Package</a></li>
    <li><a>Edit Package </a></li>
</ul>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span>  Edit Package  </h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

           @include('layouts.message')


            <form class="form-horizontal" id="Edit_app" method="post" action="{{ url('admin/package/edit/'.$getrecord->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Edit Package</h3>
                    </div>
                    <div class="panel-body">





                        <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">Package Name <span style="color:red">*</span></label>
                            <div class="col-md-8 col-xs-12">
                                <div class="">
                                    <input name="name" required value="{{ old('name',$getrecord->name) }}" placeholder="Package Name" type="text" class="form-control" />
                                     <span style="color:red">{{  $errors->first('name') }}</span>
                                </div>
                            </div>
                        </div>

                    

                       <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">Package Price <span style="color:red"> </span></label>
                            <div class="col-md-8 col-xs-12">
                                <div class="">
                                    <input name="price" value="{{ old('price',$getrecord->price) }}" placeholder="Price" type="text" class="form-control" />
                                     <span style="color:red">{{  $errors->first('price') }}</span>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">Package Type <span style="color:red"></span></label>
                            <div class="col-md-8 col-xs-12">
                                <div class="">
                                   <select name="type" class="form-control">
                                    <option {{ ($getrecord->type == '0')?'selected':'' }} value="0">Month</option>
                                    <option {{ ($getrecord->type == '1')?'selected':'' }} value="1">Commision</option>
                                 </select>
                                </div>
                            </div>
                        </div> --}}


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