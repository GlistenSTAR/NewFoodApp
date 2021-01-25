@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Order</a></li>
   <li><a>  View Order </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>  View Order  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         <form class="form-horizontal" id="add_app" method="post" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">View Order</h3>
               </div>
               <div class="panel-body">
                  
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Order ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->id }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Transaction ID :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->transaction_id }}
                     </div>
                  </div>
                  @if(Auth::user()->is_admin == 1)
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Restaurant Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ !empty($getrecord->restaurant->name)?$getrecord->restaurant->name:'' }}
                     </div>
                  </div>
                  @endif
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Username :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ !empty($getrecord->user->username)?$getrecord->user->username:'' }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Name :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->name }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Email :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->email }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Address1 :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->address_one }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Address2 :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->address_two }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     City :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->city }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Postcode :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->postcode }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Phone :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->phone }}
                     </div>
                  </div>


                  @if(!empty($getrecord->discount_code))
                     <div class="form-group">
                        <label class="col-md-3 control-label">
                        Total Price :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                           &pound;{{ $getrecord->final_total }}
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
                        Discount Type :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                           {{ ($getrecord->discount_type == '0') ? $getrecord->discount_price.'%' : '&pound;'.$getrecord->discount_price }}
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-md-3 control-label">
                        Discount Amount :
                        </label>
                        <div class="col-sm-5" style="margin-top: 8px;">
                           &pound;{{ $getrecord->discount_amount }}
                        </div>
                     </div>

                  @endif

                   <div class="form-group">
                     <label class="col-md-3 control-label">
                     Delivery Charge :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                       &pound;{{ $getrecord->delivery }}
                     </div>
                  </div>


                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Collection :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                       {{ !empty($getrecord->is_collection) ? 'Yes' : 'No' }}
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Payable Price :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                       &pound;{{ $getrecord->total_price }}
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Total QTY :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->total_qty }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Payment Type :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->payment_type }}
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Order Status :
                     </label>
                     <div class="col-sm-5">
                          <select class="form-control changeStatus" style="width: 130px;" id="{{ $getrecord->id }}">
                              @foreach($getStatus as $status)
                                  <option {{ ($status->id == $getrecord->status_id) ? 'selected' : ''}} value="{{ $status->id }}">{{ $status->name }}</option>
                              @endforeach
                          </select>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Created Date :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->created_at->format('d-m-Y h:i A') }}
                     </div>
                  </div>

                   <div class="form-group">
                     <label class="col-md-3 control-label">
                     Custom Time :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->custom_time }} Minutes
                     </div>
                  </div>


                  <div class="form-group">
                     <label class="col-md-3 control-label">
                        Delivery Custom Date :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ date('d-m-Y H:i:s',strtotime('+'.$getrecord->custom_time.' minutes',strtotime($getrecord->created_at))) }}
                     </div>
                  </div>

                  <hr />

                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Account Number :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->account_number }}
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-3 control-label">
                     Sort Code :
                     </label>
                     <div class="col-sm-5" style="margin-top: 8px;">
                        {{ $getrecord->sort_code }}
                     </div>
                  </div>



                  <hr />


                  <div class="form-group">
                     <label class="col-md-1 col-xs-12 control-label">Item Detail :</label>
                     <div class="col-md-11 col-xs-12">
                        <table class="table">
                           <tr>
                              <th>Item Name</th>
                              <th>Qty</th>
                              <th>Price (&pound;)</th>
                              <th>Sub Total (&pound;)</th>
                              <th>Final Total (&pound;)</th>
                           </tr>
                           @foreach ($getrecord->getorderitem as $value)
                           <tr>
                              <td>
                                 {{ !empty($value->item->item_name)?$value->item->item_name:'' }}
                                 @if(!empty($value->option_data))
                                 @php
                                 $option_data =  $value->option_data;      
                                 $get_option_data = json_decode($option_data);
                                 @endphp
                                 <hr />
                                 @if(!empty($get_option_data))
                                 <table class="table">
                                    <thead>
                                       <tr>
                                          <th>Option Name</th>
                                          <th>Price (&pound;)</th>
                                          <th>Total (&pound;)</th>
                                       </tr>
                                    </thead>
                                    @foreach($get_option_data as $option)
                                    <tr>
                                       <td>{{ $option->option_name }}</td>
                                       <td>{{ $option->option_price }}</td>
                                       <td>{{ $option->option_sub_total }}</td>
                                    </tr>
                                    @endforeach
                                 </table>
                                 @endif
                                 @endif
                              </td>
                              <td>{{ $value->qty }}</td>
                              <td>{{ $value->price }}</td>
                              <td>{{ $value->sub_total }}</td>
                              <td>{{ $value->final_total }}</td>
                           </tr>
                           @endforeach
                        </table>
                     </div>
                  </div>
               </div>
               <div class="panel-footer">
                  <a class="btn btn-primary pull-right" href="{{ url('admin/orders') }}">Back</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
