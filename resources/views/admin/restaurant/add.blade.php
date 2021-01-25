@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="">Restaurant</a></li>
   <li><a>Add Restaurant </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  Add Restaurant  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/restaurant/add') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"> Add Restaurant</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Restaurant Name <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="name" value="{{ old('name') }}" placeholder="Name" type="text"   required class="form-control" />
                           <span style="color:red">{{  $errors->first('name') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Restaurant Logo <span style="color:red"></span></label>
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
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Address1 <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="address_one" value="{{ old('address_one') }}" placeholder="Address1" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('address_one') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Address2 <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="address_two" value="{{ old('address_two') }}" placeholder="Address2" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('address_two') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">City <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="city" value="{{ old('city') }}" placeholder="City" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('city') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Postcode <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="postcode" value="{{ old('postcode') }}" placeholder="Postcode" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('postcode') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Mobile Code <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="mobile_code" value="{{ old('mobile_code') }}" placeholder="+44" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('mobile_code') }}</span>
                        </div>
                     </div>
                  </div>

                  <hr />
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Age 18+ <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="" style="margin-top: 5px;">
                           <input name="is_age"  type="checkbox"  />
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Collection <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="" style="margin-top: 5px;">
                           <input name="is_collection"  type="checkbox"  />
                        </div>
                     </div>
                  </div>

                   <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Partner <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="" style="margin-top: 5px;">
                           <input name="is_partner"  type="checkbox"  />
                        </div>
                     </div>
                  </div>
 
                  <hr />

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Before Radius Charge <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="before_delivery_charge" value="{{ old('before_delivery_charge') }}" placeholder="Before Radius Charge" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('before_delivery_charge') }}</span>
                        </div>
                     </div>
                  </div>


                     <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Radius Miles <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="radius_miles" value="{{ old('radius_miles') }}" placeholder="Radius Miles" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('radius_miles') }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">After Radius Charge <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="delivery_charge" value="{{ old('delivery_charge') }}" placeholder="After Radius Charge" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('delivery_charge') }}</span>
                        </div>
                     </div>
                  </div>
                  <hr />  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Package Name <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select name="package_id" class="form-control" >
                              <option value="">Select Package </option>
                              @foreach ($package_row as $row)
                              <option value="{{ $row->id }}">{{ $row->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>
                  <hr />



                  
                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Version Android <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="version_android" value="{{ old('version_android') }}" placeholder="1.0" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('version_android') }}</span>
                        </div>
                     </div>
                  </div>


                   <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Version IOS Active <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="" style="margin-top: 5px;">
                           <input name="is_version_ios"  type="checkbox"  />
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Version IOS <span style="color:red"></span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <input name="version_ios" value="{{ old('version_ios') }}" placeholder="1.0" type="text" class="form-control" />
                           <span style="color:red">{{  $errors->first('version_ios') }}</span>
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
                     <label class="col-md-2 col-xs-12 control-label">User Type <span style="color:red">*</span></label>
                     <div class="col-md-8 col-xs-12">
                        <div class="">
                           <select name="is_admin" class="form-control">
                              <option value="2">Restaurant</option>
                              <option value="1">Admin</option>
                           </select>
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
