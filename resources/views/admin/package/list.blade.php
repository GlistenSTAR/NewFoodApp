@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Package</a></li>
    <li><a href="{{ url('admin/package') }}">Package List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Package List</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
       

        <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Package Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-2">
            <label>Package ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
         </div>
         <div class="col-md-3">
            <label>Package Name</label>
            <input type="text" class="form-control" value="{{ Request()->name }}" placeholder="Package Name" name="name">
         </div>
         <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/package') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"> Package List</h3>
    </div>
   

    <div class="panel-body" style="overflow: auto;">
        <table  class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Package ID</th>
                   
                    
                    <th>Package Name</th>

                    <th>Package Price</th>
                 
                    <th>Package Type</th>
                    
                     <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($getrecord as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                   
                    <td>
                        {{ $value->name }}
                    </td>
                    
                    <td>
                        {{ $value->price }}
                    </td>
                    <td>{{ !empty($value->type)?'Commision':'Month' }}</td>
                    <td>{{ $value->created_at }}</td>
                    <td>
                       
                        <a class="btn btn-primary" href="{{ url('admin/package/edit/'.$value->id) }}">Edit</a>
                    
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