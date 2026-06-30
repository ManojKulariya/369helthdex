<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sage</title>
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
    .container {
      border: 2px solid gray;
      padding: 20px 50px 10px 50px;
      margin-top: 20px;
    }

    #testprofilesearchresult {
      height: 200px;
    }

    .availableDataSelection,
    .testprofilesearchSelected {
      height: 200px;
      overflow: scroll;
    }
  </style>
  <style>
    .logo {
      height: 300px;
      /* width: 100px; */
    }
  </style>
</head>

<body>
  <div class="container" style="border: none;">
    <div class="logoutdiv">
      <button id="btnLogout" type="button" class="btn btn-outline-primary mx-auto">
        Logout
      </button>
      <a style="margin-left: 10px;" href="<?php echo base_url(); ?>reports">
        Reports
      </a>
    </div>

    <h5 style="float: left;" class="userwelcome">Welcome <span style="color: #0093dd"></span> !</h5>
  </div>
  <form action="javascript:BookAppointment()" style="margin-bottom: 20px;">
    <center>
      <img class="logo img-responsive" src="<?php echo base_url(); ?>assets/images/logo smart lab.JPG">
    </center>

    <div class="container">
      <div class="mb-3">
        <label for="formGroupExampleInput" class="form-label">Name:</label>
        <input type="text" class="form-control" id="formGroupNameInput" placeholder="Enter your name" required />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput2" class="form-label">Mobile No.</label>
        <input type="text" class="form-control" id="formGroupMobileInput" placeholder="Enter your Mobile No." maxlength="10" required />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput3" class="form-label">Date:</label>
        <input type="date" class="form-control" value="" min="1890-01-01" max="2030-12-31" id="formGroupDateInput" placeholder="Date" required />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput4" class="form-label">Pin Code:</label>
        <input type="number" class="form-control" id="formGroupPincodeInput" placeholder="Enter regional pin code" maxlength="6" required />
      </div>
      <div class="mb-3">
        <label for="formGroupExampleInput4" class="form-label">Age : </label>
        <input type="number" class="form-control" id="formGroupAgeInput" placeholder="Enter Age" maxlength="6" required />
      </div>
      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" value="0" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            Male
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" value="1" id="flexRadioDefault2" checked>
          <label class="form-check-label" for="flexRadioDefault2">
            Female
          </label>
        </div>
      </div>
      <div class="search">
        <label for="searchitems" class="form-label">Search Tests:</label>
        <div>
          <input id="inputsearch" class="me-2 control" type="search" placeholder="Search test" aria-label="Search" />
        </div>
      </div>
      <div class="container" style="display: grid; grid-gap: 20px">
        <div class="row">
          <div class="col-lg-6" id="testprofilesearchresult">

          </div>
          <div class="col-lg-6" id="testprofilesearchSelected">

          </div>
        </div>
      </div>

      <div class="center" style="text-align: center; margin-top: 10px">
        <button type="submit" class="btn btn-outline-primary mx-auto">
          Submit
        </button>
      </div>
    </div>
  </form>
  <div class="modal"></div>
</body>
<script src="<?php echo base_url(); ?>assets/js/jm.spinner.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>js/common.js"></script> -->
<script>
  $(document).ready(function() {

    var user = JSON.parse(localStorage.getItem("smartlabRes"))
    $('.userwelcome span').text(user.ShortName);
    var profileAndTestArr = [];

    $.ajax({

      cache: false,
      type: "GET",
      url: "http://devglobal.elabassist.com/Services/GlobalUserService.svc/SearchTest",
      data: {
        labid: "dccd4cf3-d5ce-407c-925b-ff5b2abb65b3"
      },
      dataType: "json",
      // contentType: "application/json; charset=utf-8",
      success: function(object) {
        var obj = JSON.stringify(object);
        profileAndTestArr.push(object.d);
        // alert(obj);
        // localStorage.setItem("AllVeinPackages", obj);
        // console.log(profileAndTestArr);

        $.ajax({
          cache: false,
          type: "GET",
          url: "http://devglobal.elabassist.com/Services/GlobalUserService.svc/SearchProfile",
          data: {
            labid: "dccd4cf3-d5ce-407c-925b-ff5b2abb65b3"
          },
          dataType: "json",
          // contentType: "application/json; charset=utf-8",
          success: function(object) {
            var obj = JSON.stringify(object);
            profileAndTestArr.push(object.d);
            // alert(obj);
            // console.log(profileAndTestArr);
            localStorage.setItem("AllSmartLabPackages", JSON.stringify(profileAndTestArr));
          }
        });
      }
    });
  });

  $("#btnLogout").click(function() {
    localStorage.removeItem("AccuSelectedItem");
    localStorage.removeItem("smartlabRes");
    localStorage.removeItem("AllSmartLabPackages");
    window.location.href = "home";
  });

  $(document).ready(function() {
    var res = JSON.parse(localStorage.getItem("smartlabRes"));
    if (res == null) {
      alert("Please Login .")
      window.location.href = "home";
    }
  });
  $('#inputsearch').on('input', function(e) {

    var dd = $('#inputsearch').val()
    // alert("changed + " + dd)
    SearchTest(dd);
  });

  function removeItem(elem) {
    var id = $(elem).attr('id');
    var type = $(elem).attr('name');
    var testname = $(elem).attr('data-value');
    var cartitems = JSON.parse(localStorage.getItem("AccuSelectedItem"));
    $(elem).hide();
    cartitems.forEach(element => {
      if (element.id == id) {
        var index = cartitems.indexOf(element);
        cartitems.splice(index, 1);
      }
    });
    localStorage.setItem("AccuSelectedItem", JSON.stringify(cartitems));
  }

  function getSelItem(elem) {

    var id = $(elem).attr('id');
    var type = $(elem).attr('name');
    var testname = $(elem).attr('data-value');
    var cartitems = JSON.parse(localStorage.getItem("AccuSelectedItem"));
    if (cartitems == null)
      cartitems = [];

    var obj = {
      id: id,
      type: type,
      testname: testname
    }
    cartitems.push(obj);
    localStorage.setItem("AccuSelectedItem", JSON.stringify(cartitems));
    var search_list = '<ul class="availableDataSelection">';

    $.each(cartitems, function(i, val) {
      search_list += '<li onclick="removeItem(this)" data-value="' + val.testname + '" class="searchedTests" id="' + val.id + '" name="' + val.type + '">' + val.testname + '</li>';
    });

    search_list += '</ul>';
    $("#testprofilesearchSelected").html(search_list);

  }

  function SearchTest(elem) {
    var dd = elem;
    var allProfilesAndTests = JSON.parse(localStorage.getItem("AllSmartLabPackages"));
    var search_list1 = new Array();
    var search_list2 = new Array();

    $.each(allProfilesAndTests[0], function(i, val) {

      search_list1.push(val);
    });

    $.each(allProfilesAndTests[1], function(i, val) {

      search_list2.push(val);
    });


    var finalSearchlist = [];
    var temp = [];
    temp = search_list1.filter(el => el.TestName.toLowerCase().includes(dd));
    finalSearchlist.push(temp);
    console.log(finalSearchlist);
    temp = search_list2.filter(el => el.TestProfileName.toLowerCase().includes(dd));
    finalSearchlist.push(temp);

    var search_list = '<ul class="availableDataSelection">';
    $.each(finalSearchlist[0], function(i, val) {
      search_list += '<li onclick="getSelItem(this)" data-value="' + val.TestName + '" class="searchedTests" id="' + val.TestID + '" name="TestType1"><span>TEST : </span>' + val.TestName + '</li>';
    });
    $.each(finalSearchlist[1], function(i, val) {
      search_list += '<li onclick="getSelItem(this)" data-value="' + val.TestProfileName + '" class="searchedProfiles" id="' + val.TestProfileId + '" name="TestType2"><span>PROFILE : </span>' + val.TestProfileName + '</li>';
    });
    search_list += '</ul>';
    $("#testprofilesearchresult").html(search_list);

  }


  function BookAppointment() {
    var labUser = JSON.parse(localStorage.getItem("smartlabRes"));
    var allProfilesAndTests = JSON.parse(localStorage.getItem("AllSmartLabPackages"));
    var SelectedItem = JSON.parse(localStorage.getItem("AccuSelectedItem"));
    var mainTestId = [];
    var mainProfileId = [];
    SelectedItem.forEach(element => {
      if (element.type == "TestType1") {
        mainTestId.push(element.id)
      } else if (element.type == "TestType2") {
        mainProfileId.push(element.id)
      }
    });
    var name = $("#formGroupNameInput").val();
    var mobile = $("#formGroupMobileInput").val();
    var date = $("#formGroupDateInput").val();
    var age = $("#formGroupAgeInput").val();

    var today = new Date();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    date = date + " " + time
    var name = $("#formGroupNameInput").val();

    var gender = $('input[name=gender]:checked').val();
    mainTestId = mainTestId.toString();
    mainProfileId = mainProfileId.toString();

    obj = {
      "LabID": "dccd4cf3-d5ce-407c-925b-ff5b2abb65b3",
      "PatientID": labUser.UserFID,
      "Username": labUser.UserName,
      "SelectedTest": mainTestId,
      "SelectedProfile": mainProfileId,
      "SelectedPopularTest": "",
      "EnteredTest": "",
      "AppointmentDate": date,
      "AppointmentAddress": "",
      "RefDocID": "0",
      "RefDocName": "SELF",
      "RefPatientID": "0",
      "PatientName": name,
      "IsRefering": "false",
      "Age": age,
      "Gender": gender,
      "Pincode": "null",
      "CollectionCenterID": "1046",
      "IsHomeCollection": "false",
      "DeviceType": "1",
      "Task": "0",
      "Prescription": "",
      "PrescriptionTwo": "",
      "PrescriptionThree": "",
      "PrescriptionFour": ""
    }
    obj = JSON.stringify(obj)
    $.ajax({
      cache: false,
      type: "POST",
      url: "https://app.vitalimaging.co.in/Services/BookMyAppointment_Services.svc/PatientAppointMent_Global",
      data: obj,
      dataType: "json",
      contentType: "application/json; charset=utf-8",
      beforeSend: function() {
        // $('.box').jmspinner('large');
        var body = $(".modal");
        $(body).show();
      },
      success: function(object) {

        var ob = object.d;
        if (ob.Result == "Appointment_Booked") {
          alert("Appointment Booked Successfully !!");
          window.location.reload();
        } else {
          alert("Appointment Failed ! please Contact SmartLab");
        }
      },
      completed: function() {
        // $('.box').jmspinner(false);
        var body = $(".modal");
        $(body).hide();
      },
    });
  }
</script>

</html>