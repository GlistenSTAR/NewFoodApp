@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Discount code</a></li>
    <li><a href="{{ url('admin/discountcode') }}">Discount code List</a></li>
</ul>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Discount code List</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
            <a href="{{ url('admin/discountcode/add') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Discount code</span></a>

    <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">Discount code Search</h3>
   </div>
   <!--  Search Box  Start -->
   <div class="panel-body">
      <form action="" method="get">
         <div class="col-md-3">
            <label>ID</label>
            <input type="text" value="{{ Request()->id }}" class="form-control" placeholder="ID" name="id">
         </div>
         <div class="col-md-3">
            <label>Discount Code</label>
            <input type="text" class="form-control" value="{{ Request()->discount_code }}" placeholder="Discount Code" name="discount_code">
         </div>
          <div class="col-md-3">
            <label>Discount Price</label>
            <input type="text" class="form-control" value="{{ Request()->discount_price }}" placeholder="Discount Price" name="discount_price">
         </div>
            <div class="col-md-3">
            <label>Type</label>
            
            <select class="form-control" name="type">
                <option value="">Select</option>
                <option {{ (Request()->type ==  '100') ? 'selected' : '' }} value="100">Percentage %</option>
                <option {{ (Request()->type ==  '1') ? 'selected' : '' }} value="1">Amount</option>
            
            </select>
            
         </div>




         <div style="clear: both;"></div>
         <br>
         <div class="col-md-12">
            <input type="submit" class="btn btn-primary" value="Search">
            <a href="{{ url('admin/discountcode') }}" class="btn btn-success">Reset</a>
         </div>
      </form>
   </div>
   <!-- Search Box  End -->
</div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Discount Code List</h3>
                </div>
               

                <div class="panel-body" style="overflow: auto;">
                    <table  class="table table-striped table-bordered table-hover" id="customers2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Discount Code</th>
                                <th>Discount Price</th>
                                <th>Expiry Date</th>
                                <th>Type </th>
                                <th>Usage </th>
                                <th>Not eligable Category</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>
                        @forelse($getrecord as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                
                                <td>
                                    {{ $value->discount_code }}
                                </td>
                                <td>
                                    {{ $value->discount_price }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($value->expiry_date))}}
                                  {{--   {{ $value->expiry_date }} --}}
                                </td>
                                
                                <td>{{ !empty($value->type)?'Amount':'Percentage' }}</td>
                                <td>{{ ($value->usage == 1) ? 'One Time' : 'Unlimited' }}</td>
                                
                                <td>
                                    @foreach($value->getcategorydiscount as $category)
                                        {{ $category->getcategory->name }}<br />
                                    @endforeach
                                </td>
                                <td>{{ $value->created_at }}</td>
                                <td>
                                {{-- <a class="btn btn-info" href="{{ url('admin/discountcode/show/'.$value->id) }}">View</a> --}}
                                <a class="btn btn-primary" href="{{ url('admin/discountcode/edit/'.$value->id) }}">Edit</a>
                                <a class="btn btn-danger" href="{{ url('admin/discountcode/delete/'.$value->id) }}">Delete</a>
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
