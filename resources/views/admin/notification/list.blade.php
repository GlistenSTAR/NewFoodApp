@extends('admin.layout.app')

@section('content')


 <ul class="breadcrumb">
                    <li><a href="#">Notification</a></li>
                    <li><a>Notification </a></li>
                </ul>

                <div class="page-title">
                    <h2><span class="fa fa-arrow-circle-o-left"></span>  Send Notification  </h2>
                </div>

                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">

                           @include('layouts.message')


<form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/notification') }}" enctype="multipart/form-data">
{{ csrf_field() }}

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"> Send Notification</h3>
    </div>
    <div class="panel-body">

   

{{--      <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Category <span style="color:red">*</span></label>
        <div class="col-md-8 col-xs-12">
            <div class="">
             <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                    @foreach ($categorys as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> --}}
 
   <div class="form-group">
            <label class="col-md-2 col-xs-12 control-label">Title <span style="color:red">*</span></label>
            <div class="col-md-8 col-xs-12">
                <div class="">
                    <input type="text" required name="title" class="form-control" placeholder="Title">
                     <span style="color:red">{{  $errors->first('title') }}</span>
                </div>
            </div>
        </div>

      <div class="form-group">
            <label class="col-md-2 col-xs-12 control-label">Notification <span style="color:red">*</span></label>
            <div class="col-md-8 col-xs-12">
                <div class="">
                    <textarea required name="message" class="form-control" placeholder="Notification"></textarea>
                     <span style="color:red">{{  $errors->first('message') }}</span>
                </div>
            </div>
        </div>
 



                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary pull-right">Send</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

@endsection
