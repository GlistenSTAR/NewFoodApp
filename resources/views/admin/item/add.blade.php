@extends('admin.layout.app')

@section('content')


 <ul class="breadcrumb">
                    <li><a href="">Item</a></li>
                    <li><a>Add Item </a></li>
                </ul>

                <div class="page-title">
                    <h2><span class="fa fa-arrow-circle-o-left"></span>  Add Item  </h2>
                </div>

                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">

                           @include('layouts.message')


                            <form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/item/add') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}



                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> Add Item</h3>

                                    </div>
                                    <div class="panel-body">



                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Category Name <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    
                                                    <select required name="category_id" class="form-control" >
                                                        <option value="">Select Category </option>
                                                   
                                                        @foreach ($category_row as $row)
                                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>


                                          <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Item Name  <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="item_name" required value="{{ old('item_name') }}" placeholder="Item Name" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('item_name') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Order By  <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="order_by" required value="{{ old('order_by') }}" placeholder="Order By" type="text" class="form-control" />
                                                     <span style="color:red">{{  $errors->first('order_by') }}</span>
                                                </div>
                                            </div>
                                        </div>


                                          <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Item Description <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <textarea name="item_description" required placeholder="Item Description " type="text" class="form-control" />{{ old('item_description') }}</textarea>
                                                     <span style="color:red">{{  $errors->first('item_description') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Item Image </label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="item_image" type="file" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                       <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Price <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="price" required value="{{ old('price') }}" placeholder="Price" type="text" class="form-control number" />
                                                     <span style="color:red">{{  $errors->first('price') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Option Type <span style="color:red">*</span></label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="">
                                           <select name="option_type" id="option_type" class="form-control">
                                            <option value="0">Unlimited</option>
                                            <option value="1">Limited</option>
                                         </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;" id="option_size_show">
                                    <label class="col-md-2 col-xs-12 control-label">Option Size <span style="color:red">*</span></label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="">
                                            <select class="form-control" name="option_size" id="option_size">
                                                <option value="">Select Option Size</option>
                                                @for($i=1; $i<=100; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                      


                                 <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Status <span style="color:red">*</span></label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="">
                                           <select name="status" class="form-control">
                                            <option value="0">Active</option>
                                            <option value="1">Inactive</option>
                                         </select>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Add Option <span style="color:red">*</span></label>
                                    <div class="col-md-8 col-xs-12">
                                           <table class="table">
                                                <tr>
                                                    <th>Group By </th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <select class="form-control" name="option[0][group_name]">
                                                            @for($i=0; $i<=100; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td><input  class="form-control" required name="option[0][option_name]" type="text"></td>
                                                    <td><input  class="form-control number" name="option[0][option_price]" type="text"></td>
                                                    <td><a href="#" class="item_remove btn btn-danger">Remove</a></td>
                                                </tr>
                                                <tr id="item_below_row">
                                                    <td colspan="100%">
                                                        <button type="button" id="add_row" class="btn btn-primary">Add</button>
                                                    </td>
                                                </tr>
                                            </table>
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


$('#option_type').change(function(){
    var value = $(this).val();
    if(value == '0')
    {
        $('#option_size_show').hide();    
        $("#option_size").prop('required',false);     
        $("#option_size").val('');     
    }
    else
    {
        $('#option_size_show').show();  
        $("#option_size").prop('required',true);     
    }
    
});

$('.number').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});


    var item_row = 1;
$("#add_row").click(function(e) {
	e.preventDefault();
	
     html ='';
       html +='<tr>';
       html +='<td>';
       html +='<select name="option['+item_row+'][group_name]" class="form-control">';
            @for($i=0; $i<=100; $i++)
                html +='<option value="{{ $i }}">{{ $i }}</option>';
            @endfor                     
       html +='</select>';
       html +='</td><td><input required  class="form-control" name="option['+item_row+'][option_name]" type="text"></td>';       
       html +='<td><input  class="form-control number" name="option['+item_row+'][option_price]" type="text"></td>\n\
               <td><a href="#" class="item_remove btn btn-danger">Remove</a></td>\n\
               </tr>';


	$("#item_below_row").before(html);
	item_row++;

    $('.number').keypress(function(event) {
      if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
      }
    });
        
});

$(".table").delegate(".item_remove","click",function(e) {
	e.preventDefault();
	$(this).parent().parent().remove();
});
    </script>
    
@endsection