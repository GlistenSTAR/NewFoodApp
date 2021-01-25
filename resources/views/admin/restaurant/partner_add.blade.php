@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="">Partner</a></li>
   <li><a>Add Partner </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  Add Partner  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Add Partner</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Name <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="name" value="{{ old('name') }}" placeholder="Name" type="text"   required class="form-control" />
                           <span style="color:red">{{  $errors->first('name') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Logo <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="logo" type="file" class="form-control" />
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Contact Number  <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="phone" value="{{ old('phone') }}" placeholder="Contact Number" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('phone') }}</span>
                        </div>
                     </div>
                  </div>
               
                  <hr />  

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Username <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="username" value="{{ old('username') }}" placeholder="Username" type="text"   required class="form-control" />
                           <span style="color:red">{{  $errors->first('username') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Email <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="email"  type="email" placeholder="Email" required="" class="form-control" value="{{ old('email') }}" />
                           <span style="color:red">{{  $errors->first('email') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Password <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="password"  required type="text" placeholder="Password" class="form-control" value="" />
                           <span style="color:red">{{  $errors->first('password') }}</span>
                        </div>
                     </div>
                  </div>
              
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Status <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select name="status" class="form-control">
                              <option value="0">Active</option>
                              <option value="1">Inactive</option>
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
