@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Landing Page</a></li>
   <li><a>Landing Page </a></li>
</ul>
<div class="page-">
   <h2> <span class="fa fa-arrow-circle-o-left"></span>  Landing Page  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/landing') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-"> Landing Page</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Title <span style="color:red">*</span></label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="title"  type="text" placeholder="Title" required="" class="form-control" value="{{ $setting->title }}" />
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Logo </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="logo"  type="file" />
                           @if(!empty($setting->logo))
                           <img src="{{ url('upload/landing/'.$setting->logo) }}" style="width:100px;">
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Header Description </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <textarea rows="12" class="form-control" name="header_description"  placeholder="Description">{{ $setting->header_description }}</textarea>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Footer Description </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <textarea rows="12" class="form-control" name="footer_description"  placeholder="Description">{{ $setting->footer_description }}</textarea>
                        </div>
                     </div>
                  </div>
                  <hr />
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Button Name <span style="color:red">*</span></label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="button_name"  type="text" placeholder="Button Name" required="" class="form-control" value="{{ $setting->button_name }}" />
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Button Link <span style="color:red">*</span></label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="button_link"  type="text" placeholder="Button Link" required="" class="form-control" value="{{ $setting->button_link }}" />
                        </div>
                     </div>
                  </div>
                  <hr />
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Middle Description </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <textarea rows="12" class="form-control" name="middle_description"  placeholder="Description">{{ $setting->middle_description }}</textarea>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Image </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="middle_image_one"  type="file" />
                           @if(!empty($setting->middle_image_one))
                           <img src="{{ url('upload/landing/'.$setting->middle_image_one) }}" style="width:100px;">
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Middle Description One </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <textarea rows="12" class="form-control" name="middle_description_one"  placeholder="Description">{{ $setting->middle_description_one }}</textarea>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Image </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="middle_image_two"  type="file" />
                           @if(!empty($setting->middle_image_two))
                           <img src="{{ url('upload/landing/'.$setting->middle_image_two) }}" style="width:100px;">
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Middle Description Two </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <textarea rows="12" class="form-control" name="middle_description_two"  placeholder="Description">{{ $setting->middle_description_two }}</textarea>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Image </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <input name="middle_image_three"  type="file" />
                           @if(!empty($setting->middle_image_three))
                           <img src="{{ url('upload/landing/'.$setting->middle_image_three) }}" style="width:100px;">
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Middle Description Three </label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <textarea rows="12" class="form-control" name="middle_description_three"  placeholder="Description">{{ $setting->middle_description_three }}</textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel-footer">
                  <button class="btn btn-primary pull-right">Save</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
