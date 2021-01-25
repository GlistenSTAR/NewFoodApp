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
        .container * {
            margin-top:20px;
        }
        /* .card *{
            margin-left:10px;
            margin-right:10px;
        } */
        input{
            color:black;
        } 
        button{
            margin-bottom:10px
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row ">
            <div class="col-md-3"></div>
            <div class="col-md-6 " >
                <div class="card" style="margin-top:20px">
                    <div class="container">
                        <h2 align="center" style="margin-top:40px">{{Session::get('name')}}: Confirm your details</h2>
                        <a href="javascript:history.back()"><p align="center">Return to switch accounts</p></a>

                        <form action="{{url('/stripe-payment')}}">
                        <input class="form-control" input ="test" name="phone" placeholder="Moblie number" value="{{Session::get('phone') ? Session::get('phone'): ''}}">
                        <input class="form-control" input ="test" name="address1" placeholder="Address line1" value="{{Session::get('address1') ? Session::get('address1'): ''}}">
                        <input class="form-control" input ="test" name="address2" placeholder="Address line2(optional)" value="{{Session::get('address2') ? Session::get('address2'): ''}}">
                        <input class="form-control" input ="test" name="city" placeholder="City" value="{{Session::get('city') ? Session::get('city'): ''}}">
                        <input class="form-control" input ="test" name="postcode" placeholder="Postcode" value="{{Session::get('postcode') ? Session::get('postcode'): ''}}">

                        <h4 align="center">Leave a note</h4>
                        <p>Leave a note for the restaurant with anything they need to know. Do not include any details about allergies here.</p>

                        <textarea name="note" style="width:100%;height:150px;resize:none"></textarea>
                        <button align="center" type="submit" class="btn btn-primary btn-block">Go to payment</button>
                        </form>
                    </div>
                </div>
            </div>
              
        </div>
    </div>
</body>