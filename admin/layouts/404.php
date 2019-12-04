<?php
header("HTTP/1.0 404 Not Found");
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Page Not Found</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">

  <!-- Custom stlylesheet -->
  <style>
    * {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
    }

    body {
      padding: 0;
      margin: 0;
    }

    #notfound {
      position: relative;
      height: 100vh;
    }

    #notfound .notfound {
      position: absolute;
      left: 50%;
      top: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
    }

    .notfound {
      max-width: 520px;
      width: 100%;
      line-height: 1.4;
      text-align: center;
    }

    .notfound .notfound-404 {
      position: relative;
      height: 240px;
    }

    .notfound .notfound-404 h1 {
      font-family: 'Montserrat', sans-serif;
      position: absolute;
      left: 50%;
      top: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      font-size: 252px;
      font-weight: 900;
      margin: 0px;
      color: #6F42C2;
      /* background: linear-gradient(to right, #8914fe 0%, #8063f5 100%);
  -webkit-background-clip: text;
      -ms-background-clip: text;
          background-clip: text;
  -webkit-text-fill-color: transparent; */
      text-transform: uppercase;
      letter-spacing: -40px;
      margin-left: -20px;
    }

    .notfound .notfound-404 h1>span {
      text-shadow: -8px 0px 0px #fff;
    }

    .notfound .notfound-404 h3 {
      font-family: 'Cabin', sans-serif;
      position: relative;
      font-size: 16px;
      font-weight: 700;
      text-transform: uppercase;
      color: #262626;
      margin: 0px;
      letter-spacing: 3px;
      padding-left: 6px;
    }

    .notfound h2 {
      font-family: 'Cabin', sans-serif;
      font-size: 20px;
      font-weight: 400;
      text-transform: uppercase;
      color: #000;
      margin-top: 0px;
      margin-bottom: 25px;
    }

    @media only screen and (max-width: 767px) {
      .notfound .notfound-404 {
        height: 200px;
      }

      .notfound .notfound-404 h1 {
        font-size: 200px;
      }
    }

    @media only screen and (max-width: 480px) {
      .notfound .notfound-404 {
        height: 162px;
      }

      .notfound .notfound-404 h1 {
        font-size: 162px;
        height: 150px;
        line-height: 162px;
      }

      .notfound h2 {
        font-size: 16px;
      }
    }
  </style>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>

  <div id="notfound">
    <div class="notfound">
      <div class="notfound-404">
        <h3>Oops! Page not found</h3>
        <h1><span>4</span><span>0</span><span>4</span></h1>
      </div>
      <h2>we are sorry, but the page you requested was not found</h2>
    </div>
  </div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>