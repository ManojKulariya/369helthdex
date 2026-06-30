function checkcurrentpwd(val){
    $.ajax({
        url: $("#url_path").val()+"/checkadminpassword"+"/"+val,
        method:"get",
        success: function( data ) {
            console.log(data);
            if(data==1){
                 var msg = $("#cpwd").val();
                alert(msg);
                $("#oldPassword").val("");
            }
        }
    });
}

function checkbothpassword(val){
    console.log(val);
    var msg = $("#newpwd").val();    
    var newpassword = $("#newPassword").val();
    if(newpassword!=val){
        alert(msg);
        $("#newPassword").val("");
        $("#confirmPassword").val("");
    }
}
function delete_record(url){
    var msg = $("#record").val();
    if (confirm(msg)) {   
         if($("#is_demo").val()=='0'){
            alert("This function is currently disable as it is only a demo website, in your admin it will work perfect");
         }else{
            window.location.href = url; 
         }                   
    } else {
        window.location.reload();
    }
}
$(document).ready(function () {
    $('#TodayOrdersTableSample').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/TodayManagerOrdersTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name'
            },{
                data: 'address',
                name: 'address'
            },{
                data: 'datetime',
                name: 'datetime'
            },{
                data: 'payment_method',
                name: 'payment_method'
            },{
                data: 'paid_amount',
                name: 'paid_amount'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status'
            },{
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 6,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="rescheduleModal('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rescheduleModal">Reschedule</a>';          
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });
});
$(document).ready(function () {
    $('#TodayOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: $("#url_path").val() + '/TodayManagerOrdersTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name'
            },{
                data: 'address',
                name: 'address'
            },{
                data: 'datetime',
                name: 'datetime'
            },{
                data: 'payment_method',
                name: 'payment_method'
            },{
                data: 'paid_amount',
                name: 'paid_amount'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'print',
                name: 'print'
            },{
                data: 'status',
                name: 'status'
            },{
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [ {
                targets: 2, // Targeting the Address column
                createdCell: function (td) {
                    $(td).css({
                        "width": "150px",
                        "white-space": "normal",
                        "overflow-wrap": "break-word" 
                    });
                }
            },{
            targets: 6,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="moreinfo('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">More</a>';          
            }
        },{
            targets: 7,
            render: function (data) {
                    var path = $("#url_path").val()+"/managerprintorders"+"/"+data;
                    return '<a href="'+path+'" target="_blank" class="btn btn-primary">print</a>';               
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#SampleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/sampleboyTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'image',
                name: 'image'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'email',
                name: 'email'
            }, {
                data: 'city',
                name: 'city'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 1,
            render: function (data) {
                            
                if (data != null) {
                    return '<img src="'+ data+'" style="height:50px;width:50px;border-radius: 0px">';
                } else {
                    return '';
                }
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#OrdersTableSample').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/ManagerOrdersTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name'
            },{
                data: 'address',
                name: 'address'
            },{
                data: 'datetime',
                name: 'datetime'
            },{
                data: 'payment_method',
                name: 'payment_method'
            },{
                data: 'paid_amount',
                name: 'paid_amount'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status'
            },{
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 6,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="rescheduleModal('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rescheduleModal">Reschedule</a>';          
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });
});
$(document).ready(function () {
    $('#OrdersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/ManagerOrdersTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name'
            },{
                data: 'address',
                name: 'address'
            },{
                data: 'datetime',
                name: 'datetime'
            },{
                data: 'payment_method',
                name: 'payment_method'
            },{
                data: 'paid_amount',
                name: 'paid_amount'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'print',
                name: 'print'
            },{
                data: 'status',
                name: 'status'
            },{
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
                targets: 2, // Targeting the Address column
                createdCell: function (td) {
                    $(td).css({
                        "width": "150px",
                        "white-space": "normal",
                        "overflow-wrap": "break-word" 
                    });
                }
            },{
            targets: 6,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="moreinfo('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">More</a>';          
            }
        },{
            targets: 7,
            render: function (data) {
                    var path = $("#url_path").val()+"/managerprintorders"+"/"+data;
                    return '<a href="'+path+'" target="_blank" class="btn btn-primary">print</a>';               
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });
});
$(document).ready(function () {
    $('#OrderschangeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/ManagerOrderschangeTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name'
            },{
                data: 'type',
                name: 'type'
            },{
                data: 'MRP',
                name: 'MRP'
            },{
                data: 'Price',
                name: 'Price'
            },{
                data: 'Parameters',
                name: 'Parameters'
            },{
                data: 'action',
                name: 'action'
            }
        ],
        
        order: [
            [0, "DESC"]
        ]
    });
});


// $(document).ready(function () {
//     $('#TodayOrdersTable').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: $("#url_path").val() + '/TodayManagerOrdersTable',
//         columns: [{
//                 data: 'id',
//                 name: 'id'
//             },{
//                 data: 'name',
//                 name: 'name'
//             },{
//                 data: 'address',
//                 name: 'address'
//             },{
//                 data: 'datetime',
//                 name: 'datetime'
//             },{
//                 data: 'payment_method',
//                 name: 'payment_method'
//             },{
//                 data: 'paid_amount',
//                 name: 'paid_amount'
//             },{
//                 data: 'more',
//                 name: 'more'
//             },{
//                 data: 'print',
//                 name: 'print'
//             },{
//                 data: 'status',
//                 name: 'status'
//             },{
//                 data: 'action',
//                 name: 'action'
//             }
//         ],
//         columnDefs: [{
//             targets: 6,
//             render: function (data) { 
//                     return '<a href="javascript::void(0)" onclick="moreinfo('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">More</a>';          
//             }
//         },{
//             targets: 7,
//             render: function (data) {
//                     var path = $("#url_path").val()+"/managerprintorders"+"/"+data;
//                     return '<a href="'+path+'" target="_blank" class="btn btn-primary">print</a>';               
//             }
//         }],
//         order: [
//             [0, "DESC"]
//         ]
//     });
// });

function moreinfo(id){
        $.ajax({
            url: $("#url_path").val()+"/getmanagerorderdetails"+"/"+id,
            success: function( data ) {
                var str = JSON.parse(data);
                $("#order_no").html(str.data.id);
                $("#customer_name").html(str.userinfo.name);
                $("#customer_phone").html(str.userinfo.phone);
                $("#email").html(str.userinfo.email);
                $("#address").html(str.data.useraddressdetails.address);
                $("#order_place_date").html(str.data.orderplace_date);
                $("#payment_method").html(str.data.payment_method);
                $("#date").html(str.data.date);
                $("#coupon").html(str.data.coupon_discount);
                $("#wallet").html(str.data.wallet_discount);
                $("#time").html(str.data.time);
                var txt = "";
                for(var i=0;i<str.data.orderdata.length;i++){
                    var mrp = str.data.orderdata[i].mrp;
                    var price = str.data.orderdata[i].price;
                    txt = txt +'<tr><td>'+str.data.orderdata[i].memberdetails.name+' | '+str.data.orderdata[i].memberdetails.relation+'</br>'+str.data.orderdata[i].memberdetails.gender+'</td><td>Name : '+str.data.orderdata[i].item_name+'</br>Parameters : '+str.data.orderdata[i].parameter+'</br>MRP : '+str.currency+mrp.toFixed(2)+'</br>Price : '+str.currency+price.toFixed(2)+'</td><td>'+str.currency+price.toFixed(2)+'</td></tr>';
                }
                var subtotal = str.data.subtotal;
                var txtchr = str.data.tax;
                var finalamount = str.data.final_total;
                
                $("#tableinfo").html(txt);
                $("#subtotal").html(str.currency+subtotal.toFixed(2));
                $("#txt_charge").html(str.currency+txtchr.toFixed(2));
                $("#total").html(str.currency+finalamount.toFixed(2));
            }
        });

}



function rejectorder(id){
  
  $("#rejectorderurl").attr("action",$("#url_path").val()+"/change_order_status"+"/"+id+"/3");
}

function completeorder(id){
    $("#com_order_id").val(id);

}
$(document).on('click', '.submit-report-btn', function() {
        const index = $(this).data('index'); // Get the report index
        const order_id = $(`#order_id_${index}`).val(); // Get the value of the report_name input
        const report_name = $(`#report_name_${index}`).val(); // Get the value of the report_name input
        const test_reg_id = $(`#test_reg_id_${index}`).val(); // Get the value of the test_reg_id input
        const report_id = $(`#report_id_${index}`).val(); 
       
        // AJAX call to save each report
        $.ajax({
            url: "/save_report", // Change this to your route for saving individual reports
            type: "GET",
            data: {report_name:report_name,test_reg_id:test_reg_id,order_id:order_id,report_id:report_id},
            success: function(response) {
                console.log(response);
                if (response.success) {
                    $(`#report_id_${index}`).val(response.report_id); 
                    alert('Report ' + (index + 1) + ' submitted successfully!');
                   
                } else {
                    alert('Failed to submit report: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
     function fnGetPatientReport(control, TestRegnID) {
    var LabID = "c37773d5-520a-4974-8fd0-732ff91f4bf4";
    if (TestRegnID > 0) {
        $.ajax({
            cache: false,
            type: "GET",
            beforeSend: function() {
                
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
                            var filename = objres.PdfName.replace("../", "").replace("~", "");
                            filename = 'https://reliabletest.elabassist.com/' + filename;

                            // Force download using fetch and blob
                            fetch(filename)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok.');
                                    }
                                    return response.blob();
                                })
                                .then(blob => {
                                    const url = window.URL.createObjectURL(blob);
                                    const link = document.createElement('a');
                                    link.href = url;
                                    link.download = 'report.pdf'; // Customize the file name
                                    document.body.appendChild(link);
                                    link.click();
                                    link.remove();
                                    window.URL.revokeObjectURL(url); // Clean up
                                })
                                .catch(error => {
                                    console.error('There was a problem with the fetch operation:', error);
                                    alert("Error to Load PDF for Registration.");
                                });
                           
                        } else {
                            alert("Error to Load PDF for Registration.");
                           
                            
                        }
                    }
                } else {
                    console.log('Error To retrieve Data');
                    alert("Error to Load PDF for Registration.");
                    
                }
            },
            completed: function() {
                
            },
            error: function(result) {
                alert("Error to Load PDF for Registration");
            }
        });
    }
}
function Uploadreport(id){
    $('#report_no').val('');
    $("#report_order_id").val(id);
    
    $('#report_details').empty();
    $.ajax({
        url: '/get_report_details',
        type: 'GET',
        data: { order_id: id },
        success: function(response) {
            console.log(response);
            if (response && response.no_of_report > 0) {
                // Set the number of reports
                $('#report_no').val(response.no_of_report);

                // Loop through the reports provided in the response
                for (let i = 0; i < response.no_of_report; i++) {
                    // Check if the current report exists in the response.Report array
                    let report = response.Report[i] || { report_name: '', test_reg_id: '' };

                    // Create the form fields for each report
                    const reportDetail = `
                        <form class="report_form" data-report-index="${i}">
                            <input type="hidden" name="report_id" id="report_id_${i}" value="${report.id}">
                            <input type="hidden" name="order_id" id="order_id_${i}" value="${id}">
                            <div class="row mb-3">
                                <div class="form-group col-4">
                                    <label for="report_name_${i}">Report Name<span class="reqfield">*</span></label>
                                    <input type="text" name="report_name" class="form-control" id="report_name_${i}" value="${report.report_name}" required />
                                </div>
                                <div class="form-group col-4">
                                    <label for="test_reg_id_${i}">Test Registration ID<span class="reqfield">*</span></label>
                                    <input type="text" name="test_reg_id" class="form-control" id="test_reg_id_${i}" value="${report.test_reg_id}" required />
                                </div>
                                <div class="col-4">
                                
                                
                                <button type="button" class="btn btn-primary submit-report-btn btn-sm mt-6" data-index="${i}">Submit Report ${i + 1}</button>
                                </div>
                            </div>
                        </form>
                    `;

                    // Append the report detail to the report_details container
                    $('#report_details').append(reportDetail);
                }
               
            }

        },
        error: function(xhr, status, error) {
            console.error('Error fetching Reports:', error);
        }
    });

}
function rescheduleModal(id){
    
    $("#reschedule_order_id").val(id);

}
function assignsampleboy(id,useraddress){ 
    $("#sampleboy_order_id").val(id);
  //  $("#sampleboy_address_id").val(useraddress);

}