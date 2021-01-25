@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Restaurant</a></li>
   <li><a>View Restaurant </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  View Restaurant  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">View Restaurant</h3>
                  <a class="btn btn-primary pull-right" href="{{ url('admin/restaurant') }}">Back</a>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Restaurant ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->id }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Restaurant Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->name }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Restaurant Logo :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        @if(!empty($user->logo))
                        <img style="width:100px;" src="{{ url("upload/logo/$user->logo") }}/">
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Contact Number :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->phone }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Address1 :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->address_one }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Address2 :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->address_two }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     City  :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->city }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Postcode   :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->postcode }}
                     </div>
                  </div>
                  <hr />
                  
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Before Radius Charge   :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->before_delivery_charge }}
                     </div>
                  </div>

                   <div class="form-group">
                     <label class="col-md-3 control-label">
                     Radius Miles   :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->radius_miles }}
                     </div>
                  </div>
                
                   <div class="form-group">
                     <label class="col-md-3 control-label">
                   After Radius Charge  :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->delivery_charge }}
                     </div>
                  </div>
              
                  <hr />
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Username :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->username }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Email :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $user->email  }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Status :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ !empty($user->status)?'Inactive':'Active' }}
                     </div>
                  </div>
                  <hr />
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Paypal Client ID :
                     </label>
                     <div class="col-sm-9" style="margin-top: 8px;">
                        {{ $user->paypal_client_id }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Paypal Secret ID :
                     </label>
                     <div class="col-sm-9" style="margin-top: 8px;">
                        {{ $user->paypal_secret_id }}
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Time Schedule</h3>
               </div>
               <div class="panel-body" style="overflow: auto;">
                  <table  class="table table-striped table-bordered table-hover" id="customers2">
                     <thead>
                        <tr>
                           <th>Week</th>
                           <th>Open/Close</th>
                           <th>Start Time</th>
                           <th>End Time</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($user->getweek as $value)
                        <tr>
                           <td>{{ !empty($value->week->name)?$value->week->name:'' }}</td>
                           <td>{{ !empty($value->status)?'Open':'Close' }}</td>
                           <td>{{ $value->start_time }}</td>
                           <td>{{ $value->end_time }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection