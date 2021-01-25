<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Food App</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="stylesheet" type="text/css" id="theme" href="{{ url('public/files/css/theme-default.css') }}"/>
      <style>
         .error p
         {
         color: #ff0033;
         }
         .error
         {
         color: #ff0033 !important;
         }
         .page-content{
          font-size: 15px;
         }
      </style>
        @yield('style')
   </head>
   <body>
      <div class="page-container">
         @include('admin.layout._sidebar')
         <!-- START PAGE SIDEBAR -->
         <!-- END PAGE SIDEBAR -->
         <!-- PAGE CONTENT -->
         <div class="page-content">
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
               <!-- TOGGLE NAVIGATION -->
               <li class="xn-icon-button">
                  <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
               </li>
               <!-- END TOGGLE NAVIGATION -->
               <!-- SIGN OUT -->
               <li class="xn-icon-button pull-right">
                  <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
               </li>
               <li class="xn-icon-button pull-right">
                  <div style="margin-top: 16px;color: #fff;font-size: 14px;margin-right: 12px;">Welcome {{ Auth::user()->name }}</div>
               </li>
               <!--END SIGN OUT -->
            </ul>
            <!-- MESSAGE BOX-->
            <div class="message-box animated fadeIn"  id="mb-signout">
               <div class="mb-container">
                  <div class="mb-middle">
                     <div class="mb-title"><span class="fa fa-sign-out"></span> Log Out?</div>
                     <div class="mb-content">
                        <p>Are you sure you want to log out?</p>
                     </div>
                     <div class="mb-footer">
                        <div class="pull-right">
                           <a href="{{ url('admin/logout') }}" class="btn btn-success btn-lg">Yes</a>
                           <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @yield('content')
            <!-- END PAGE CONTENT WRAPPER -->
         </div>
         <!-- END PAGE CONTENT -->
      </div>
      <!-- START SCRIPTS -->
      <!-- START PLUGINS -->
      <script type="text/javascript" src="{{ url('public/files/js/plugins/jquery/jquery.min.js') }}"></script>
      <script type="text/javascript" src="{{ url('public/files/js/plugins/jquery/jquery-ui.min.js') }}"></script>
      <script type="text/javascript" src="{{ url('public/files/js/plugins/bootstrap/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ url('public/files/tinymce/tinymce.min.js') }}"></script>
      <!-- END PLUGINS -->
      <!-- START TEMPLATE -->
      <script type="text/javascript" src="{{ url('public/files/js/plugins.js') }}"></script>
      <script type="text/javascript" src="{{ url('public/files/js/actions.js') }}"></script>
      <!-- END TEMPLATE -->
         @yield('js')
      <!-- END SCRIPTS -->
<script type="text/javascript">
  tinymce.init({
        selector:'.editor',
        plugins:'link code image textcolor advlist',
        toolbar: [
        "fontselect | bullist numlist outdent indent | fontsizeselect | undo redo | styleselect | bold italic | link image",
        "alignleft aligncenter alignright Justify | forecolor backcolor",
        "fullscreen"
        ],
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
    });



  $('.changeStatus').change(function(){
      var status_id = $(this).val();
      var order_id = $(this).attr('id');
       $.ajax({
             type:'GET',
             url:"{{url('admin/changeStatus')}}",
             data: {status_id: status_id,order_id:order_id},
             dataType: 'JSON',
             success:function(data){
                alert('Status successfully changed.');
             }
      });
  });








</script>
   </body>
</html>