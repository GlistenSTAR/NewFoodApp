@extends('admin.layout.app')
@section('style')
{{-- <style type="text/css">

</style> --}}
@endsection
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Order</a></li>
    <li><a href="{{ url('admin/item') }}">Order List</a></li>
</ul>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Order List</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
          

       <div class="panel panel-default" style="font-size:14px;">
         <div class="panel-body">
          <table  class="table table-striped table-bordered table-hover" >
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Total</th>
                      <th>Pending</th>
                      <th>Accepted</th>
                      <th>Processing</th>
                      <th>Delivered</th>
                      <th>Order Cancelled</th>
                  </tr>
              </thead>
              <tbody>
            <tr>
              <td>Order Count</td>
              <td>{{ !empty($countTotal) ? $countTotal : '0' }}</td>
              <td>{{ !empty($countStatusPending) ? $countStatusPending : '0' }}</td>
              <td>{{ !empty($countStatusAccepted) ? $countStatusAccepted : '0' }}</td>
              <td>{{ !empty($countStatusProcessing) ? $countStatusProcessing : '0' }}</td>
              <td>{{ !empty($countStatusDelivered) ? $countStatusDelivered : '0' }}</td>
              <td>{{ !empty($countStatusOrderCancelled) ? $countStatusOrderCancelled : '0' }}</td>
            </tr>
            <tr>
              <td>Total Amount (&pound;)</td>
              <td>
                
               Card =  {{ !empty($CardAmountTotal) ? $CardAmountTotal : '0' }} <br />
               Cash = {{ !empty($CashAmountTotal) ? $CashAmountTotal : '0' }} <br />
               Total = {{ !empty($TotalAmount) ? $TotalAmount : '0' }} <br />

                

              </td>
              <td>{{ !empty($countPendingTotal) ? $countPendingTotal : '0' }}</td>
              <td>{{ !empty($countAcceptedTotal) ? $countAcceptedTotal : '0' }}</td>
              <td>{{ !empty($countProcessingTotal) ? $countProcessingTotal : '0' }}</td>
              <td>{{ !empty($countDeliveredTotal) ? $countDeliveredTotal : '0' }}</td>
              <td>{{ !empty($countOrderCancelledTotal) ? $countOrderCancelledTotal : '0' }}</td>
            </tr>
           </tbody>
          </table>
        </div>
      </div>


  <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Order Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-3">
            <label>Order ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="Order ID" name="id">
         </div>
         <div class="col-md-3">
            <label>Transaction ID</label>
            <input type="text" value="{{ Request()->transaction_id }}" class="form-control" placeholder="Transaction ID" name="transaction_id">
         </div>
        @if(Auth::user()->is_admin == 1)
           <div class="col-md-3">
             <label>Restaurant Name</label>
             <select class="form-control" name="restaurant_id">
               <option value="">Select Restaurant Name</option>
               @foreach ($getUser as $rows)
                 <option {{ (Request()->restaurant_id ==  $rows->id) ? 'selected' : '' }} value="{{ $rows->id }}">{{ $rows->name }}</option>
               @endforeach

             </select>
           </div>
        @endif

         <div class="col-md-3">
            <label>Name</label>
            <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Name" name="name">
         </div>
           <div class="col-md-3" style="margin-top: 10px;">
            <label>Payment Type</label>
            
            <select class="form-control" name="payment_type">
                <option value="">Select</option>
                <option {{ (Request()->payment_type ==  'Cash') ? 'selected' : '' }} value="Cash">Cash</option>
                <option {{ (Request()->payment_type ==  'Card') ? 'selected' : '' }} value="Card">Card</option>
            
            </select>
            
         </div>

          <div class="col-md-3" style="margin-top: 10px;">
            <label>Order Status</label>
                
            <select class="form-control" name="status_id">
                <option value="">Select</option>
                @foreach($getStatus as $value)
                    <option {{ (Request()->status_id ==  $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
            </select>
            
         </div>

         <div class="col-md-3" style="margin-top: 10px;">
            <label>Start Date</label>
            <input type="date" class="form-control" value="{{ Request()->start_date }}" placeholder="Start Date" name="start_date" style="line-height: 1.42857143;">
         </div>
         <div class="col-md-3" style="margin-top: 10px;">
            <label>End Date</label>
            <input type="date" class="form-control" value="{{ Request()->end_date }}" placeholder="End Date" name="end_date" style="line-height: 1.42857143;">
         </div>

          <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/orders') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Orders List

                    </h3>
                    <a href="" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?');" id="getDeleteURL" style="float: right;">Delete</a>
                </div>
               

                <div class="panel-body" style="overflow: auto;">
                    <table  class="table table-striped table-bordered table-hover" id="customers2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Transaction ID</th>
                                @if(Auth::user()->is_admin == 1)
                                  <th>Restaurant Name</th>
                                @endif
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address1</th>
                                <th>Address2</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Phone</th>
                                <th>Total Qty</th>
                                <th>Delivery Charge</th>
                                <th>Total Price</th>
                                <th>Payment Type</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                          $total = 0;
                          $total_qty = 0;
                        @endphp
                        @forelse($getrecord as $value)
                            @php
                              $total = $total + $value->total_price;
                              $total_qty = $total_qty + $value->total_qty;
                            @endphp
                            <tr>
                                <td>
                                  <input class="delete-all-option" value="{{ $value->id }}" type="checkbox" >
                                </td>

                                <td>{{ $value->id }}</td>
                                <td>{{ $value->transaction_id }}</td>
                                @if(Auth::user()->is_admin == 1)
                                <td>
                                    {{ !empty($value->restaurant->name)?$value->restaurant->name:'' }}
                                </td>
                                @endif
                                <td>
                                   {{ !empty($value->user->username)?$value->user->username:'' }}
                                </td>
                                <td>
                                    {{ $value->name }}
                                </td>
                                <td>
                                    {{ $value->email }}
                                </td>
                                <td>
                                    {{ $value->address_one }}
                                </td>
                                <td>
                                    {{ $value->address_two }}
                                </td>
                                <td>
                                    {{ $value->city }}
                                </td>
                                <td>
                                    {{ $value->postcode }}
                                </td>
                                <td>
                                    {{ $value->phone }}
                                </td>
                                <td>{{ $value->total_qty }}</td>
                                <td>{{ $value->delivery }}</td>
                                <td>
                                    {{ $value->total_price }}
                                </td>
                                 <td>
                                    {{ $value->payment_type }}
                                </td>
                              
                                <td>
                                    <select class="form-control changeStatus" style="width: 130px;" id="{{ $value->id }}">
                                        @foreach($getStatus as $status)
                                            <option {{ ($status->id == $value->status_id) ? 'selected' : ''}} value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                              
                                <td>
                                {{ $value->created_at->format('d-m-Y h:i A') }}
                            </td>
                                <td>
                                    {{-- <a class="btn btn-success" href="{{action('OrdersController@downloadPDF', $value->id)}}">Download PDF</a> --}}

                                <a class="btn btn-info" href="{{ url('admin/orders/show/'.$value->id) }}">View</a>
                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" href="{{ url('admin/orders/delete/'.$value->id) }}">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">Record not found.</td>

                            </tr>
                        @endforelse
                        </tbody>

                         <tfoot>
                              <tr>
                                @if(Auth::user()->is_admin == 1)
                                <td colspan="12">Total</td>
                                @else
                                <td colspan="10">Total</td>
                                @endif
                                 
                                 <td>{{ $total_qty }}</td>
                                 <td></td>
                                 <td>${{ $total }}</td>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                              <tr>
                         </tfoot>
                        </table>
                    <div style="float: right">
                         {{ $getrecord->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">

    $('.delete-all-option').change(function(){
        var total = '';
        $('.delete-all-option').each(function(){
            if(this.checked)
            {
                var id = $(this).val();
                total += id+',';
            }

        });

        var url = '{{ url('admin/item/delete_order_multi?id=') }}'+total;
        $('#getDeleteURL').attr('href',url);

        
    });


   
</script>
@endsection

