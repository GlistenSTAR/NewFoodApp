@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Partner</a></li>
   <li><a href="{{ url('admin/restaurant') }}">Partner List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Partner List</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
          <a href="{{ url('admin/restaurant/partner/add/'.$restaurant_id) }}" class="btn btn-primary" title="Add New Partner"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Partner</span></a>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Partner List</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <table  class="table table-striped table-bordered table-hover" id="customers2">
                  <thead>
                     <tr>
                        <th>Partner ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Logo</th>
                        <th>Contact Number </th>
                        <th>Status </th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @forelse($user as $value)
                     <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>
                           @if(!empty($value->logo))
                            <img style="width:100px;" src="{{ url("upload/logo/$value->logo") }}/">
                          @endif
                        </td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ (!empty($value->status)) ? 'Inactive' : "Active" }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td><a class="btn btn-primary" href="{{ url('admin/restaurant/partner/edit/'.$value->id) }}">Edit</a>

                           <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" href="{{ url('admin/restaurant/partner/delete/'.$value->id) }}">Delete</a>
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