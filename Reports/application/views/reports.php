<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reliable Diagnostics</title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/images/fulllogo_nobuffer.png" type="image/jpg">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <link href="https://jquery.app/jqueryscripttop.css" rel="stylesheet" type="text/css">


    <style>
        /* body {
            background-image: url(assets/images/pexels-scott-webb-305821.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: currentcolor;
        } */

        .accordion-button:not(.collapsed) {
            color: white !important;
        }

        .accordion-button {
            float: right;
            margin-bottom: 15px;
            background: #1766b0 !important;
            border: none;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .container {
            /* border: 2px solid #ed2e34; */
            /* padding: 20px 50px 20px 50px; */
            /* margin-top: 20px; */
            border-radius: 15px;
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
        <div class="logoutdiv" style="margin-top: 20px;">
            <button id="btnLogout" type="button" class="btn btn-outline-primary mx-auto">
                Logout
            </button>
        </div>
        <center>
            <img class="logo img-responsive" src="<?php echo base_url(); ?>assets/images/fulllogo_nobuffer.png">
        </center>
        <h5 style="margin-top: 20px;" class="userwelcome">Welcome <span style="color: #0093dd"></span> !</h5>
    </div>

    <!-- Start contain wrapp -->
    <div class="contain-wrapp">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="section-heading">
                        <h3> Patient Report With Details</h3>
                    </div>
                </div>
                <div class="col-sm-12">
                    <?php if (!empty($reportlist)) { ?>
                        <div class="accordion" id="accordionExample">
                            <?php foreach ($reportlist as $report) { ?>
                                <div class="accordion-item">
                                    <h5 class="accordion-header bg-blue1" id="heading<?= $report["TestRegnID"]; ?>">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $report["TestRegnID"]; ?>" aria-expanded="false" aria-controls="collapse<?= $report["TestRegnID"]; ?>">
                                            <span><?= $report["PatientName"]; ?></span>
                                            &nbsp;|&nbsp;
                                            <span style="color:red;">Test Registration ID :</span>
                                            &nbsp;<?= $report["TestRegnID"]; ?>
                                            &nbsp;|&nbsp;
                                            <span style="color:red;">Balance Amount :</span>
                                            &nbsp;<?= $report["BalanceAmt"]; ?>
                                        </button>
                                    </h5>
                                    <div id="collapse<?= $report["TestRegnID"]; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $report["TestRegnID"]; ?>" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class="RegAspects">
                                                <li><span>Date Of Registration</span> : <?= $report["RegnDateTimeString"]; ?></li>
                                                <li>Test Description : <span><?= $report["SelectedTest"]; ?></span></li>
                                                <li>
                                                    <span>Registration</span>:- <span>Net Amount</span>: <?= $report["Net"]; ?> Rs.,
                                                    <span>Paid Amount</span>: <?= $report["AmountPaid"]; ?> Rs.,
                                                    <span>Balance Amount</span>: <?= $report["BalanceAmt"]; ?> Rs.
                                                </li>
                                                <?php if ($report["BalanceAmt"] <= 0) { ?>
                                                    <li>
                                                        <span>Report Availability</span>: <button class="btn btn-primary btn-sm btn-radius" type="button" onclick="fnGetPatientReport(this)" testregnid="<?= $report["TestRegnID"]; ?>">Show Report</button>
                                                    </li>
                                                <?php } else { ?>
                                                    <li>Pay Balance Amount for report: <button class="btn btn-primary btn-sm btn-radius" style="padding: 6px 20px;" data-bs-toggle="modal" data-bs-target="#pay<?= $report["TestRegnID"]; ?>" title="<?= $report["TestRegnID"]; ?>">Pay Online</button></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="pay<?= $report["TestRegnID"]; ?>" tabindex="-1" role="dialog" aria-labelledby="payLabel<?= $report["TestRegnID"]; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Patient Information</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?= base_url(); ?>request" method="post">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="patientname" class="form-label">Patient Name</label>
                                                            <input id="patientname" type="text" class="form-control" name="patientname" value="<?= $report["PatientName"]; ?>" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="paymentAmount" class="form-label">Amount</label>
                                                            <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" value="<?= $report["BalanceAmt"]; ?>" readonly>
                                                        </div>
                                                        <input type="hidden" id="userID" name="userID" value="">
                                                        <input type="hidden" id="testregnid" name="testregnid" value="<?= $report["TestRegnID"]; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Pay</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>No reports available.</p>
                    <?php } ?>
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
<!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        var user = JSON.parse(localStorage.getItem("smartlabRes"))
        $('.userwelcome span').text(user.ShortName);
        var profileAndTestArr = [];
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
        // else
        //     LoadTestReportList();
    });

    function fnGetPatientReport(control) {
        var TestRegnID = $(control).attr('testregnid');
        var LabID = "4bee96ca-3ea8-4e89-a575-04d2beed400c";
        if (TestRegnID > 0) {


            $.ajax({
                cache: false,
                type: "GET",
                beforeSend: function() {
                    // $('.box').jmspinner('large');
                    var body = $(".modal");
                    $(body).show();
                },
                url: 'https://reliabletest.elabassist.com/Services/Test_RegnService.svc/GetReleaseTestReport_Global',
                data: {
                    LabID: LabID,
                    UserTypeID: 6,
                    TestRegnID: TestRegnID,
                },
                dataType: 'json',
                contentType: "application/json; charset=utf-8",
                success: function(objresult) {
                    if (objresult) {
                        var objres = objresult.d[0];
                        if (objres) {

                            if (objres.PdfName != "") {
                                var filename = objres.PdfName.replace("../", "");
                                filename = filename.replace("~", "");
                                filename = 'https://reliabletest.elabassist.com/' + filename;
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
                        }
                    } else {
                        console.log('Error To retrive Data');
                        alert("Error to Load PDF for Registration.");
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
                    alert("Error to Load PDF for Registration");
                }
            });
        }
        //alert('control' + TestRegnID);
    }
</script>

</html>