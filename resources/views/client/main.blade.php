
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supa Food Server</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href= {{ asset('public/css/main.css') }} rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


    <style>

      @media only screen and (max-width: 900px) {
        #Sidenav1{
          width:0;
        }
      }

      @media only screen and (min-width: 900px) {
        #Sidenav1{
          width:280px;
        }
      }

      @media only screen and (max-width: 1100px) {
        #Sidenav2{
          width:0;
        }
      }

      @media only screen and (min-width: 1100px) {
        #Sidenav2{
          width:320px;
        }
      }

      body {
        font-family: "Lato", sans-serif;
      }

      #Sidenav1{
        left:0;
      }
      
      #Sidenav2{
        right:0;
      }

      .sidenav {
        height: 100%;
        border-color:#000000;
        border-width:2px;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        background-color: rgb(238, 238, 238);
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        
      }
      
      .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 18px;
        color: #000000;
        display: block;
        transition: 0.3s;
      }
      
      .sidenav a:hover {
        color: #251515;
      }
      
      .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
      }

    #navbar {
      align-content: center;
      overflow: hidden;
      background-color: rgb(59, 48, 48);
      padding-left:30%;
    }

    #navbar a {
      float: left;
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px;
      text-decoration: none;
    }

    .content {
      padding: 16px;
    }

    .sticky {
      position: fixed;
      top: 0;
      width: 100%;
    }

    .sticky + .content {
      padding-top: 60px;
    }

    .container{
      width:50%;
      margin-bottom: 30px;
    }

    #Sidenav2{
      cursor:default;
    }

    #purchaseTable{
      cursor:default;
    }
    table{
      margin-top:20px;
    }

    .loginnav{
      cursor: pointer;
    }
#snackbar {
  visibility: hidden; /* Hidden by default. Visible on click */
  min-width: 250px; /* Set a default minimum width */
  margin-left: -125px; /* Divide value of min-width by 2 */
  background-color: #333; /* Black background color */
  color: #fff; /* White text color */
  text-align: center; /* Centered text */
  border-radius: 2px; /* Rounded borders */
  padding: 16px; /* Padding */
  position: fixed; /* Sit on top of the screen */
  z-index: 1; /* Add a z-index if needed */
  left: 50%; /* Center the snackbar */
  bottom: 30px; /* 30px from the bottom */
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#snackbar.show {
  visibility: visible; /* Show the snackbar */
  /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
  However, delay the fade out process for 2.5 seconds */
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

/* Animations to fade the snackbar in and out */
@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
   
      
    </style>
</head>
<body onload="myFunction()">
  <div id="snackbar" class="hide">{{ Session::has('message') ? Session::get('message') : "" }}</div>
  
    <header>
        <img src="{{url('public/img/header.jpg')}}" alt="Nature" class="responsive">
        
        <div class="main_content">
          {{-- @if ($restaurant->logo != "")
            <img src="{{$restaurant->logo}}" heigth="70%">
          @endif --}}
          <h1>{{$restaurant->name}}</h1>
          <p>{{$restaurant->address_one}} {{$restaurant->address_two}} {{$restaurant->city}}</p>
        </div>    
    </header>

    <button type="button" style="display:none" id ="optionButton" class="btn btn-primary" data-toggle="modal" data-target="#OptionModal"></button>
    <div class="modal fade" id="OptionModal" >
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div>
            <button type="button" style="margin:10px 10px" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div align="center"  class="text-center modal-header">
            <h2 align="center" style="font-weight:500;margin:auto" class="modal-title"></h2>
          </div>
          <div class="modal-body">
            <p align="center" class="modal-price"></p>
            <p align="center" class="modal-desc"></p>
            <p align="left" style="font-weight:800">Please Choose One from beneath</p>
            

            <table class="table table-striped table-hover">
              <thead align="center">
                <tr class="table-active">
                  <td>Option</td>
                  <td>Price</td>
                  <td>Add</td>
                </tr>
              </thead>
              <tbody align="center">
                
              </tbody>
            </table>
          </div>
          {{-- <div>
            <button style="height:60px;font-size:20px" class="btn btn-primary btn-block">Add to Order</button>
          </div> --}}
        </div>
      </div>

    </div>

    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" style="text-align:center">Please enter Phone Number and Password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{url('login')}}" method="post">
              {{ csrf_field() }}
              
              <div class="form-group">
                <label>Phone Number:</label>
                <input placeholder="Input Phone Number" class="form-control" type="text" name="phone" id="phone" required>
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input placeholder="Input Password" class="form-control" type="password" name="password" id="password" required>
              </div>
              <div align="center">
                If you haven't signed up yet, please <a data-toggle="modal" data-target="#register"><span style="cursor:pointer"class="text text-primary register">sign up</span></a>
              </div>
              <div align="center" class="mt-3">
                <input type="hidden" name="userR" id="userR" value="{{$restaurant->restaurant_id}}">
                <button class="btn btn-primary" type="submit">Login</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="register">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" style="text-align:center">Please register</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{ route('register')}}" method="POST">
              {{ csrf_field() }}
              <div class="container-fluid">
                <div class="form-group">
                  <label><b>Username</b></label>
                  <input placeholder="Enter Username" class="form-control" type="text" name="username"  required>
                </div>
                <div class="form-group">
                  <label for="email"><b>Phone Number</b></label>
                  <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone" id="phone" required>
                </div>
                <div class="form-group">
                  <label for="psw"><b>Password</b></label>
                  <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" required>
                </div>
                <div class="form-group">
                  <label for="psw-repeat"><b>Repeat Password</b></label>
                  <input type="password" class="form-control" placeholder="Repeat Password" name="password_confirmation" id="password_confirmation" required>
                </div>
                <div class="button-group" align="center">
                  <button type="submit" class="btn btn-primary registerbtn">Register</button>
                  <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>.  
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalProfile">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" style="text-align:center">Please Edit Profile</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="{{ route('register2')}}" method="POST">
              {{ csrf_field() }}
              <div class="container-fluid">
                <div class="form-group">
                  <label for="name"><b>Name</b></label>
                  <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{ Session::has('name') ? Session::get('name') : ''}}">
                </div>
                <div class="form-group">
                  <label for="email"><b>Email</b></label>
                  <input type="text" class="form-control" placeholder="Enter Email" name="email" value="{{ Session::has('e-mail') ? Session::get('e-mail') : ''}}">
                </div>
                <div class="form-group">
                  <label for="email"><b>Address 1</b></label>
                  <input type="text" class="form-control" placeholder="Enter your address 1" name="address1" value="{{ Session::has('address1') ? Session::get('address1') : ''}}">
                </div>
                <div class="form-group">
                  <label ><b>Address 2</b></label>
                  <input type="text" class="form-control" placeholder="Enter your address 2" name="address2" value="{{ Session::has('address2') ? Session::get('address2') : ''}}">
                </div>
                <div class="form-group">
                  <label ><b>City</b></label>
                  <input type="text" class="form-control" placeholder="Enter City Name" name="city" value="{{ Session::has('city') ? Session::get('city') : ''}}">
                </div>
                <div class="form-group">
                  <label ><b>Postal Code</b></label>
                  <input type="text" class="form-control" placeholder="Enter Postal Code" name="postcode" value="{{ Session::has('postcode') ? Session::get('postcode') : ''}}">
                </div>
                <div class="button-group" align="center">
                  <button type="submit" class="btn btn-primary registerbtn">Ok</button>
                  <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>.  
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="navbar">
      <a href="javascript:openNav()">Restaurant Menu</a>
      <a href="javascript:openNav2()">Order Menu</a>   
      @if(!empty(session('userid')))
      <a href="">Previous Orders</a>
      <a class="loginnav" data-toggle="modal" data-target="#modalProfile" >Profile</a>
      @endif
      @if(!empty(session('userid')))
      <a class="loginnav" id="logoutButton" href="{{route('logout')}}" >Signout</a>
      @else
      <a class="loginnav" data-toggle="modal" data-target="#myModal">
        Login
      </a>
      @endif
    </div>


    <div id="Sidenav1" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      @foreach ($category as $cat)
        <a href="{{url('/customer').'/'.$cat->user_id.'/'.$cat->category_order_by}}" class="w3-bar-item w3-button "> {{$cat->name}}</a>
      @endforeach
    </div>

    <div id="Sidenav2" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav2()">&times;</a>
        <h2 style="color:chocolate" align="center">Your Order</h2>
      
      <div class="container-fluid" style="margin-top:10px;margin-bottom:10px">
      <div class="row">
        <div class="col-1"></div>
        <div class="col-5">
        <input type="radio" style="display:inline-block;float:left" class="form-check-inline" id="delivery" name="delivery_method" value="delivery" checked>Delivery
        </div>
        <div class="col-5">
        <input type="radio" style="display:inline-block;float:left"  class="form-check-inline" id="collection" name="delivery_method" value="collection">Collection
        </div>
        <div class="col-1"></div>
      </div>
      </div>

      

        <table class="table">
          <tbody align="center">
            <tr>
              <td>Subtotal</td>
              <td></td>
            </tr>
            <tr>
              <td>10% Discount</td>
              <td ></td>
            </tr>
            <tr>
              <td>Delivery Fee</td>
              <td > 0</td>
            </tr>
            <tr>
              <td><b>Total</b></td>
              <td id="totPrice"></td>
            </tr>
          </tbody>
        </table>
      <a  href="{{url('/confirm-payment')}}"  }}><button class="btn btn-primary btn-block" {{ !empty(session('userid')) ? '' : 'disabled' }} id="buycart"><i class="fa fa-credit-card"></i> Go to Payment</button></a>

      <div >  
        <table style="margin-top:20px" class="table" id="purchaseTable">
          <thead align="center">
            <tr class="table-active">
              <td>Item</td>
              <td>Quantity</td>
              <td>Price</td>
              <td>Cancel</td>
            </tr>
          </thead>
          <tbody align="center" id="listbody">
          </tbody>
        </table>
      </div>
    </div>
    
      <div class="container">
        <table class="table table-striped table-hover">
          <thead align="center">
            <tr class="table-active" style="font-weight:600;font-size:20px">
              <td>Item</td>
              <td>Price From</td>
              <td>Description</td>
              <td>Into Cart</td>
            </tr>
          </thead>
          <tbody align="center">
            @foreach($items as $item)
            <tr>
              <td class="itemName" style="font-weight:600" itemID="{{$item->id}}" itemOpt="{{$item->options}}"  >{{$item->item_name}}</td>
              <td class="itemPrice">${{$item->price}}</td>
              <td class="itemDesc">{{$item->item_description}}</td>
              @if ($item['options'] =="[]")
              <td><div><button class="addcart btn btn-success"  name="{{$item->item_name}}"><i class="fas fa-arrow-right"></i></button></div>
              </td>
              @else
              <td><div><button class="openplus btn btn-primary"  name="{{$item->item_name}}"><i class="fas fa-plus"></i></button></div>
              </td>
              @endif
            </tr>
           @endforeach
          </tbody>
        </table>
      </div> 
      {{-- <button onclick="myFunction()">Show Snackbar</button> --}}


    <script>
      function openNav() {
        document.getElementById("Sidenav1").style.width = "280px";
      }
      
      function closeNav() {
        document.getElementById("Sidenav1").style.width = "0";
      }
      function openNav2() {
        document.getElementById("Sidenav2").style.width = "320px";
      }
      
      function closeNav2() {
        document.getElementById("Sidenav2").style.width = "0";
      }
      window.onscroll = function() {myFunction()};

      var navbar = document.getElementById("navbar");

      var sticky = navbar.offsetTop;

      function myFunction() {
        if (window.pageYOffset >= sticky) {
          navbar.classList.add("sticky")
        } else {
          navbar.classList.remove("sticky");
        }
      }
    </script>

  <script>
      $(document).ready(function(){    

        let restaurantID = {{ $restaurant->restaurant_id }};
        sessionStorage.setItem("restaurantID",restaurantID);

        let userID = {{ !empty(session('userid')) ? session('userid') : 202 }};
        sessionStorage.setItem("userID",userID);

        let itemID;
        let itemN;
        let itemP;      
        let itemQ;        
        let newItem;
        let Newpur;  
        let purItem;
        let totPrice = 0;

        let Mypur = [];
        
        if (sessionStorage.getItem("MyPurchase")) Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));

        if(totPrice > 0){
          $("#buycart").attr('dsabled','false');
        } else {
          $("#buycart").attr('dsabled','true');
        }

        if(Mypur != null){
          Mypur.forEach(item=>{
            if(item){
              $("#listbody").append(`<tr><td class="itemNorm">${item.itemN}</td><td class="itemQuan">${item.itemQ}</td><td class="itemP">$${item.itemP}</td><td><button class="delitem btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
                totPrice += parseFloat(item.itemP);
            }
          });
          $("#totPrice").text("$"+totPrice.toFixed(2));
          sessionStorage.setItem("total",totPrice.toFixed(2));
        }

        $(".delitem").click(function(){
          itemN = $(this).parent().parent().find(".itemNorm").text();
          if (sessionStorage.getItem("MyPurchase")) Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
          Mypur.forEach((item,index)=>{
            if(item!=null){
              if(item.itemN == itemN){
                delete Mypur[index];
                totPrice -= item.itemP;
                if(totPrice == 0){
                    $("#buycart").attr('dsabled','true');
                  }
                $("#totPrice").text("$"+totPrice.toFixed(2));
                sessionStorage.setItem("total",totPrice.toFixed(2));
              }
            }
          });

          Newpur = [];
          for(let i=0;i<Mypur.length;i++){
            if(Mypur[i]){
              Newpur.push(Mypur[i]);
            }
          }

          sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
          $(this).parent().parent().remove();
          
        });

        $(".openplus").click(function(){

          itemID = $(this).parent().parent().parent().find(".itemName").attr("itemID");
          itemN = $(this).parent().parent().parent().find(".itemName").text();
          itemDesc = $(this).parent().parent().parent().find(".itemDesc").text();
          itemP = parseFloat($(this).parent().parent().parent().find(".itemPrice").text().slice(1));      
          itemQ = 1;    

          opt = $(this).parent().parent().parent().find(".itemName").attr("itemOpt");
          itemOpt = JSON.parse(opt);

          // console.log(itemOpt);
          
          $("#optionButton").click();
          $("#OptionModal").find(".modal-title").text(itemN);
          $("#OptionModal").find(".modal-desc").text(itemDesc);
          $("#OptionModal").find(".modal-price").text("from $"+itemP);

          // console.log(itemOpt.length);
          $("#OptionModal").find("tbody").empty();
          $("#OptionModal").find("tbody").append(
              `<tr><td>Normal</td><td>$${(itemP).toFixed(2)}</td>
                <td><button itemID =${(itemID)} itemN =${(itemN)} itemDesc =${(itemDesc)} itemP =${(itemP)} class="addcart2 btn btn-success" data-dismiss="modal" option_id="0" name=""><i class="fas fa-arrow-right" ></i></button></td></tr>`
            );
          
          for(let i=0;i<itemOpt.length;i++){
            
            $("#OptionModal").find("tbody").append(
              `<tr><td>${itemOpt[i].option_name}</td><td class="price">$${(Number(itemOpt[i].option_price)+Number(itemP)).toFixed(2)}</td>
                <td><button option_name=${itemOpt[i].option_name}  itemID =${(itemID)} itemN =${(itemN)}  class="addcart2 btn btn-success" data-dismiss="modal" option_id="${itemOpt[i].id}" ><i class="fas fa-arrow-right" ></i></button></td></tr>`
            );
          }     
        });

        
        $(".addcart").click(function(){          

          itemID = $(this).parent().parent().parent().find(".itemName").attr("itemID");
          itemN = $(this).parent().parent().parent().find(".itemName").text();
          itemDesc = $(this).parent().parent().parent().find(".itemDesc").text();
          itemP = parseFloat($(this).parent().parent().parent().find(".itemPrice").text().slice(1));      
          itemQ = 1;        
          newItem = 1;  

          // console.log(totPrice);

          totPrice += itemP;

          if(totPrice > 0){
            $("#buycart").attr('dsabled','false');
          }
          $("#totPrice").text("$"+totPrice.toFixed(2));
          sessionStorage.setItem("total",totPrice.toFixed(2));

          purItem = {itemID,itemN,itemP,itemQ};

          // console.log(Mypur);
          if (sessionStorage.getItem("MyPurchase")) Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));

          Newpur = [];
            if(Mypur){
              for(let i=0;i<Mypur.length;i++){
              if(Mypur[i]){
                Newpur.push(Mypur[i]);
              }
            }
            sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
          }
            
          if(Mypur != null){
            Mypur.forEach(item=>{
              if(item){
                if(item.itemN == itemN){
                  newItem = 0;
                  item.itemQ = parseInt(item.itemQ) + 1;
                  itemQ = item.itemQ;
                  item.itemP = (parseFloat(itemP) * itemQ).toFixed(2);
                  itemP = item.itemP;
                }
              }
            });
            if(newItem == 1){
              Mypur.push(purItem);
            }
          }else{
            Mypur = [];
            Mypur.push(purItem);
          }
          sessionStorage.setItem("MyPurchase",JSON.stringify(Mypur));

          $.each($("#listbody").children(), function( index) {
            if($(this).find(".itemNorm").text()==itemN){
              $(this).find(".itemQuan").text(itemQ);
              $(this).find(".itemP").text("$"+itemP);
            }
          });
         
          if(newItem == 1){
            $("#listbody").append(`<tr><td class="itemNorm">${itemN}</td><td class="itemQuan">${itemQ}</td><td class="itemP">$${itemP}</td><td><button class="delitem btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
          }
              
          $(".delitem").click(function(){
            itemN = $(this).parent().parent().find(".itemNorm").text();
            if (sessionStorage.getItem("MyPurchase")) Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
            
            Mypur.forEach((item,index)=>{
              if(item!=null){
                if(item.itemN == itemN){
                  delete Mypur[index];
                  totPrice -= item.itemP;
                  if(totPrice == 0){
                    $("#buycart").attr('dsabled','true');
                  }
                  $("#totPrice").text("$"+totPrice.toFixed(2));
                  sessionStorage.setItem("total",totPrice.toFixed(2));
                }
              }
            });


            Newpur = [];
            for(let i=0;i<Mypur.length;i++){
              if(Mypur[i]){
                Newpur.push(Mypur[i]);
              }
            }


            sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
            $(this).parent().parent().remove();
           
          });

        });

        
        $("#logoutButton").click(function(){

          sessionStorage.setItem("MyPurchase",[]);
          sessionStorage.setItem("total", 0);
          Mypur = [];
          totPrice = 0;
        });

      });

      


      function myFunction() {

        var x = document.getElementById("snackbar");

        if(x.innerHTML != ""){
          x.className = "show";
        }
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }

      $(document).on('click', '.addcart2', function(){

        optionID = $(this).attr('option_id');
        optionN = $(this).attr('option_name');
        itemID = $(this).attr("itemID");
        itemN = $(this).attr("itemN");
        itemP = Number($(this).parent().parent().find(".price").text().slice(1));
        itemQ = 1;   
        newItem = 1;  

        let Mypur = [];
        let Newpur = [];  
        let purItem;
        
        totPrice = Number(sessionStorage.getItem("total"));
        totPrice += itemP;
        $("#totPrice").text("$"+totPrice.toFixed(2));
        sessionStorage.setItem("total",totPrice.toFixed(2));
  
        // purItem = {itemID,itemN,optionID,optionN,itemP,itemQ};

        // if (sessionStorage.getItem("MyPurchase")) Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));

        // if(Mypur != null){
        //   Mypur.forEach(item=>{
        //     if(item){
        //       if(item.itemN == itemN){
        //         newItem = 0;
        //         item.itemQ = parseInt(item.itemQ) + 1;
        //         itemQ = item.itemQ;
        //         item.itemP = (parseFloat(itemP) * itemQ).toFixed(2);
        //         itemP = item.itemP;
        //       }
        //     }
        //   });
        //   if(newItem == 1){
        //     Mypur.push(purItem);
        //   }
        // }else{
        //   Mypur = [];
        //   Mypur.push(purItem);
        // }
        // sessionStorage.setItem("MyPurchase",JSON.stringify(Mypur));
        
        window.location.reload(false);


        // if(Mypur != null){
        //   Mypur.forEach(item=>{
        //     if(item){
        //       if(item.itemN == itemN){
        //         newItem = 0;
        //         item.itemQ = parseInt(item.itemQ) + 1;
        //         itemQ = item.itemQ;
        //         item.itemP = (parseFloat(itemP) * itemQ).toFixed(2);
        //         itemP = item.itemP;
        //       }
        //     }
        //   });
        //   if(newItem == 1){
        //     Mypur.push(purItem);
        //   }
        // }else{
        //   Mypur = [];
        //   Mypur.push(purItem);
        // }
        // sessionStorage.setItem("MyPurchase",JSON.stringify(Mypur));

        // $.each($("#listbody").children(), function( index) {
        //   if($(this).find(".itemNorm").text()==itemN){
        //     $(this).find(".itemQuan").text(itemQ);
        //     $(this).find(".itemP").text("$"+itemP);
        //   }
        // });

        // if(newItem == 1){
        //   $("#listbody").append(`<tr><td class="itemNorm">${itemN}</td><td class="itemQuan">${itemQ}</td><td class="itemP">$${itemP}</td><td><button class="delitem btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
        // }
            
        // $(".delitem").click(function(){
        //   itemN = $(this).parent().parent().find(".itemNorm").text();
        //   if (sessionStorage.getItem("MyPurchase")) Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
          
        //   Mypur.forEach((item,index)=>{
        //     if(item!=null){
        //       if(item.itemN == itemN){
        //         delete Mypur[index];
        //         totPrice -= item.itemP;
        //         if(totPrice == 0){
        //           $("#buycart").attr('dsabled','true');
        //         }
        //         $("#totPrice").text("$"+totPrice.toFixed(2));
        //         sessionStorage.setItem("total",totPrice.toFixed(2));
        //       }
        //     }
        //   });


        //   Newpur = [];
        //   for(let i=0;i<Mypur.length;i++){
        //     if(Mypur[i]){
        //       Newpur.push(Mypur[i]);
        //     }
        //   }


        //   sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
        //   $(this).parent().parent().remove();
        
        // });
      });
          

    </script>
</body>
</html>