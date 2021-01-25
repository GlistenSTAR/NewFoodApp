@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Restaurant</a></li>
   <li><a href="{{ url('admin/restaurant') }}">Restaurant List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Restaurant List</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <a href="{{ url('admin/restaurant/add') }}" class="btn btn-primary" title="Add New Restaurant"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Restaurant</span></a>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">Restaurant Search</h3>
            </div>
            <!--  Search Box  Start -->
            <div class="panel-body">
               <form action="" method="get">
                  <div class="col-md-2">
                     <label>Restaurant ID</label>
                     <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
                  </div>
                  <div class="col-md-3">
                     <label>Name</label>
                     <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Name" name="name">
                  </div>
                  <div class="col-md-3">
                     <label>Username</label>
                     <input type="text" class="form-control" value="{{ Request()->username }}" placeholder="Username" name="username">
                  </div>
                  <div class="col-md-3">
                     <label>Email</label>
                     <input type="text" class="form-control" value="{{ Request()->email }}" placeholder="Email" name="email">
                  </div>
                  <div style="clear: both;"></div>
                  <br>
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-primary" value="Search">
                     <a href="{{ url('admin/restaurant') }}" class="btn btn-success">Reset</a>
                  </div>
               </form>
            </div>
            <!-- Search Box  End -->
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Restaurant List</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <table  class="table table-striped table-bordered table-hover" id="customers2">
                  <thead>
                     <tr>
                        <th>Restaurant ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Package Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($user as $value)
                     <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->username }}</td>
                        <td>{{ !empty($value->package->name)?$value->package->name:'' }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ !empty($value->status)?'Inactive':'Active' }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>
                           @if($value->is_admin == 2)
                              <a class="btn btn-success" href="{{ url('admin/payment?user_id='.$value->id) }}">View Commision</a>
                           @endif
                           <a class="btn btn-info" href="{{ url('admin/restaurant/show/'.$value->id) }}">View</a>
                           <a class="btn btn-primary" href="{{ url('admin/restaurant/edit/'.$value->id) }}">Edit</a>

                           <a onclick="return confirm('Are you sure you want to delete?')"  class="btn btn-danger" href="{{ url('admin/restaurant/delete/'.$value->id) }}">Delete</a>

                           <a class="btn btn-primary" href="{{ url('admin/restaurant/postcodes/'.$value->id) }}">Postcodes</a>
                           @if($value->is_partner == 1)
                           <a class="btn btn-warning" href="{{ url('admin/restaurant/partner/'.$value->id) }}">Partner</a>
                           @endif
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