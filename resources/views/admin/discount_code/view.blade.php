@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Discount Code</a></li>
   <li><a>  View Discount Code </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  View Discount Code  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">View Discount Code</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Discount Code ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->id }}
                     </div>
                  </div>
                 
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Discount Code :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->discount_code }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Discount Price :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->discount_price }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Expiry Date :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ date('d-m-Y', strtotime($getrecord->expiry_date))}}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Type :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                       {{ !empty($getrecord->type)?'Amount':'Percentage' }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                    Created Date :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                       {{ $getrecord->created_at }}
                     </div>
                  </div>
                
               </div>
               <div class="panel-footer">
                  <a class="btn btn-primary pull-right" href="{{ url('admin/discountcode') }}">Back</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
