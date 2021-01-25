@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Postcodes</a></li>
   <li><a href="{{ url('admin/restaurant') }}">Postcodes List</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Postcodes List</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')

         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">Add Postcode</h3>
            </div>
          
            <div class="panel-body">
               <form action="{{ url('admin/restaurant/postcodes/'.$user->id) }}" method="post">
                  {{ csrf_field() }}
                  <div class="col-md-3">
                     <label>Postcode Name</label>
                     <input type="hidden" value="{{ $user->id }}" name="user_id">
                     <input type="text" required class="form-control" value="" placeholder="Name" name="name">
                  </div>
                  <div style="clear: both;"></div>
                  <br>
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-primary" value="Submit">
                  </div>
               </form>
            </div>
         </div>



         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title">Postcode Search</h3>
            </div>
            <!--  Search Box  Start -->
            <div class="panel-body">
               <form action="" method="get">
                  <div class="col-md-2">
                     <label>Postcode ID</label>
                     <input type="text" value="{{ Request()->get('id') }}" class="form-control" placeholder="Postcode ID" name="id">
                  </div>
                  <div class="col-md-3">
                     <label>Postcode Name</label>
                     <input type="text" class="form-control" value="{{ Request()->get('name') }}" placeholder="Postcode Name" name="name">
                  </div>
                  <div style="clear: both;"></div>
                  <br>
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-primary" value="Search">
                     <a href="{{ url('admin/restaurant/postcodes/'.$user->id) }}" class="btn btn-success">Reset</a>
                  </div>
               </form>
            </div>
         </div>

         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Postcode List</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <table  class="table table-striped table-bordered table-hover" id="customers2">
                  <thead>
                     <tr>
                        <th>Postcode ID</th>
                        <th>Postcode</th>
                        <th>Created Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>

                     @foreach($getPostcode as $value)

                        <tr>
                           <td>{{ $value->id }}</td>
                           <td>{{ $value->name }}</td>
                           <td>{{ date('d-m-Y h:i A',strtotime($value->created_at)) }}</td>
                           <td>
                              
                              <a class="btn btn-primary" href="{{ url('admin/restaurant/postcodes/edit/'.$value->id) }}">Edit</a>
                              <a onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger" href="{{ url('admin/restaurant/postcodes/delete/'.$value->id) }}">Delete</a>

                           </td>
                        </tr>


                     @endforeach

                  </tbody>
               </table>
               <div style="float: right">
                     {{ $getPostcode->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection