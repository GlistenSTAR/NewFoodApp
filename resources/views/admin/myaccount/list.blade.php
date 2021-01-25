@extends('admin.layout.app')

@section('content')


 <ul class="breadcrumb">
                    <li><a href="">My Account</a></li>
                    <li><a>My Account </a></li>
                </ul>

                <div class="page-title">
                    <h2><span class="fa fa-arrow-circle-o-left"></span>  My Account  </h2>
                </div>

                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">

                           @include('layouts.message')


                            <form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/myaccount') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}



                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> My Account</h3>

                                    </div>
                                    <div class="panel-body">



                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Restaurant Name <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="name" value="{{ $user->name }}" placeholder="Name" type="text"   required class="form-control" />
                                                     <span style="color:red">{{  $errors->first('name') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Restaurant Logo <span style="color:red"></span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="" style="margin-top:6px; ">
                                                    <input  name="logo" type="file" />
                                                    @if(!empty($user->logo))
                                                    <img src="{{ url('upload/logo/'.$user->logo) }}" style="height: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Contact Number  <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="phone" value="{{  $user->phone }}" placeholder="Contact Number" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('phone') }}</span>
                                                </div>
                                            </div>
                                        </div>


                                          <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Address1 <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="address_one" required value="{{ $user->address_one }}" placeholder="Address1" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('address_one') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                       <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Address2 <span style="color:red"></span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="address_two" value="{{ $user->address_two }}" placeholder="Address2" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('address_two') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">City <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="city" required value="{{ $user->city }}" placeholder="City" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('city') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Postcode <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="postcode" required value="{{ $user->postcode }}" placeholder="Postcode" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('postcode') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                       <div class="form-group">
                                        <label class="col-md-2 col-xs-12 control-label">Username <span style="color:red">*</span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="">
                                                <input name="username" value="{{ $user->username }}" placeholder="Username" type="text" readonly class="form-control" />
                                                 <span style="color:red">{{  $errors->first('username') }}</span>
                                            </div>
                                        </div>
                                    </div>



                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Email <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="email"  type="email" placeholder="Email" required="" class="form-control" value="{{ $user->email }}" />
                                                     <span style="color:red">{{  $errors->first('email') }}</span>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Password</label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="password" type="text" placeholder="Password" class="form-control" value="" />
                                                     <span style="color:red">{{  $errors->first('password') }}</span>
                                                     (Leave blank if you are not changing the password)
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Stripe Publishable key <span style="color:red"></span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="stripe_publishable_key"  type="text" placeholder="Stripe Publishable key" class="form-control" value="{{ $user->stripe_publishable_key }}" />
                                                     <span style="color:red">{{  $errors->first('paypal_client_id') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Stripe Secret Key  <span style="color:red"></span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="stripe_secret_key"  type="text" placeholder="Stripe Secret Key"  class="form-control" value="{{ $user->stripe_secret_key }}" />
                                                     <span style="color:red">{{  $errors->first('paypal_secret_id') }}</span>
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
