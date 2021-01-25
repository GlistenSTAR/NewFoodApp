@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Support</a></li>
   <li><a href="{{ url('admin/support') }}">Support List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Support List</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
  <!--  Search Box  Start -->
           <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">Support  Search</h3>
            </div>
          
            <div class="panel-body">
               <form action="" method="get">
                  <div class="col-md-3">
                     <label>Support ID</label>
                     <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="Support ID" name="id">
                  </div>
                
                  <div class="col-md-3">
                     <label>Restaurant Name</label>
                        <select class="form-control" name="user_id">
                           <option value="">Select Restaurant Name</option>
                             @foreach ($getUser as $rows)
                               <option {{ (Request()->user_id ==  $rows->id) ? 'selected' : '' }} value="{{ $rows->id }}">{{ $rows->name }}</option>
                             @endforeach
                        </select>
                  </div>
                
                  <div class="col-md-3">
                     <label>Title Name</label>
                     <input type="text" value="{{ Request()->title }}" class="form-control" placeholder="Title Name" name="title">
                  </div>
                  @if(Auth::user()->is_admin == 2) 
                  <div class="col-md-3">
                     <label> Status</label>
                     <select class="form-control" name="status">
                        <option value="">Select Status</option>
                        <option {{ (Request()->status == '1')?'selected':'' }} value="1">Open</option>
                        <option {{ (Request()->status == '1000')?'selected':'' }} value="1000">Close</option>
                     </select>
                  </div>
                  @endif
                  <div style="clear: both;"></div>
                  <br>
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-primary" value="Search">
                     <a href="{{ url('admin/support') }}" class="btn btn-success">Reset</a>
                  </div>
               </form>
            </div>
    
         </div> 
        <!-- Search Box  End -->
         
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Support List</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <table  class="table table-striped table-bordered table-hover" id="customers2">
                  <thead>
                     <tr>
                        <th>Support ID</th>
                        <th>Restaurant Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($user as $value)
                     <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ !empty($value->user->name)?$value->user->name:'' }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{ $value->description }}</td>
                        <td>
                           @if(Auth::user()->is_admin == 1) 
                           <select class="form-control ChangeSupportStatus" id="{{ $value->id }}" style="width: 80px;">
                              <option value="0" <?= ($value->status == '0') ? 'selected' : '' ?>>Open</option>
                              <option value="1" <?= ($value->status == '1') ? 'selected' : '' ?>>Close</option>
                           </select>
                           @else 
                            {{ ($value->status == '1') ? 'Closed' : 'Open' }}
                            @endif 

                        </td>
                        <td>{{ $value->created_at }}</td>
                        <td>
                           <a class="btn btn-primary" href="{{ url('admin/support/reply/'.$value->id) }}">Reply</a>
                           <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" href="{{ url('admin/support/delete/'.$value->id) }}">Delete</a>
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
                  {{ $user->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('js')
   <script type="text/javascript">
      $('.ChangeSupportStatus').change(function(){
         var id = $(this).attr('id');
         var status = $(this).val();
         $.ajax({
            type:'GET',
            url:"{{ url('admin/change_support_status') }}",
            data: {id: id, status: status},
            dataType: 'JSON',
            success:function(data){
               alert('Status successfully changed');
            }
         });

      });
   </script>
@endsection