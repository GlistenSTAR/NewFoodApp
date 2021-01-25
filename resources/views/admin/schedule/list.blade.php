@extends('admin.layout.app')
@section('style')
<style type="text/css">
   .switch {
     position: relative;
     display: inline-block;
     width: 60px;
     height: 34px;
   }
   .switch input {
     opacity: 0;
     width: 0;
     height: 0;
   }
   .slider {
     position: absolute;
     cursor: pointer;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0;
     background-color: #ccc;
     -webkit-transition: .4s;
     transition: .4s;
   }
   .slider:before {
     position: absolute;
     content: "";
     height: 22px;
     width: 23px;
     left: 4px;
     bottom: 4px;
     background-color: white;
     -webkit-transition: .4s;
     transition: .4s;
   }
   input:checked + .slider {
    background-color: #2196F3;
   }
   input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
   }
   input:checked + .slider:before {
     -webkit-transform: translateX(26px);
     -ms-transform: translateX(26px);
     transform: translateX(26px);
   }
   .slider.round {
     border-radius: 34px;
   }
   .slider.round:before {
     border-radius: 50%;
   }
</style>
@endsection
@section('content')
<ul class="breadcrumb">
   <li><a href="#">Schedule </a></li>
   <li><a href="{{ url('admin/schedule') }}">Schedule </a></li>
</ul>
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Schedule</h2>
</div>
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         @include('layouts.message')
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"> Schedule</h3>
            </div>
            <div class="panel-body" style="overflow: auto;">
               <form action="{{ url('admin/schedule') }}" method="post">
                  {{ csrf_field() }}
                  <table  class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Week</th>
                           <th>Open/Close</th>
                           <th>Start Time</th>
                           <th>End Time</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($week as $row)
                        @php
                        $getuserweek =  App\UserTimeModel::getDetail($row->id);
                        $open_close = !empty($getuserweek->status)?$getuserweek->status:'';
                        $start_time = !empty($getuserweek->start_time)?$getuserweek->start_time:'';
                        $end_time = !empty($getuserweek->end_time)?$getuserweek->end_time:'';
                        @endphp
                        <tr>
                           <td>
                              {{ !empty($row->name)?$row->name:'' }}
                           </td>
                           <td>
                              <input type="hidden" value="{{ $row->id }}" name="week[{{ $row->id }}][week_id]">
                              <label class="switch">
                              <input name="week[{{ $row->id }}][status]" class="change-availability" id="{{ $row->id }}"  type="checkbox" {{ !empty($open_close) ? 'checked' : '' }}>
                              <span class="slider round"></span>
                              </label>
                           </td>
                           <td>
                              <select name="week[{{ $row->id }}][start_time]" class="form-control required-{{ $row->id }} show-availability-{{ $row->id }}"  style="{{ !empty($open_close) ? '' : 'display:none'  }}">
                                 <option value="">Select Start Time </option>
                                 @foreach ($week_time_row as $time_row1)
                                 <option {{ (trim($start_time) == trim($time_row1->name))?'selected':'' }} value="{{ $time_row1->name }}"  >{{ $time_row1->name }}</option>
                                 @endforeach
                              </select>
                           </td>
                           <td>
                              <select name="week[{{ $row->id }}][end_time]" class="form-control required-{{ $row->id }} show-availability-{{ $row->id }}"  style="{{ !empty($open_close) ? '' : 'display:none'  }}">
                                 <option value="">Select End Time </option>
                                 @foreach ($week_time_row as $time_row)
                                 <option {{ (trim($end_time) == trim($time_row->name))?'selected':'' }} value="{{ $time_row->name }}" >{{ $time_row->name }}</option>
                                 @endforeach
                              </select>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <button class="btn btn-primary pull-right">Update</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('js')
<script type="text/javascript">

   $('.change-availability').click(function(){
        var id = $(this).attr('id');
        if(this.checked)
        {
   
           $('.show-availability-'+id).show();
            $('.required-'+id).prop('required',true);
   
        }
        else
        {
           $('.show-availability-'+id).hide();
           $('.required-'+id).prop('required',false);
        }
   
   });

</script>
@endsection
