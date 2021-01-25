@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Setting</a></li>
   <li><a>  Setting </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  Setting  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Setting</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Admin Email </label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="admin_email"  type="email" placeholder="" required="" class="form-control" value="{{ $setting->admin_email }}" />
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Notification Key </label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="notification_key"  type="text"   required class="form-control" value="{{ $setting->notification_key }}" />
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel-footer">
                  <button class="btn btn-primary pull-right">Submit</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection