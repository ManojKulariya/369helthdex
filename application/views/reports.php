<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reliable Diagnostics</title>
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/fulllogo_nobuffer.png" type="image/jpg">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://jquery.app/jqueryscripttop.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://bootswatch.com/darkly/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/overwrite.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/default.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jm.spinner.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/revolution/layers.css">
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/revolution/navigation.css">
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/revolution/settings.css"> -->
    <!-- CSS only -->
    <!-- <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF"
      crossorigin="anonymous"
    /> -->
    <style>
        body {
            background-image: url(assets/images/pexels-scott-webb-305821.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: currentcolor;
        }

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

        .panel-body {
            background-color: aliceblue;
        }
    </style>
    <style>
        p {
            margin-bottom: 0px;
            padding-top: 0px
        }

        hr {
            margin-top: 0px;
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <div class="container" style="border: none;display: flex; justify-content: space-between;">
        <div class="logoutdiv">
            <button id="btnLogout" type="button" class="btn btn-outline-primary mx-auto">
                Logout
            </button>
            <!-- <a style="margin-left: 10px;" href="<?php echo base_url(); ?>reports">
        Reports
       </a> -->
        </div>
        <center>
            <img class="logo img-responsive" src="<?php echo base_url(); ?>assets/images/fulllogo_nobuffer.png">
        </center>
        <h5 class="userwelcome">Welcome <span style="color: #0093dd"></span> !</h5>
    </div>

    <!-- Start contain wrapp -->
    <div class="contain-wrapp">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="section-heading">
                        <h5> Patient Report With Details</h5>
                    </div>
                </div>
            </div>
            <div class="row marginbot10">
                <div class="col-md-12">
                    <div class="row">

                        <style>
                            .panel-title {
                                font-size: 12px
                            }
                        </style>
                        <div class="col-md-12">
                            <div class="custom-tabs">



                                <div class="col-sm-12" style="margin-left: -21px;">
                                    <div class="panel-group" id="accordion1">


                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row marginbot30">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal"></div>
</body>
<script src="<?php echo base_url(); ?>assets/js/jm.spinner.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form/jcf.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form/jcf.scrollable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form/jcf.select.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.easing-1.3.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {

        var user = JSON.parse(localStorage.getItem("smartlabRes"))
        $('.userwelcome span').text(user.ShortName);
        var profileAndTestArr = [];

        //  $.ajax({ 

        //  cache: false,
        //  type: "GET",
        //  url: "http://devglobal.elabassist.com/Services/GlobalUserService.svc/SearchTest",
        //  data: { labid: "dccd4cf3-d5ce-407c-925b-ff5b2abb65b3" },
        //  dataType: "json",
        //  // contentType: "application/json; charset=utf-8",
        //  success: function(object) {
        //      var obj = JSON.stringify(object);
        //      profileAndTestArr.push(object.d);
        //      // alert(obj);
        //      // localStorage.setItem("AllVeinPackages", obj);
        //      // console.log(profileAndTestArr);

        //      $.ajax({ 
        //          cache: false,
        //          type: "GET",
        //          url: "http://devglobal.elabassist.com/Services/GlobalUserService.svc/SearchProfile",
        //          data: { labid: "dccd4cf3-d5ce-407c-925b-ff5b2abb65b3"},
        //          dataType: "json",
        //          // contentType: "application/json; charset=utf-8",
        //          success: function(object) {
        //              var obj = JSON.stringify(object);
        //              profileAndTestArr.push(object.d);
        //              // alert(obj);
        //              // console.log(profileAndTestArr);
        //              localStorage.setItem("AllSmartLabPackages", JSON.stringify(profileAndTestArr));
        //          }
        //      });
        //  }
        //  });
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
        } else
            LoadTestReportList();
    });


    function LoadTestReportList() {

        var userObj = JSON.parse(localStorage.getItem("smartlabRes"));
        // var uID = userObj.UserFID;
        var uID = userObj.UserFID;
        var LabID = "4bee96ca-3ea8-4e89-a575-04d2beed400c";

        var objUserData = {
            UserFID: uID,
            LabID: LabID,
            FromDate: '',
            ToDate: '',
            LabCode: '',
            PatientName: '',
            UserType: '1',
            EntityId: 0,
            EntityTypeId: 0,
        };

        $.ajax({
            cache: false,
            type: "POST",
            beforeSend: function() {
                // $('.box').jmspinner('large');
                var body = $(".modal");
                $(body).show();
            },
            url: 'https://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/TestReportList',
            data: JSON.stringify(objUserData),
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success: function(objresult) {
                if (objresult) {
                    var objres = objresult.d;
                    if (objres) {
                        $('#accordion1').html('');
                        if (objres.length > 0) {
                            $.each(objres, function(index, value) {
                                var Gender = '';
                                var ReportAvailableStatus = '';
                                var ReportAvailableStatusHeader = '';
                                var AgeGenderStr = '';
                                if (value.Gender == 0) Gender = 'M';
                                else if (value.Gender == 1) Gender = 'F';
                                if (value.PatientAge > 0) AgeGenderStr = ' (' + value.PatientAge + ' ' + Gender + ') ';
                                if (value.ReleseReport) {
                                    ReportAvailableStatus = '<button  style="margin-top: -5px;" class="btn btn-primary btn-sm btn-radius" type="button" onclick="fnGetPatientReport(this)"PDFFileName="' + value.PDFFileName + '" TestRegnID="' + value.TestRegnID + '">Show Report</button>';
                                    ReportAvailableStatusHeader = '<button  style="margin-top: -5px;float: right;" class="btn btn-primary btn-sm btn-radius" type="button" onclick="fnGetPatientReport(this)" PDFFileName="' + value.PDFFileName + '" TestRegnID="' + value.TestRegnID + '">Show Report</button>';
                                } else {
                                    ReportAvailableStatus = '<span><b> Not Available.</b> </span>';
                                    ReportAvailableStatusHeader = ''; // '<span style="float: right;"><span style="color:#fff;">Report : </span><b> Not Available.</b> </span>';
                                }
                                var PatientInfoRow =
                                    '<div class="panel panel-flat"> ' +
                                    '<div class="panel-heading" id="ReportHeading_' + index + '"> ' +
                                    '<h6 class="panel-title"> ' +
                                    '<a style="background-color: #333;" ' + (index == 0 ? '' : 'class="collapsed" ') + 'data-toggle="collapse" data-parent="#accordion1" href="#ReportPanel_' + index + '"> ' +
                                    '<b> <span style="text-transform: capitalize;">' + value.PatientName + '</span>' + AgeGenderStr + '</b> &emsp;' +
                                    '<span style="color:#fff;">(ID:' + value.LabCode + ')</span>&emsp;' +
                                    '<span style="color:#fff;"> Balance Amt : ' + value.BalanceAmt + '</span>' +
                                    '<button  style="margin-left: 481px;"class="show-caption open-caption"><i class="fa fa-chevron-circle-down"></i></button> ' +
                                    ReportAvailableStatusHeader +
                                    '</a> ' +
                                    '</h6> ' +
                                    '</div> ' +
                                    '<div id="ReportPanel_' + index + '" class="panel-collapse collapse' + (index == 0 ? ' in' : '') + ' "> ' +
                                    '<div class="panel-body" style="padding-left: 15px;"> ' +
                                    '<i style="font-size:22px;padding-left: 15px;color: #ff422a;" class="fa fa-calendar" aria-hidden="true"></i> ' +
                                    '<p class="testinformation"> ' +
                                    '<strong>Date of Registration : </strong>' + value.RegnDateTimeString +
                                    '</p> ' +
                                    '<hr> ' +
                                    '<i style="font-size:22px;padding-left: 15px;color: #ff422a;" class="fa fa-info-circle" aria-hidden="true"></i> ' +
                                    '<p class="testinformation"> ' +
                                    '<strong>Test Discription : </strong>' + value.SelectedTest +
                                    '</p> ' +
                                    '<hr> ' +
                                    '<i style="font-size:22px;padding-left: 15px;color: #ff422a;" class="fa fa-inr" aria-hidden="true"></i> ' +
                                    '<p class="testinformation"> ' +
                                    '<strong>Registration :- </strong> &emsp;' +
                                    '<strong>Net Amt : </strong>' + value.Net + ' &emsp;' +
                                    '<strong>Paid Amt : </strong>' + value.AmountPaid + ' &emsp;' +
                                    '<strong>Balance Amt : </strong>' + (value.BalanceAmt <= 0 ? value.BalanceAmt : '<b>' + value.BalanceAmt + '</b>') + ' &emsp;' +
                                    // (value.BalanceAmt <= 0 ? '' : '<button  style="margin-top: -5px;float: right;" class="btn btn-primary btn-sm btn-radius" type="submit">PAY ONLINE</button>') +
                                    '</p> ' +
                                    '<hr> ' +
                                    '<i style="font-size:22px;padding-left: 15px;" class="fa fa-file-text" aria-hidden="true"></i> ' +
                                    '<p class="testinformation"> ' +
                                    '<strong>Report Avilability  :</strong> ' + ReportAvailableStatus +
                                    '</p> ' +
                                    //'<div class="pricetest"> ' +
                                    //    '<div class="col-sm-4 col-md-offset-8" style="padding: 11px;"> ' +
                                    //        //'<button  style="margin-top: -5px;padding-left: 17px;margin-left: 128px;" class="btn btn-primary btn-sm btn-radius" type="submit"> RS:50000/- </button> ' +
                                    //    '</div> ' +
                                    //'</div> ' +
                                    '</div> ' +
                                    '</div> ' +
                                    '</div>';
                                $('#accordion1').append(PatientInfoRow);
                                var body = $(".modal");
                                $(body).hide();
                            });
                        } else {
                            var htmlstr =
                                '<div class="container">' +
                                '<h5 style="color: #ff422a;">Details Not Available.</h5>' +
                                '</div>';
                            $('#accordion1').html(htmlstr);
                            var body = $(".modal");
                            $(body).hide();
                        }
                    } else {
                        var htmlstr =
                            '<div class="container">' +
                            '<h5 style="color: #ff422a;">Details Not Available.</h5>' +
                            '</div>';
                        $('#accordion1').html(htmlstr);
                        var body = $(".modal");
                        $(body).hide();
                    }
                } else {
                    console.log('Error To retrive Data');
                    var body = $(".modal");
                    $(body).hide();
                }
            },
            completed: function() {
                // $('.box').jmspinner(false);
                var body = $(".modal");
                $(body).hide();
            },
            error: function(result) {

            },
        });
    }

    function fnGetPatientReport(control) {
        var TestRegnID = $(control).attr('TestRegnID');
        var PDFFileName = $(control).attr('PDFFileName');
        var userObj = JSON.parse(localStorage.getItem("smartlabRes"));
        // var uID = userObj.UserFID;
        var uID = userObj.UserFID;
        var LabID = "4bee96ca-3ea8-4e89-a575-04d2beed400c";
        if (TestRegnID > 0) {

            if (PDFFileName != "") {
                var filename = PDFFileName.replace("~/", "");
                filename = filename.replace("~", "");
                filename = 'http://reliable.elabassist.com/' + filename;
                var w = window.open();
                w.document.title = "PDF Report";
                w.document.location.href = filename;
                var body = $(".modal");
                $(body).hide();
            } else {
                alert("Error to Load PDF for Registration.");
                var body = $(".modal");
                $(body).hide();
            }


            // $.ajax({
            //     cache: false,
            //     type: "GET",
            //     beforeSend: function() {
            //         // $('.box').jmspinner('large');
            //         var body = $(".modal");
            //         $(body).show();
            //     },
            //     url: 'https://app.vitalimaging.co.in/Services/Test_RegnService.svc/GetReleaseTestReport_Global',
            //     data: {
            //         LabID: LabID,
            //         UserTypeID: 1,
            //         TestRegnID: TestRegnID,
            //     },
            //     dataType: 'json',
            //     contentType: "application/json; charset=utf-8",
            //     success: function(objresult) {
            //         if (objresult) {
            //             var objres = objresult.d[0];
            //             if (objres) {

            //                 if (objres.PdfName != "") {
            //                     var filename = objres.PdfName.replace("../", "");
            //                     filename = filename.replace("~", "");
            //                     filename = 'https://app.vitalimaging.co.in/' + filename;
            //                     var w = window.open();
            //                     w.document.title = "PDF Report";
            //                     w.document.location.href = filename;
            //                     var body = $(".modal");
            //                     $(body).hide();
            //                 } else {
            //                     alert("Error to Load PDF for Registration.");
            //                     var body = $(".modal");
            //                     $(body).hide();
            //                 }
            //             }
            //         } else {
            //             console.log('Error To retrive Data');
            //             alert("Error to Load PDF for Registration.");
            //             var body = $(".modal");
            //             $(body).hide();
            //         }
            //     },
            //     completed: function() {
            //         // $('.box').jmspinner(false);
            //         var body = $(".modal");
            //         $(body).hide();
            //     },
            //     error: function(result) {
            //         alert("Login Failed. Please try Again.");
            //     }
            // });
        }
        //alert('control' + TestRegnID);
    }
</script>

</html>