@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Review</a></li>
    <li><a href="{{ url('admin/review') }}">Review List</a></li>
</ul>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Review List</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
   
    <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Review Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-3">
            <label>ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
         </div>
      
         <div class="col-md-3">
            <label>Name</label>
            <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Name" name="name">
         </div>
          <div class="col-md-3">
            <label>Review</label>
            <input type="text" class="form-control" value="{{ Request()->review }}" placeholder="Review" name="review">
         </div>

         <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/review') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Review List</h3>
                </div>
               

                <div class="panel-body" style="overflow: auto;">
                    <table  class="table table-striped table-bordered table-hover" id="customers2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                @if(Auth::user()->is_admin == 1)
                                <th>Restaurant Name</th>
                                @endif
                                <th>Name</th>
                                <th>Review</th>
                                <th>Rating</th>
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
                  <td>{{ !empty($value->restaurant->name)?$value->restaurant->name:'' }}</td>
                  @endif
                  <td>{{ $value->name  }}</td>
                  <td>{{ $value->review  }}</td>
                  <td>{{ $value->rating }}</td>
                  <td>
                    <select class="form-control ChangeReviewStatus" id="{{ $value->id  }}" style="width: 150px;">
                        <option value="0" <?=($value->is_review == '0') ? 'selected' : ''?>>Pending</option>
                        <option value="1" <?=($value->is_review == '1') ? 'selected' : ''?>>Approved</option>
                    </select>
                  </td>
                  <td>{{ $value->updated_at }}</td>
      <td>
      <a class="btn btn-danger" href="{{ url('admin/review/delete/'.$value->id) }}">Delete</a>
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
      $('.ChangeReviewStatus').change(function(){
            var id = $(this).attr('id');
            var status = $(this).val();
              $.ajax({
                     type:'GET',
                     url:"{{url('admin/change_review_status')}}",
                     data: {id:id,status:status},
                     dataType: 'JSON',
                     success:function(data){
                        alert('Status successfully changed');
                     }
              });
      }); 
  </script>
@endsection