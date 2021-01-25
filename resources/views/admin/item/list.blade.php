@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Item</a></li>
    <li><a href="{{ url('admin/item') }}">Item List</a></li>
</ul>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Item List</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
            <a href="{{ url('admin/item/add') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Item</span></a>

                            <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Item Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-3">
            <label>Item ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
         </div>
          @if(Auth::user()->is_admin == 1)
           <div class="col-md-3">
             <label>Restaurant Name</label>
             <select class="form-control" name="user_id">
                 <option value="">Select Restaurant Name</option>
                 @foreach ($getUser as $rows)
            <option {{ (Request()->user_id ==  $rows->id) ? 'selected' : '' }} value="{{ $rows->id }}">{{ $rows->name }}</option>
            @endforeach
             </select>
           </div>
        @endif

         <div class="col-md-3">
             <label>Category Name</label>


             <select class="form-control" name="category_id">
                 <option value="">Select Category Name</option>
                 @foreach ($getCategory as $row)
            <option {{ (Request()->category_id ==  $row->id) ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
             </select>
         </div>
        
         <div class="col-md-3">
            <label>Item Name</label>
            <input type="text" class="form-control" value="{{ Request()->item_name }}" placeholder="Item Name" name="item_name">
         </div>



         <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/item') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Item List</h3>
                      <a href="" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete?');" id="getDeleteURL" style="float: right;">Delete</a>
                </div>
               

                <div class="panel-body" style="overflow: auto;">
                    <table  class="table table-striped table-bordered table-hover" id="customers2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item ID</th>
                                @if(Auth::user()->is_admin == 1)
                                <th>Restaurant Name</th>
                                @endif
                                <th>Order By</th>
                                <th>Category Name</th>

                                <th>Item Name</th>
                                <th>Item Description</th>
                                <th>Item Image</th>
                                <th>Option Type</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($getrecord as $value)
                            <tr>
                                 <td>
                                  <input class="delete-all-option" value="{{ $value->id }}" type="checkbox" >
                                </td>
                                <td>{{ $value->id }}</td>
                                @if(Auth::user()->is_admin == 1)
                                <td>{{ !empty($value->user->name)?$value->user->name:'' }}</td>
                                @endif
                                <td>{{ $value->order_by }}</td>
                                
                                    <td>{{ !empty($value->getcategory->name)?$value->getcategory->name:'' }}</td>
                                
                                <td>
                                    {{ $value->item_name }}
                                </td>
                                <td>
                                    {{ $value->item_description }}
                                </td>
                                <td>
                                    @if(!empty($value->item_image))
                                     
                                    <img src="{{ url('upload/item/'.$value->item_image) }}" style="height: 100px;">

                                    @endif
                                </td>
                              
                                <td>{{ !empty($value->option_type) ? 'Limited : '.$value->option_size.' ' : 'Unlimited' }}</td>
                                <td>{{ $value->price }}</td>

                                <td>{{ !empty($value->status)?'Inactive':'Active' }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ url('admin/item/show/'.$value->id) }}">View</a>
                                    <a class="btn btn-primary" href="{{ url('admin/item/edit/'.$value->id) }}">Edit</a>
                                    <a onclick="return confirm('Are you sure you want to delete?')"  class="btn btn-danger" href="{{ url('admin/item/delete/'.$value->id) }}">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">Record not found.</td>

                            </tr>
                        @endforelse
                        </tbody>

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

        var url = '{{ url('admin/item/delete_item_multi?id=') }}'+total;
        $('#getDeleteURL').attr('href',url);

        
    });
</script>
@endsection
