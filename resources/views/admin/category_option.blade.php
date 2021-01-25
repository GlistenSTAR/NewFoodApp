@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Category Option</a></li>
   <li><a>Category Option </a></li>
</ul>
<div class="page-">
   <h2> <span class="fa fa-arrow-circle-o-left"></span>  Category Option  </h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <form class="form-horizontal" id="add_app" method="post" action="{{ url('admin/category_option') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-">Category Option</h3>
               </div>
               <div class="panel-body">

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Restaurant <span style="color:red">*</span></label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <select class="form-control" required name="user_id" id="getUser">
                              <option value="">Select Restaurant</option>
                              @foreach($getUser as $value)
                                 <option value="{{ $value->id }}">{{ $value->name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 col-xs-12 control-label">Category <span style="color:red">*</span></label>
                     <div class="col-md-10 col-xs-12">
                        <div class="">
                           <select class="form-control" required name="category_id" id="getCategory">
                              <option value="">Select Category</option>
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
                  <button class="btn btn-primary pull-right">Save</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection




@section('js')
<script>

$('#getUser').change(function(){
      var id = $(this).val();
      $.ajax({
         url: "{{ url('admin/get_category_ajax') }}",
         type: "POST",
         data:{
           "_token": "{{ csrf_token() }}",
             id:id,
          },
          dataType:"json",
          success:function(response){
            $('#getCategory').html(response.success);
          },
      });

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