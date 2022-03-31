<html>
<head>
  <style>
  .container {
    background: rgb(238, 238, 238);
    padding: 80px;
  }
  @media only screen and (max-device-width: 690px) {
    .container {
      background: rgb(238, 238, 238);
      width:100%;
      padding:1px;
    }
  }
  .box {
    background: #fff;
    margin: 0px 0px 30px;
    padding: 8px 20px 20px 20px;
    border:1px solid #e6e6e6;
    box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);
  }
  .lead {
    font-size:16px;
  }
  .btn{
    background:#10C5A7;
    margin-top:20px;
    color:white !important;
    text-decoration:none;
    padding:10px 16px;
    font-size:18px;
    border-radius:3px;
  }
  hr{
    margin-top:20px;
    margin-bottom:20px;
    border:1px solid #eee;
  }
  .table {
    width:100%;
    background-color:#fff;
    margin-bottom:20px;
  }
  .table thead tr th {
    border:1px solid #ddd;
    font-weight:bolder;
    padding:10px;
    color:#74787e;
  }
  .table tbody tr td {
    border:1px solid #ddd;
    padding:10px;
    color:#74787e;
  }
  .bg-gray {
    color:#74787e;
  }
  .regards{
    color:#74787e;
    text-align:left;
  }
  .footer {
  box-sizing:border-box;
  line-height:1.5em;
  margin-top:0;
  color:#aeaeae;
  font-size:12px;
  text-align:center;
  }
  </style>
</head>
<body class='is-responsive'>
  <div class='container'>
    <div class='box'>
      <center>
        <img src='https://localhost:8000/assets/images/logo.png' width='30% ' style="padding: 26px;" >
        <!-- <h2> New Agreement Available. </h2> -->
      </center>
      <hr>
      <p class='bg-gray'> Dear {{$user->username}} , </p>
      <p class="bg-gray">Click the below link to change password.</p>
      <br><br>
      <center>
        <a style="background-color: #ed1c24; border-radius: 35px;margin-top: 4rem;" href="{{ url('/reset-password/'.$user->email.'/'.$user->remember_token) }}" class='btn pt-2'>
          Click To Reset Password
        </a>
      </center>
      <br><br><br>
      <p class="regards" style="margin-top: 4rem;">Regards,<br>961Freelancer</p>
      <br>
      <hr>
      <p class="footer">© 2021 961Freelancer All rights reserved.</p>
  </div>
</div>
</body>
</html>
