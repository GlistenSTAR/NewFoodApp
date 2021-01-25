@extends('admin.layout.app')
@section('content')

<style type="text/css">
   .content-frame-body-left {
      width: 100%;
   }
</style>

<ul class="breadcrumb push-down-0">
   <li><a href="#">Support</a></li>
   <li class="active">Reply</li>
</ul>
<div class="content-frame" >
   <!-- START CONTENT FRAME TOP -->
   <div class="content-frame-top">
      <div class="page-title">
         <h2><a href="{{ url('admin/support') }}"><span class="fa fa-comments"></span> </a>Reply</h2>
      </div>
   </div>
   <!-- END CONTENT FRAME TOP -->
   <!-- START CONTENT FRAME BODY -->
   <div class="content-frame-body content-frame-body-left" style="width: 100%;">

      <div class="messages messages-img">
         <div class="item in">
            <div class="text">
               <div class="heading">
                  <a href="#">{{ !empty($edit->user->name)?$edit->user->name:'' }}</a>
                  <span class="date"> {{ $edit->created_at }}</span>
               </div>
                     <b>Title :</b>   {{ $edit->title }}
                        <br />
                     <b>Description :</b> {{ $edit->description }}
            </div>
         </div>
         
         @foreach ($edit->getsupportreply as $value)

        
         @if(Auth::user()->id == $value->user_id)

         <div class="item">
            <div class="text">
               <div class="heading">
                  <a href="#">{{ !empty($value->user->name)?$value->user->name:'' }}</a>
                  <span class="date">{{ $value->created_at }}</span>
               </div>
               {{ $value->description }}                                 
            </div>
         </div>

         @else 
           <div class="item in">
            <div class="text">
               <div class="heading">
                  <a href="#">{{ !empty($value->user->name)?$edit->user->name:'' }}</a>
                  <span class="date"> {{ $value->created_at }}</span>
               </div>
              {{ $value->description }}    
            </div>
         </div>
         @endif 

         @endforeach
      </div>

      @if(empty($edit->status))
         <div class="panel panel-default push-up-10">
            <div class="panel-body panel-body-search">
               
               <form action="" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="input-group">
                     <div class="input-group-btn">
                        <button class="btn btn-default">Reply Message</button>
                     </div>
                     <input type="text" name="description" required class="form-control" placeholder="Your message..."/>
                     <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">Send</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      @endif
      
   </div>
   <!-- END CONTENT FRAME BODY -->      
</div>
@endsection
