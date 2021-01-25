@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Page</a></li>
    <li><a href="{{ url('admin/page') }}">Page List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Page List</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
       

        <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Page Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-2">
            <label>Page ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="Page ID" name="id">
         </div>
         <div class="col-md-3">
            <label>Page Name</label>
            <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Page Name" name="name">
         </div>
         <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/page') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"> Page List</h3>
    </div>
   

    <div class="panel-body" style="overflow: auto;">
        <table  class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Page ID</th>
                    <th>Page Name</th>
                    <th>Page Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($getrecord as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{!! $value->description !!}</td>
                    <td><a class="btn btn-primary" href="{{ url('admin/page/edit/'.$value->id) }}">Edit</a></td>
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