
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" style="text-align:center">Please enter Name and Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
        <script>
          function loginStart(){
            $.ajax({
              url: "/customer/login",
              context: {
                  userN : $('#userN').value,
                  userP : $('#userP').value
              }
            }).done(function() {
              alert("ok");
            }).fail(function(){
              alert("fail");
            })
          }
        </script>
        <form action="{{url('/customer/login')}}" method="post">
          {{ csrf_field() }}
          <div class="form-group">
            <label>User Name:</label>
            <input placeholder="Input Name" class="form-control" type="text" name="userN" id="userN">
          </div>
          <div class="form-group">
            <label>User Password:</label>
            <input placeholder="Input Password" class="form-control" type="text" name="userP" id="userP">
          </div>
          If you haven't signed up yet, please <a data-toggle="modal" data-target="#register" href="#" > <span class="text text-primary register">sign up</span></a>
          
          <div style="margin-left:30%">
            <input type="hidden" name="userR" id="userR" value="{{$restaurant->restaurant_id}}">
            <a class="btn btn-primary" href="javascript:loginStart()" >Login</a>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="register">
  <script>
      function registerStart(){
          $.ajax({
            url: "/customer/register",
            context: {
                email : $('#email').value,
                pass1 : $('#psw').value,
                pass2 : $('#psw-repeat')
            }
          }).done(function() {
            alert("ok");
          }).fail(function(){
            alert("fail");
          })
    </script>
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h4 class="modal-title" style="text-align:center">Please register</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="action_page.php">
          <div class="container-fluid">
            <div class="form-group">
              <label for="email"><b>Email</b></label>
              <input type="text" placeholder="Enter Email" name="email" id="email" required>
            </div>

            <div class="form-group">
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            </div>
            <div class="form-group">
              <label for="psw-repeat"><b>Repeat Password</b></label>
              <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
            </div>
            <hr>
            <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
            <button type="button" onclick="registerStart()" class="registerbtn">Register</button>
          </div>

          <div class="container signin">
            <p>Already have an account? <a data-target="#myModal" data-toggle="modal" href="#">Sign in</a>.</p>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>