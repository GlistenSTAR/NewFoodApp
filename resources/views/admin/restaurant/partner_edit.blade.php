@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Partner</a></li>
   <li><a>  Edit Partner </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  Edit Partner  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Edit Partner</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Name <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="name" required  type="text"  class="form-control" value="{{ $user->name }}" />
                           <span style="color:red">{{  $errors->first('name') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Logo <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="logo" type="file" class="form-control" />
                           @if(!empty($user->logo))
                           <img style="width:100px;" src="{{ url("upload/logo/$user->logo") }}" >
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Contact Number  <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="phone" value="{{ $user->phone }}" placeholder="Contact Number" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('phone') }}</span>
                        </div>
                     </div>
                  </div>
            
                <hr />

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Username <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input readonly name="username"  type="text" placeholder="" class="form-control" value="{{ $user->username }}" />
                           <span style="color:red">{{  $errors->first('username') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Email <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="email"  type="email" placeholder="" class="form-control" value="{{ $user->email }}" />
                           <span style="color:red">{{  $errors->first('email') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Password </label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="password"  type="text" placeholder="" class="form-control" value="" />
                           <span style="color:red">{{  $errors->first('password') }}</span>
                           (Leave blank if you are not changing the password)
                        </div>
                     </div>
                  </div>
             
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Status <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select name="status" class="form-control">
                           <option {{ ($user->status == '0')?'selected':'' }} value="0">Active</option>
                           <option {{ ($user->status == '1')?'selected':'' }} value="1">Inactive</option>
                           </select>
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