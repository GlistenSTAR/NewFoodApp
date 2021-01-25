@extends('admin.layout.app')

@section('content')


 <ul class="breadcrumb">
                    <li><a href="">Discount code</a></li>
                    <li><a>Add Discount code </a></li>
                </ul>

                <div class="page-title">
                    <h2><span class="fa fa-arrow-circle-o-left"></span>  Add Discount code  </h2>
                </div>

                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">

                           @include('layouts.message')


                            <form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/discountcode/insert') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}



                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> Add Discount code</h3>

                                    </div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label"> Not eligable Category multiples option allowed? </label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <select class="form-control" style="height: 200px;" name="category_id[]" multiple="">
                                                        @foreach($getCategory as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
 




                                      <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label"> Discount Code <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="discount_code" required value="{{ old('discount_code') }}" placeholder="Discount Code" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('discount_code') }}</span>
                                                </div>
                                            </div>
                                        </div>
 


                                       <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Discount Price <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="discount_price" required value="{{ old('discount_price') }}" placeholder="Discount Price" type="text" class="form-control number" />
                                                     <span style="color:red">{{  $errors->first('discount_price') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Expiry Date <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="expiry_date" required value="{{ old('expiry_date') }}" placeholder="Expiry Date" type="date" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('expiry_date') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                      


                                 <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Type <span style="color:red">*</span></label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="">
                                           <select name="type" class="form-control">
                                            <option value="0">Percentage %</option>
                                            <option value="1">Amount</option>
                                         </select>
                                        </div>
                                    </div>
                                </div>

                               <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Usage <span style="color:red">*</span></label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="">
                                           <select name="usage" class="form-control">
                                            <option value="2">Unlimited</option>
                                            <option value="1">One Time</option>
                                         </select>
                                        </div>
                                    </div>
                                </div>
                              
                              
                            


                       
                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary pull-right">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

@endsection

@section('js')
<script>

</script>
    
@endsection