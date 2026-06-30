<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

  <title>Reliable Diagnostics</title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/images/logo smart lab.JPG" type="image/jpg">
  <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/style.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="https://jquery.app/jqueryscripttop.css" rel="stylesheet" type="text/css">
  <!-- <link href="https://bootswatch.com/darkly/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jm.spinner.css">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous" />
  <style>
    * {
      box-sizing: border-box;
      font-size: large;

    }

    form {
      width: 100%;
    }

    ::placeholder {
      color: gray;

    }

    input {
      background-color: #bfbbcb;
    }

    .form-board {
      background-color: white;
      display: block;
      margin: 0px auto;
      width: 80%;
      border: 2px solid lightgray;
      padding: 20px;
      border-radius: 20px;
      z-index: 10;
    }

    #testprofilesearchresult {
      height: 200px;
    }

    .availableDataSelection,
    .testprofilesearchSelected {
      height: 200px;
      overflow: scroll;
    }

    .logo {
      position: relative;

      height: 100%;

    }

    #img1 #img2 {
      z-index: -5;
      opacity: .5;
      height: auto;
    }

    .form-board label {
      font-weight: 500;
    }

    .alax {
      width: 100%;
      height: 100%;
      background-image: url("assets/images/banner1-1-scaled.jpg");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .welcome-note {
      display: inline-block;
      width: auto;
      margin: auto;
    }



    @media (min-width: 1220px) {
      .alax {
        width: 100%;
        height: 100%;
      }

      .logo {
        right: -100px;
      }

      .form-board {
        position: relative;
        top: -80px;
      }
    }
  </style>
</head>

<body>

  <div class="alax">
    <div class="welcome-note" style="border: none;">
      <!-- <div class="logoutdiv">
        <button id="btnLogout" type="button" class="btn btn-outline-primary mx-auto">
          Logout
        </button>
        <a style="margin-left: 10px;" href="<?php echo base_url(); ?>reports">
          Reports
        </a>
      </div> -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <center>
          <img class="logo img-responsive" src="<?php base_url(); ?>assets/images/transperent_logo.png">
        </center>


      </div>
      <div class="col-md-6">
        <form action="javascript:BookAppointment()" method="post">
          <!-- <center>
        <img class="logo img-responsive" src="<?php base_url(); ?>assets/images/logo smart lab.JPG">
      </center> -->

          <div class="form-board">
            <div class="">
              <label for="formGroupExampleInput" class="form-label">Name : </label>
              <input type="text" class="form-control" id="formGroupNameInput" placeholder="Enter your name" required />
            </div>
            <div class="">
              <label for="formGroupExampleInput2" class="form-label">Mobile No. : </label>
              <input type="text" class="form-control" id="formGroupMobileInput" placeholder="Enter your Mobile No." maxlength="10" required />
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="">
                  <label for="formGroupExampleInput3" class="form-label">Date : </label>
                  <input type="date" class="form-control" value="" min="1890-01-01" id="formGroupDateInput" placeholder="Date" required />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="">
                  <label for="formGroupExampleInput3" class="form-label">Time : </label>
                  <input type="time" class="form-control" value="" id="formGroupTimeInput" placeholder="" required />
                </div>
              </div>
            </div>
            <div class="">
              <label for="formGroupExampleInput3" class="form-label">Centre : </label>
              <select class="form-select" aria-label="Default select example" id="cc">
                <option value="1046" selected="selected">Smart Lab</option>
              </select>
            </div>
            <!-- i started here  -->
            <div class="">
              <label for="formGroupExampleInput3" class="form-label">Sample Collection : </label>
              <select class="form-select" name="form_select" onchange="showDiv(this)">
                <option value="2">Onsite Collection</option>
                <option value="1">Home Collection</option>
              </select>
            </div>


            <div id="homecollection" style="display:none">
              <label for="homecollection">Enter Address</label>
              <div>
                <!-- <input type="textarea" class="form-control" name="homecollection" placeholder="Address" /> -->
                <textarea name="homecollection" id="homecollection" rows="4" style="width:100%" required="required"></textarea>
              </div>
            </div>

            <div id="onsitecollection" style="display:none">
              <label for="onsitecollection">Onsite Collection : </label>
              <div class="onsitecollection">
                <select class="form-select" name="onsitecollection" id="selevtonsite" onchange="getval(this);" required="required">
                  <option value="">Select</option>
                  <option value="OnSite - Vital 3T-MRI/CT Andheri">Vital 3T-MRI/CT Andheri</option>
                  <option value="OnSite - Andheri (W)">Andheri (W)</option>
                  <option value="OnSite - Goregaon (W)">Goregaon (W)</option>
                  <option value="OnSite - Bhayandar (W)">Bhayandar (W)</option>
                  <option value="OnSite - Mira Road (E)">Mira Road (E)</option>
                </select>
              </div>
            </div>


            <div class="center" style="text-align: center; margin-top: 10px;">
              <button onclick="BookAppointment()" type="submit" class="btn btn-outline-primary mx-auto">
                Submit
              </button>
            </div>
          </div>
        </form>

      </div>
      <!-- <div class="col-md-6">
        <center>
          <img class="logo img-responsive" src="<?php base_url(); ?>assets/images/transperent_logo.png">
        </center>


      </div> -->
    </div>

    <div class="modal"></div>







  </div>
</body>
<script src="<?php echo base_url(); ?>assets/js/jm.spinner.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>js/common.js"></script> -->
<script>
  function showDiv(select) {
    if (select.value == 1) {
      document.getElementById('homecollection').style.display = "block";
      document.getElementById('onsitecollection').style.display = "none";
    }
    if (select.value == 2) {
      document.getElementById('homecollection').style.display = "none";
      document.getElementById('onsitecollection').style.display = "block";
    }


  }
  let department;
  let affiliationID = "";
  let AffiliationName = "";
  let PatientAddress = "";
  let SelectedProfiles = "";

  function getval(sel) {
    PatientAddress = sel.value;
  }

  function BookAppointment() {

    cc = ''
    var valueSelected = $("#cc option:selected").val();
    var URL = window.location.href;

    var name = $("#formGroupNameInput").val();
    var mobile = $("#formGroupMobileInput").val();
    var date = $("#formGroupDateInput").val();
    if (PatientAddress == "") {
      PatientAddress = $("#homecollection").val();
    }

    var today = new Date();
    var time = $("#formGroupTimeInput").val();
    date = date + " " + time + ":00"
    var name = $("#formGroupNameInput").val();

    var obj = {
      "schedule": {
        ID: 0,
        Config_MachineID: 1025,
        TestRegnID: 0,
        PatientID: 0,
        StrAppointmentFrom: date,
        StrAppointmentTo: date,
        Status: 0,
        PatientName: name,
        Telmob: mobile,
        CollectionCenterID: parseInt(valueSelected),
        CollectionCenterName: "",
        //        AffiliationID: affiliationID == "" ? 0 : affiliationID,
        //        AffiliationName: AffiliationName == "" ? "" : AffiliationName,
        PatientAddress: PatientAddress == "" ? "" : PatientAddress,
        SelectedProfiles: SelectedProfiles == "" ? "" : SelectedProfiles
      },
      "Lab": "dccd4cf3-d5ce-407c-925b-ff5b2abb65b3"
    }

    $.ajax({
      cache: false,
      type: "POST",
      url: "https://app.vitalimaging.co.in/Services/UserService.svc/CreateOrUpdate",
      data: JSON.stringify(obj),
      dataType: "json",
      contentType: "application/json; charset=utf-8",
      beforeSend: function() {
        // $('.box').jmspinner('large');
        var body = $(".modal");
        $(body).show();
      },
      success: function(object) {

        var ob = object.d;
        if (ob == "1") {
          alert("Appointment Booked Successfully !!");
        } else {
          alert("Appointment Failed ! please Contact SmartLab");
        }
        window.location.reload();
      },
      completed: function() {
        // $('.box').jmspinner(false);
        var body = $(".modal");
        $(body).hide();
      },
    });
  }


  $(document).ready(function() {
    document.getElementById('homecollection').style.display = "none";
    document.getElementById('onsitecollection').style.display = "block";

    // $.ajax({
    //   cache: false,
    //   type: "GET",
    //   url: "http://devglobal.elabassist.com/Services/GlobalUserService.svc/GetAffiliationList?labid=dccd4cf3-d5ce-407c-925b-ff5b2abb65b3",
    //   dataType: "json",
    //   contentType: "application/json; charset=utf-8",
    //   // beforeSend: function() {
    //   //   // $('.box').jmspinner('large');
    //   //   var body = $(".modal");
    //   //   $(body).show();
    //   // },
    //   success: function(object) {

    //     var ob = object.d;
    //     html = '<option value="">select</option>';
    //     if (ob) {
    //       localStorage.setItem("SmartLabAffiliation", JSON.stringify(ob));
    //       ob.forEach(element => {
    //         html += '<option value="' + element.AffiliationID + '" name="' + element.AffiliationCompanyName + '">' + element.AffiliationCompanyName + '</option>'
    //       });
    //       $('#selevtonsite').html(html);
    //     }
    //   },
    //   // completed: function() {
    //   //   // $('.box').jmspinner(false);
    //   //   var body = $(".modal");
    //   //   $(body).hide();
    //   // },
    // });

  });

  // upto here 
</script>


</html>