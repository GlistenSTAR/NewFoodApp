           
<!DOCTYPE html>
<html>
    <head>
      <title>PDF</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      
    </head>
    <body>
      <table class="table table-bordered">
      <tr>
        <th>Order ID</th>
        <th>{{ $getrecord->id }}</th>
      </tr>
      <tr>
        <td> Transaction ID </td>
        <td>{{ $getrecord->transaction_id }}</td>
      </tr>

      @if(Auth::user()->is_admin == 1)
      <tr>
        <td>Restaurant Name </td>
        <td>  {{ !empty($getrecord->restaurant->name)?$getrecord->restaurant->name:'' }}</td>
      </tr>
      @endif

       <tr>
        <td>Username</td>
        <td>   {{ !empty($getrecord->user->username)?$getrecord->user->username:'' }}</td>
      </tr>
       <tr>
        <td>  Name</td>
        <td>  {{ $getrecord->name }}</td>
      </tr>
       <tr>
        <td> Email </td>
        <td>  {{ $getrecord->email }}</td>
      </tr>
       <tr>
        <td>Address1</td>
        <td>  {{ $getrecord->address_one }}</td>
      </tr>
       <tr>
        <td>  Address2</td>
        <td>  {{ $getrecord->address_two }}</td>
      </tr>
       <tr>
        <td>City</td>
        <td> {{ $getrecord->city }}</td>
      </tr>
       <tr>
        <td>   Postcode </td>
        <td>  {{ $getrecord->postcode }}</td>
      </tr>
       <tr>
        <td>Phone</td>
        <td>  {{ $getrecord->phone }}</td>
      </tr>
       <tr>
        <td>  Total Price (&pound;)</td>
        <td> {{ $getrecord->total_price }}</td>
      </tr>
       <tr>
        <td>Total QTY</td>
        <td>  {{ $getrecord->total_qty }}</td>
      </tr>
      <tr>
        <td> Payment Type </td>
        <td> {{ $getrecord->payment_type }}</td>
      </tr>
      <tr>
        <td> Order Status</td>
        <td>{{ !empty($getrecord->getorderstatus->name)?$getrecord->getorderstatus->name:'' }}</td>
      </tr>
      <tr>
        <td> Created Date</td>
        <td>  {{ $getrecord->created_at->format('d-m-Y h:i A') }}</td>
      </tr>

    </table>
    <hr />
      <table class="table table-bordered">
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
  </body>
</html>


             
          
                  
                 
          
   


