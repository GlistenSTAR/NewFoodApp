@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Age 18 + ID</a></li>
   <li><a href="{{ url('admin/ageid') }}">Age 18 + ID List</a></li>
</ul>
<div class="Order-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Age 18 + ID List</h2>
</div>
<div class="Order-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">Age 18 + ID Search</h3>
            </div>
            <!--  Search Box  Start -->
            <div class="panel-body">
               <form action="" method="get">
                  <div class="col-md-3">
                     <label>Age 18 + ID</label>
                     <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="Age 18 + ID" name="id">
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
                     <label>Customer Name</label>
                     <input type="text" value="{{ Request()->name }}" class="form-control" placeholder="Customer Name" name="name">
                  </div>
                  <div class="col-md-3">
                     <label> Status</label>
                     <select class="form-control" name="status">
                        <option value="">Select</option>
                        @foreach($getStatus as $value)
                        <option {{ (Request()->status ==  $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div style="clear: both;"></div>
                  <br>
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-primary" value="Search">
                     <a href="{{ url('admin/ageid') }}" class="btn btn-success">Reset</a>
                  </div>
               </form>
            </div>
            <!-- Search Box  End -->
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Age 18 + ID List</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <table  class="table table-striped table-bordered table-hover" id="customers2">
                  <thead>
                     <tr>
                        <th>ID</th>
                        @if(Auth::user()->is_admin == 1)
                        <th>Restaurant Name</th>
                        @endif
                        <th>Customer Name</th>
                        <th>Image</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($getrecord as $value)
                     <tr>
                        <td>{{ $value->id }}</td>
                        @if(Auth::user()->is_admin == 1)
                        <td>
                           {{ !empty($value->restaurant->name)?$value->restaurant->name:'' }}
                        </td>
                        @endif
                        <td>
                           {{ !empty($value->user->name)?$value->user->name:'' }}
                        </td>
                        <td>
                           @if(!empty($value->getLogo()))
                           <img src="{{ $value->getLogo() }}" style="height: 100px;">
                           @endif
                        </td>
                        <td>{{ $value->reason }}</td>
                        <td>               
                           {{ $value->getstatus->name }}
                        </td>
                        <td>{{ $value->created_at }}</td>
                        <td>
                           @if($value->status == 1)
                           <a onclick="return confirm('Are you sure you want to approve?');" href="{{ url('admin/ageid/updatestatus/'.$value->id) }}" class="btn btn-primary">Approve</a>
                           <a id="<?=$value->id?>" href="javascript:;" class="btn btn-danger AddReason">Reject</a>
                           @endif

                           <a onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger" href="{{ url('admin/ageid/delete/'.$value->id) }}">Delete</a>
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

<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog modal-md">
      <form method="post" action="{{ url('admin/ageid/add_reason') }}">
         {{ csrf_field() }}
         <input type="hidden" id="reason_no" name="reason_no" class="form-control">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Reason </h4>
            </div>
            <div class="modal-body">
               <div class="col-md-2">Reason</div>
               <div class="col-md-10">
                  <textarea name="reason" rows="6" required class="form-control"></textarea>
               </div>
               <div style="clear: both;"></div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Submit</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </div>
      </form>
   </div>
</div>

@endsection
@section('js')
<script type="text/javascript">

   
    $('table').delegate('.AddReason','click',function(){
       var id = $(this).attr('id');
       $('#reason_no').val(id);
        $('#myModal').modal('show');
    });
 
   
</script>
@endsection
