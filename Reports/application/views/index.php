<!DOCTYPE html>

<html lang="en">



<head>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Reliable Diagnostics</title>

  <link rel="icon" href="<?php echo base_url(); ?>assets/images/fulllogo_nobuffer.png" type="image/jpg">

  <link rel="stylesheet" href="style.css">



  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

  <!-- <script src="https://code.jquery.com/jquery-3.1.1.js"></script>  -->

  <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->



  <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

  <!-- <link href="https://bootswatch.com/darkly/bootstrap.min.css" rel="stylesheet" type="text/css"> -->

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jm.spinner.css">



  <style>
    body {

      background-image: url(assets/images/pexels-scott-webb-305821.png);

      background-size: 110%;

      background-position: center;

      background-repeat: no-repeat;

      background-color: currentcolor;

    }



    .logo {
      margin: 6px -8px 8px 0px;
    }



    /* #b#boxox {

      padding: 20px;

      border: 2px solid white;

      background-color: #ffffff;

      border-radius: 10px;

      width: 500px;

      height: 500px;

      display: flex;

      flex-direction: column;

      align-items: center;

      margin: 165px auto;

      justify-content: center;

    } */



    form {

      display: flex;

      flex-direction: column;

      align-items: center;

    }





    /* .container img {

      background-size: cover;

      max-width: fit-content;

    } */

    #btn {

      position: absolute;

      right: 40px;

      top: 30px;

      width: 150px;

      padding: 10px;



    }





    .form-control {

      width: 240px;

    }
  </style>

</head>



<body>

  <div class="container1 bag">

    <!-- <div class="wrapper"><button onclick="window.location.href='quickbook'" type="button" class="btn btn-secondary" id="btn">Quick Book</button></div> -->





    <!-- <img src="assets\images\themicro5.jpg" class="img-fluid img-responsive" alt="Vital Smart Lab"> -->

    <div class="container drive" id="box">



      <div class="container text-center">

        <img class="logo img-responsive" src="<?php echo base_url(); ?>assets/images/fulllogo_nobuffer.png" />

      </div>

      <div class="container">

        <div class="row">

          <div class="col-lg-12">

            <form class="row g-3">

              <div class="col-auto">

                <label for="staticEmail2" class="visually-hidden">Username</label>

                <input type="text" class="form-control" id="staticuser" placeholder="Username" />

              </div>

              <div class="col-auto">

                <label for="inputPassword2" class="visually-hidden">Password</label>

                <input type="password" class="form-control" id="inputPassword" placeholder="Password" />

              </div>

              <div class="col-auto ">

                <button type="button" onclick="GlobalLogin()" class="btn btn-primary mb-3 center" style="align-item:center; margin-top: 10px">

                  Login

                </button>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

</body>

<!-- <script src="<?php echo base_url(); ?>js/common.js"></script> -->



<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->

<script src="<?php echo base_url(); ?>assets/js/jm.spinner.js"></script>

<script>
  function GlobalLogin() {



    var objUserData = {

      UserName: $('#staticuser').val(),

      Password: $('#inputPassword').val(),

      Task: 3,

      AppID: "4bee96ca-3ea8-4e89-a575-04d2beed400c"

    };

    $.ajax({

      cache: false,

      type: "POST",

      url: 'login', // 'https://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/UserRegistration',

      data: objUserData,

      success: function(objresult) {

        if (objresult) {
          objresult = JSON.parse(objresult);
          var objres = objresult.d;

          if (objres) {

            if (objres.Result == 'Success') {

              localStorage.setItem("smartlabRes", JSON.stringify(objres));

              window.location.href = 'reports';

            } else {

              alert("Something wrong!!!")

            }

          }

        } else {

          console.log('Error To retrive Data');

        }

      },

      error: function(result) {



      }

    });

  }
</script>



</html>