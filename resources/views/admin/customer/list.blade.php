@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Customer</a></li>
   <li><a href="{{ url('admin/restaurant') }}">Customer List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Customer List</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">Customer Search</h3>
            </div>
            <!--  Search Box  Start -->
            <div class="panel-body">
               <form action="" method="get">
                  <div class="col-md-2">
                     <label>Customer ID</label>
                     <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
                  </div>
                  <div class="col-md-3">
                     <label>Username</label>
                     <input type="text" class="form-control" value="{{ Request()->username }}" placeholder="Username" name="username">
                  </div>
                   <div class="col-md-3">
                     <label>Name</label>
                     <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Name" name="name">
                  </div>
                  <div class="col-md-2">
                     <label>Email</label>
                     <input type="text" class="form-control" value="{{ Request()->email }}" placeholder="Email" name="email">
                  </div>

                  <div class="col-md-2">
                     <label>Restaurant Name</label>
                      <select class="form-control" name="restaurant_id">
                         <option value="">Select Restaurant Name</option>
                        @foreach ($getrestaurant as $element)                        
                         <option value="{{ $element->id }}" {{ ($element->id == Request()->restaurant_id) ? 'selected' : '' }} >{{ $element->name }}</option>                   
                        @endforeach                  
                      </select>
                  </div>

                  <div style="clear: both;"></div>
                  <br>
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-primary" value="Search">
                     <a href="{{ url('admin/customer') }}" class="btn btn-success">Reset</a>
                  </div>
               </form>
            </div>
            <!-- Search Box  End -->
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Customer List</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <table  class="table table-striped table-bordered table-hover" id="customers2">
                  <thead>
                     <tr>
                        <th>Customer ID</th>
                        <th>Restaurant Name</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address 1</th>
                        <th>Address 2</th>
                        <th>City</th>
                        <th>Postcode</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($user as $value)
                     <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ !empty($value->restaurant) ? $value->restaurant->name : '' }}</td>
                        <td>{{ $value->username }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->address_one }}</td>
                        <td>{{ $value->address_two }}</td>
                        <td>{{ $value->city }}</td>
                        <td>{{ $value->postcode }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>
                           <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" href="{{ url('admin/customer/delete/'.$value->id) }}">Delete</a>
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