@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Item</a></li>
   <li><a>  View Item </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  View Item  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">View Item</h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Item ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->id }}
                     </div>
                  </div>
                  @if(Auth::user()->is_admin == 1)
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Restaurant Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ !empty($getrecord->user->name)?$getrecord->user->name:'' }}
                     </div>
                  </div>
                  @endif
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Category Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ !empty($getrecord->getcategory->name)?$getrecord->getcategory->name:'' }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Item Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->item_name }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Item Description :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->item_description }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                        Item Image : 
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        @if(!empty($getrecord->item_image))
                        <img src="{{ url('upload/item/'.$getrecord->item_image) }}" style="height: 100px;">
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Price :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->price }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Status :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ !empty($getrecord->status)?'Inactive':'Active' }}
                     </div>
                  </div>
                  <hr />
                  <div class="form-group">
                     <label class="col-md-3 col-xs-12 control-label">Option :</label>
                     <div class="col-md-8 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Action</th>
                           </tr>
                           @forelse($getrecord->getoption as $value)
                           <tr>
                              <td>{{ $value->option_name }}</td>
                              <td>{{ $value->option_price }}</td>
                              <td><a onclick="return confirm('Are you sure you want to delete this option item?');" href="{{ url('admin/item/option/delete/'.$value->id) }}" class="btn btn-danger">Remove</a></td>
                           </tr>
                           @empty
                           <tr>
                              <td colspan="100%">Record not found.</td>
                           </tr>
                           @endforelse
                        </table>
                     </div>
                  </div>
               </div>
               <div class="panel-footer">
                  <a class="btn btn-primary pull-right" href="{{ url('admin/item') }}">Back</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
