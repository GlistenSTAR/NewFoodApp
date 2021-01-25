@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Category</a></li>
    <li><a href="{{ url('admin/category') }}">Category List</a></li>
</ul>
<div class="Order-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Category List</h2>
</div>
<div class="Order-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
            <a href="{{ url('admin/category/add') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Category</span></a>

                            <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Category Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-2">
            <label>Category ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
         </div>
         <div class="col-md-3">
            <label>Category Name</label>
            <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Name" name="name">
         </div>



         <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/category') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Category List</h3>
                </div>
                <div class="panel-body" style="overflow: auto;">
                    <table  class="table table-striped table-bordered table-hover" id="customers2">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                 <th>Category Order By</th>
                                @if(Auth::user()->is_admin == 1)
                                <th>Restaurant Name</th>
                                @endif

                                <th>Category Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                 <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($getrecord as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                 <td>{{ $value->category_order_by }}</td>
                                @if(Auth::user()->is_admin == 1)
                                <td>{{ !empty($value->user->name)?$value->user->name:'' }}</td>
                                @endif
                                <td>{{ $value->name }}</td>
                                <td>
                                    @if(!empty($value->logo))
                                        <img src="{{ url('upload/category/'.$value->logo) }}" style="height: 100px;">
                                    @endif
                                </td>
                                <td>{{ !empty($value->status)?'Inactive':'Active' }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td>
                                <a class="btn btn-primary" href="{{ url('admin/category/edit/'.$value->id) }}">Edit</a>
                                <a class="btn btn-danger" href="{{ url('admin/category/delete/'.$value->id) }}">Delete</a>
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
