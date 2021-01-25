@extends('admin.layout.app')
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Postcode</a></li>
   <li><a href="#">Edit Postcode</a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Edit Postcode</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
     


<div class="col-md-12">

                           <div class="clear-both"></div>






                            <form class="form-horizontal" id="Edit_app" method="post" action="" enctype="multipart/form-data">
                                       {{ csrf_field() }}

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-"> Edit Postcode</h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Postcode Name <span style="color:red">*</span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class="">
                                                    <input name="name" value="{{ $getPostcode->name }}" placeholder="Name" type="text" required="" class="form-control">
                                                     <span style="color:red"></span>
                                                </div>
                                            </div>
                                        </div>


                                    


                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary pull-right">Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>













   </div>
</div>
@endsection