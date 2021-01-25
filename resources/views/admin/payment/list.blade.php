@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
    <li><a href="#">Payment</a></li>
    <li><a href="{{ url('admin/payment') }}">Payment List</a></li>
</ul>
<div class="Order-title">
    <h2> <span class="fa fa-arrow-circle-o-left"></span> Payment</h2>
</div>
<div class="Order-content-wrap">
    <div class="row">
        <div class="col-md-12">
        @include('layouts.message')
            <div class="panel panel-default">
       
                <div class="panel-body" style="overflow: auto;">
                    @if(empty($user->package->type))
                      <div class="col-md-12">Monthly Payment : &pound;{{ !empty($user->package->price) ? $user->package->price : '0' }}</div>
                    @else
                      <div class="col-md-12">This Month Commission Payment : &pound;{{ number_format($this_month,2) }}</div>
                      <br /><br />
                      <div class="col-md-12">Last Month Commission Payment : &pound;{{ number_format($last_month,2) }}</div>
                    @endif                                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection