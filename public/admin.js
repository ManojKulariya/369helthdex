"use strict"
$(document).ready(function() {
    $('.select2t').select2({
        // maximumSelectionLength: 1,
        // placeholder: "{{ __('message.Select Test') }}",
         width: '100%', 
        allowClear: true,
        
    });
    updateTotalPrice();
});
 function updateTotalPrice() {
    let totalPrice = 0;
    let totalPricemrp = 0;

    // Iterate through each row
    $('#test-body tr').each(function() {
      // Get the price from the selected test option
      let price = $(this).find('select[name*="[type_id]"] option:selected').data('price');
      
      if (price) {
        totalPrice += parseFloat(price);  // Add the price to the total
      }
    });

    // Update the total price in the HTML
    $('#total_price').text(totalPrice.toFixed(2));  // Display total price rounded to 2 decimal places
    
    $('#test-body tr').each(function() {
      // Get the price from the selected test option
      let mrp = $(this).find('select[name*="[type_id]"] option:selected').data('mrp');
      
      if (mrp) {
        totalPricemrp += parseFloat(mrp);  // Add the price to the total
      }
    });

    // Update the total price in the HTML
    $('#total_mrp').text(totalPricemrp.toFixed(2));
  }

$(document).ready(function () {
    $('#CategoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/categorydatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'cat_name',
                name: 'cat_name'
            },
            {
                data: 'cat_image',
                name: 'cat_image'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 2,
            render: function (data) {
                var url =data;
                var pathname = new URL(url).pathname;               
                if (data != null) {
                    return '<img src="'+data+'" style="height:50px;width:50px;border-radius: 0px">';
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
    $('#sampletypeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/sampletypedatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'sample_name',
                name: 'sample_name'
            },
             {
                data: 'action',
                name: 'action'
            }
        ],
       
        order: [
            [0, "DESC"]
        ]
    });
});
$(document).ready(function () {
    $('#preTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/predataTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'doc',
                name: 'doc',
                render: function (data, type, row) {
                    if (data) {
                        // Assuming 'data' is the document path
                        return `<a href="${data}" download>
                                    <i class="fa fa-download"></i>
                                </a>`;
                    }
                    return ''; // return empty if no doc
                }
            },{
                data: 'name',
                name: 'name',
                 render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            },{
                data: 'email',
                name: 'email'
            },{
                data: 'gender',
                name: 'gender'
            },{
                data: 'd_o_b',
                name: 'd_o_b'
            },{
                data: 'number',
                name: 'number'
            },{
                data: 'br_name',
                name: 'br_name'
            }
        ],
        
        order: [
            [0, "DESC"]
        ]
    });
});
$(document).ready(function () {
    $('#OfferTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/offerdatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'cat_name',
                name: 'cat_name'
            },
            {
                data: 'cat_image',
                name: 'cat_image'
            }, {
                data: 'type',
                name: 'type'
            }, {
                data: 'type_id',
                name: 'type_id'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 2,
            render: function (data) {
                var url =data;
                var pathname = new URL(url).pathname;               
                if (data != null) {
                    return '<img src="'+data+'" style="height:50px;width:50px;border-radius: 0px">';
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
    $('#CouponTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/coupondatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'coupon_code',
                name: 'coupon_code'
            } ,{
                data: 'name',
                name: 'name',
                 render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            },{
                data: 'value',
                name: 'value'
            }
            ,{
                data: 'start_date',
                name: 'start_date'
            }
            ,{
                data: 'end_date',
                name: 'end_date'
            }
            ,
            {
                data: 'action',
                name: 'action'
            }
        ],
       
        order: [
            [0, "DESC"]
        ]
    });
    
    
});
$(document).ready(function () {
    $('#JobTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/jobsdatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'title',
                name: 'title'
            } ,{
                data: 'openings',
                name: 'openings'
            },{
                data: 'locations',
                name: 'locations'
            }
            ,{
                data: 'experince',
                name: 'experince'
            }
            ,{
                data: 'salary',
                name: 'salary'
            }
            ,{
                data: 'department',
                name: 'department'
            }
            ,{
                data: 'designations',
                name: 'designations'
            }
            ,{
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action'
            }
        ],
       
        order: [
            [0, "DESC"]
        ]
    });
    
    
});

    $(document).ready(function () {
        $('#callbackTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: $("#url_path").val() + '/calbackdatatable',
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            },
            {
                data: 'number',
                name: 'number'
            }, {
                data: 'message',
                name: 'message',
                  render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 190px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }
            ],
            
            order: [
                [0, "DESC"]
            ]
        });
    });
    $(document).ready(function () {
        $('#complaintTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: $("#url_path").val() + '/complaintsdatatable',
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'email',
                name: 'email'
            },
            {
                data: 'number',
                name: 'number'
            }, {
                data: 'message',
                name: 'message',
                 render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 190px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }
            ],
            
            order: [
                [0, "DESC"]
            ]
        });
    });
    $(document).ready(function () {
        $('#ApplicationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: $("#url_path").val() + '/application-datatable',
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'Vacancies',
                name: 'Vacancies'
            },{
                data: 'name',
                name: 'name'
            }, {
                data: 'dob',
                name: 'dob'
            },
            {
                data: 'number',
                name: 'number'
            }, {
                data: 'adhar_no',
                name: 'adhar_no'
            }
            , {
                data: 'current_ctc',
                name: 'current_ctc'
            }
            , {
                data: 'expected_ctc',
                name: 'expected_ctc'
            }
            , {
                data: 'address',
                name: 'address',
                render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            },{
                data: 'resume',
                name: 'resume',
                render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }
            ],
            
            
            order: [
                [0, "DESC"]
            ]
        });
    });

function disablebtn(){
    alert($("#admin_demo_msg").val());
}

function samplecollectionchange(val){
   if(val==2){
        $("#sample_collection_fee_div").css("display","block");
        $("#sample_collection_fee").attr("required",true);
   }else{
        $("#sample_collection_fee_div").css("display","none");
        $("#sample_collection_fee").attr("required",false);
   }
}

function fasttimedivhcnage(val){
   if(val==1){
        $("#fast_time_div").css("display","block");
        $("#fast_time").attr("required",true);
   }else{
        $("#fast_time_div").css("display","none");
        $("#fast_time").attr("required",false);
   }
}

$(document).ready(function () {
    $('#SubcategoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/subcategorydatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'sub_name',
                name: 'sub_name'
            },
            {
                data: 'sub_image',
                name: 'sub_name'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 2,
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
    $('#ContentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/contentdatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, 
            {
                data: 'page_name',
                name: 'page_name'
            },
            {
                data: 'content_name',
                name: 'content_name'
            },
            // {
            //     data: 'content_image',
            //     name: 'content_image'
            // },
            {
                data: 'action',
                name: 'action'
            }
        ],
        
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#BlogTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/blogdatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'blog_name',
                name: 'blog_name'
            },
            {
                data: 'blog_image',
                name: 'blog_image'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        columnDefs: [{
            targets: 2,
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
    $('#TagTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/tagdatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'tag_name',
                name: 'tag_name'
            },
            {
                data: 'action',
                name: 'action'
            }
        ],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#discountTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/discountdatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'dis_name',
                name: 'dis_name'
            },{
                data: 'dis_type',
                name: 'dis_type'
            },{
                data: 'discount',
                name: 'discount'
            },{
                data: 'type_id',
                name: 'type_id'
            },{
                data: 'date_range',
                name: 'date_range'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#CityTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/citydatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'city_name',
                name: 'city_name'
            },{
                data: 'city',
                name: 'city'
            },{
                data: 'default',
                name: 'default'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#ContactTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/contact_datatable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name'
            },{
                data: 'email',
                name: 'email'
            },{
                data: 'phone',
                name: 'phone'
            },{
                data: 'subject',
                name: 'subject'
            },{
                data: 'message',
                name: 'message'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#transportallOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/parcelTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'from',
                name: 'from'
            },{
                data: 'to',
                name: 'to'
            },{
                data: 'date',
                name: 'date'
            },{
                data: 'time',
                name: 'time'
            },{
                data: 'courier_type',
                name: 'courier_type'
            },{
                data: 'qty',
                name: 'qty'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status'
            }
        ],
        columnDefs: [{
            targets: 7,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="moreinfoparcel('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">'+$("#more_lable").val()+'</a>';          
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#transportOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/parcelTableupcomming',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'from',
                name: 'from'
            },{
                data: 'to',
                name: 'to'
            },{
                data: 'date',
                name: 'date'
            },{
                data: 'time',
                name: 'time'
            },{
                data: 'courier_type',
                name: 'courier_type'
            },{
                data: 'qty',
                name: 'qty'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status'
            }
        ],
        columnDefs: [{
            targets: 7,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="moreinfoparcel('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">'+$("#more_lable").val()+'</a>';          
            }
        }],
       
    });
});
$(document).ready(function () {
    $('#receiverallOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/parcelTable-rec',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'from',
                name: 'from'
            },{
                data: 'to',
                name: 'to'
            },{
                data: 'date',
                name: 'date'
            },{
                data: 'time',
                name: 'time'
            },{
                data: 'courier_type',
                name: 'courier_type'
            },{
                data: 'qty',
                name: 'qty'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status',
                render: function (data, type, row) {
                if (data === 'Transit') {
                    return 'Transit';
                } else if (data === 'Received at Point') {
                    return `<button class="btn btn-success mark-received-btn" data-order-id="${row.id}">Mark as Received</button>`;
                } else if (data === 'Received at Lab') {
                    return 'Received at Lab';
                } else {
                    return data ?? '—';
                }
            }


            }
        ],
        columnDefs: [{
            targets: 7,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="moreinfoparcel_rec('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">'+$("#more_lable").val()+'</a>';          
            }
        }],
        order: [
            [0, "DESC"]
        ]
    });

});
$(document).on('click', '.mark-received-btn', function () {
    let orderId = $(this).data('order-id');
    console.log("Sending Order ID:", orderId);

    $.ajax({
        url: $('#uploadImageUrl').val(),
        type: 'POST',
        data: {
            order_id: orderId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: response.message,
                confirmButtonText: 'OK'
            });

            $('#receiverallOrdersTable').DataTable().ajax.reload();
        },
        error: function (xhr) {
            console.error("XHR Error:", xhr);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: xhr.responseJSON?.message ?? 'Status update failed. Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });
});


$(document).ready(function () {
    $('#receiverOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/parcelTableupcomming-rec',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'from',
                name: 'from'
            },{
                data: 'to',
                name: 'to'
            },{
                data: 'date',
                name: 'date'
            },{
                data: 'time',
                name: 'time'
            },{
                data: 'courier_type',
                name: 'courier_type'
            },{
                data: 'qty',
                name: 'qty'
            },{
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status'
            }
        ],
        columnDefs: [{
            targets: 7,
            render: function (data) { 
                    return '<a href="javascript::void(0)" onclick="moreinfoparcel_rec('+data+')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">'+$("#more_lable").val()+'</a>';          
            }
        }],
       
    });
});
function assignLab(order_id){ 
    $("#lab_order_id").val(order_id);
 }
function assignsampleboy(id){ 
    $("#sampleboy_order_id").val(id);
    $.ajax({
        url: '/sample_boy_list',  // Define this route in Laravel
        type: 'GET',
        data: { order_id: id },  // Pass the order ID if necessary
        success: function(response) {
            let sampleBoyDropdown = $('select[name="sm_boy_id"]');
            sampleBoyDropdown.empty(); // Clear existing options
            sampleBoyDropdown.append(`<option value="">Select Sample Boy</option>`);
            response.sampleBoys.forEach(function(sampleBoy) {
                sampleBoyDropdown.append(`<option value="${sampleBoy.id}">${sampleBoy.name}</option>`);
            });

        },
        error: function(xhr, status, error) {
            console.error('Error fetching sample boys:', error);
        }
    });
}
function rejectorder(id){
  
  $("#rejectorderurl").attr("action",$("#url_path").val()+"/change_order_status_admin"+"/"+id+"/3");
}

function completeorder(id){
    $("#com_order_id").val(id);

}

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
$(document).ready(function () {
    var table =  $('#OrdersTable').DataTable({
        
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/OrdersTable',
         pageLength: 25, 
         autoWidth: false,
        columns: [{
            
                data: 'id',
                name: 'id'
            },{
                data: 'name',
                name: 'name',
               
            },{
                data: 'item_name',
                name: 'item_name'
            },
            {
                data: 'address',
                name: 'address',
                render: function(data) {
                    // Assuming `memberName` and `relation` are properties of the `row` object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            },{
                data: 'datetime',
                name: 'datetime'
            },{
                data: 'paid_amount',
                name: 'paid_amount'
            }
            ,
            {
                data: 'more',
                name: 'more'
            },{
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action'
            }
        ],
        
        columnDefs: [{
                targets: 1, // Targeting the Address column
                createdCell: function (td) {
                    $(td).css({
                        "width": "75px",
                        "white-space": "normal",
                        "overflow-wrap": "break-word" 
                    });
                }
            },{
                targets: 2, // Targeting the Address column
                createdCell: function (td) {
                    $(td).css({
                        "width": "130px",
                        "white-space": "normal",
                        "overflow-wrap": "break-word" 
                    });
                }
            },{
                targets: 4, // Targeting the Address column
                createdCell: function (td) {
                    $(td).css({
                        "width": "65px",
                        "white-space": "normal",
                        "overflow-wrap": "break-word" 
                    });
                }
            },
        ],
        
        order: [
            [0, "DESC"]
        ]
    });
    setInterval(function () {
        table.ajax.reload(null, false); // Reload data without resetting the paging
    }, 120000); // 120000 milliseconds = 2 minutes
});
function moreinfoparcel(id){
        $.ajax({
            url: $("#url_path").val()+"/getparceldetails"+"/"+id,
            success: function( data ) {
                  var str = JSON.parse(data);
              console.log(str.qty);
                $("#order_no").html(str.qty);
                $("#customer_name").html(str.courier_type);
                $("#email").html(str.parcel_type);
                $("#address").html(str.weight);
                $("#order_place_date").html(str.vehicle_no);
                $("#payment_method").html(str.driver_name);
                $("#date").html(str.date);
                $("#time").html(str.time);
                $("#driver_phon").html(str.driver_phon);
               
               $("#pickup_point").html(str.pickup_point);
                var baseImageUrl = $("#parcelImg").parent().data("baseurl");
                var imagePath = baseImageUrl + '/' + str.par_img;
                $('#parcelImg').attr('src', imagePath);

                 var baseImageUrl1 = $("#cargoImg").parent().data("baseurl");
                var imagePath1 = baseImageUrl1 + '/' + str.par_img;
                $('#cargoImg').attr('src', imagePath1);
            
                }
        });
}

function moreinfo(id){
        $.ajax({
            url: $("#url_path").val()+"/getorderdetails"+"/"+id,
            success: function( data ) {
                var str = JSON.parse(data);
                $("#order_no").html(str.data.id);
                $("#customer_name").html(str.userinfo.name);
                $("#customer_phone").html(str.userinfo.phone);
                $("#email").html(str.userinfo.email);
                $("#address").html(str.data.useraddressdetails.address);
                $("#order_place_date").html(str.data.orderplace_date);
                $("#payment_method").html(str.data.payment_method);
                $("#coupon").html(str.data.coupon_discount);
                $("#wallet").html(str.data.wallet_discount);
                $("#date").html(str.data.date);
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
function moreinfoparcel_rec(id){
        $.ajax({
            url: $("#url_path").val()+"/getparceldetails-rec"+"/"+id,
            success: function( data ) {
                  var str = JSON.parse(data);
              console.log(str.qty);
                $("#order_no").html(str.qty);
                $("#customer_name").html(str.courier_type);
                $("#email").html(str.parcel_type);
                $("#address").html(str.weight);
                $("#order_place_date").html(str.vehicle_no);
                $("#payment_method").html(str.driver_name);
                $("#date").html(str.date);
                $("#time").html(str.time);
                $("#driver_phon").html(str.driver_phon);
               
               $("#pickup_point").html(str.pickup_point);
                var baseImageUrl = $("#parcelImg").parent().data("baseurl");
                var imagePath = baseImageUrl + '/' + str.par_img;
                $('#parcelImg').attr('src', imagePath);

                var baseImageUrl1 = $("#cargoImg").parent().data("baseurl");
                var imagePath1 = baseImageUrl1 + '/' + str.par_img;
                $('#cargoImg').attr('src', imagePath1);
            
                }
        });
}

$(document).ready(function () {
    $('#popularPackageTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/popularPackageTable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        order: [
            [0, "DESC"]
        ]
    });
});



$(document).ready(function () {
    $('#ManagerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/ManagerTable',
        columns: [{
                data: 'id',
                name: 'id'
            },{
                data: 'image',
                name: 'image'
            }, {
                data: 'name',
                name: 'name',
                render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }, {
                data: 'email',
                name: 'email',
                render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }, {
                data: 'user_type',
                name: 'user_type'
            },{
                data: 'city',
                name: 'city',
                render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
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

 $('#sampleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/SampleTable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'phone',
                name: 'phone'
            }, {
                data: 'lab',
                name: 'lab'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
       
        order: [
            [0, "DESC"]
        ]
    }); 

$(document).ready(function () {
    $('#TransportManagerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/TransportManagerTable',
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
    $('#TransportUserTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/TransportUserTable',
        columns: [{
                data: 'id',
                name: 'id'
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
                data: 'member',
                name: 'member'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        // columnDefs: [{
        //     targets: 1,
        //     render: function (data) {
        //         if (data != null) {
        //             return '<img src="'+ data+'" style="height:50px;width:50px;border-radius: 0px">';
        //         } else {
        //             return '';
        //         }
        //     },
         
        // }],
    /*  columnDefs: [{
            targets: 5,
            render: function (data) {
                if (data != null) {
                    alert(data);
                   // return '<img src="'+ data+'" style="height:50px;width:50px;border-radius: 0px">';
                    // return "<input type='button' value='ANAMA'>";
                    // return '<a onclick="view_member(' . "'" .$user->id. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$memertext.'</a>'; 
                } else {
                    return '';
                }
            },
        }], */
        order: [
            [0, "DESC"]
        ]
    });
});

$(document).ready(function () {
    $('#UserTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/UserTable',
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
                data: 'member',
                name: 'member'
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
            },
         
        }],
    /*  columnDefs: [{
            targets: 5,
            render: function (data) {
                if (data != null) {
                    alert(data);
                   // return '<img src="'+ data+'" style="height:50px;width:50px;border-radius: 0px">';
                    // return "<input type='button' value='ANAMA'>";
                    // return '<a onclick="view_member(' . "'" .$user->id. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$memertext.'</a>'; 
                } else {
                    return '';
                }
            },
        }], */
        order: [
            [0, "DESC"]
        ]
    });
});



$(document).ready(function () {
    $('#ProfileTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/profiledatatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'profile_name',
                name: 'profile_name'
            }, {
                data: 'no_of_parameter',
                name: 'no_of_parameter'
            },{
                data: 'frq',
                name: 'frq'
            },{
                data: 'lab_report',
                name: 'lab_report'
            }, {
                data: 'action',
                name: 'action'
            }
        ],columnDefs: [{
            targets: 3,
            render: function (data) {
                            
                if (data != null) {
                    var path = $("#url_path").val() +'/frq'+"/"+data+"/3";
                    return '<a href="'+path+'" class="btn btn-primary">'+$("#view_frq_lable").val()+'</a>';
                } else {
                    return '';
                }
            }
        },{
            targets: 4,
            render: function (data) {
                            
                if (data != null) {
                    var path = $("#url_path").val() +'/storage/app/public/sample_report'+"/"+data;
                    return '<a href="'+path+'" class="btn btn-primary" target="_blank">'+$("#view_report").val()+'</a>';
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
     $('#PackageTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/package_datatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name',
                 render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            },{
                data: 'price',
                name: 'price'
            },{
                data: 'test_recommended_for',
                name: 'test_recommended_for'
            }, {
                data: 'status',
                name: 'status'
            }
            , {
                data: 'action',
                name: 'action'
            }
        ],columnDefs: [],
        order: [
            [0, "DESC"]
        ]
    });
  
});
 function showPackageDetails(name,parameterData, packageName ,sampleType, fastingTime, recommendedFor,report_time) {
   
    document.getElementById("packageTitle").innerHTML = `
        <strong>${name}:</strong> ${packageName}
        <br>
        <small style="font-size: 12px; display: block; margin-top: 5px;">
            <strong>Sample Type:</strong> ${sampleType} || 
            <strong>Fasting Time:</strong> ${fastingTime} || 
            <strong>Recommended For:</strong> ${recommendedFor} ||
            <strong>Report Time:</strong> ${report_time}
        </small>
    `;

    // Clear previous data
    let paramList = document.getElementById("parameterList");
    paramList.innerHTML = "";

    // Check if parameterData exists and is an array
    if (Array.isArray(parameterData) && parameterData.length > 0) {
        let tableHTML = `<table class='table table-bordered' style='font-size:10px; margin:0; padding:0; border-collapse: collapse; width:100%;'>
            <thead>
                <tr style='background:#f8f9fa;'>
                    <th style='padding:2px;'>Sr. No.</th><th style='padding:2px;'>Parameter</th>
                    <th style='padding:2px;'>Sr. No.</th><th style='padding:2px;'>Parameter</th>
                    <th style='padding:2px;'>Sr. No.</th><th style='padding:2px;'>Parameter</th>
                </tr>
            </thead>
            <tbody>`;

        for (let i = 0; i < parameterData.length; i += 3) {
            tableHTML += "<tr>";
            
            // First Column
            tableHTML += `<td style='padding:2px;'><small>${i + 1}</small></td>
                          <td style='padding:2px;'><small>${parameterData[i]}</small></td>`;

            // Second Column (Check if exists)
            if (parameterData[i + 1] !== undefined) {
                tableHTML += `<td style='padding:2px;'><small>${i + 2}</small></td>
                              <td style='padding:2px;'><small>${parameterData[i + 1]}</small></td>`;
            } else {
                tableHTML += "<td style='padding:2px;'></td><td style='padding:2px;'></td>"; // Empty cells
            }

            // Third Column (Check if exists)
            if (parameterData[i + 2] !== undefined) {
                tableHTML += `<td style='padding:2px;'><small>${i + 3}</small></td>
                              <td style='padding:2px;'><small>${parameterData[i + 2]}</small></td>`;
            } else {
                tableHTML += "<td style='padding:2px;'></td><td style='padding:2px;'></td>"; // Empty cells
            }

            tableHTML += "</tr>";
        }

        tableHTML += "</tbody></table>";
        paramList.innerHTML = tableHTML;
    } else {
        paramList.innerHTML = "<p style='font-size:10px;'>No parameters available.</p>";
    }

    // Show modal
    $("#packageDetailsModal").modal("show");
}

function view_member(id)
{
    // alert(id);
    // url: $("#url_path").val()+"/getmembersinfo"+"/"+id,
     $.ajax({
            // url: $("#path_admin").val()+"/getorderinfo"+"/"+id,
              url: $("#url_path").val()+"/getmembersinfo"+"/"+id,
            success: function( data ) {
                console.log(data);
                // alert(data.data_order.name);
    
              var txt="";
              var j=1;
              txt=txt+'<tbody><tr><th>#</th><th>'+$("#name_for_lable").val()+'</th><th>'+$("#phone_for_lable").val()+'</th><th>'+$("#age_for_lable").val()+'</th><th>'+$("#dob_for_lable").val()+'</th><th>'+$("#relation_for_lable").val()+'</th><th>'+$("#gender_for_lable").val()+'</th></tr>';
                for(var i=0;i<data.item_list.length;i++){

                    txt=txt+'<tr><td>'+j+'</td>';
                    txt=txt+'<td>'+data.item_list[i].name+'</td>';
                    txt=txt+'<td>'+data.item_list[i].mobile_no+'</td>';
                    txt=txt+'<td>'+data.item_list[i].age+'</td>';
                    txt=txt+'<td>'+data.item_list[i].dob+'</td>';
                    txt=txt+'<td>'+data.item_list[i].relation+'</td>';
                    txt=txt+'<td>'+data.item_list[i].gender+'</td></tr>';  
                    j++;
                }
            
                txt=txt+'</tbody>';
                 document.getElementById("itemdata").innerHTML=txt;
            }
        });

}

function view_address(id)
{   
    $.ajax({
            url: $("#url_path").val()+"/getaddress"+"/"+id,
            success: function( data ) {    
              var txt="";
              var j=1;
              txt=txt+'<tbody><tr><th>#</th><th>'+$("#add_for_lable").val()+'</th>';
                for(var i=0;i<data.item_list.length;i++)
                {
                     // alert(data.item_list[i].city);
                    txt=txt+'<tr><td>'+j+'</td>';
                    txt=txt+'<td>'+$("#house_no_lable").val()+' - '+data.item_list[i].house_no+'<br>'+$("#landmark_lable").val()+' - '+data.item_list[i].address+'<br>'+$("#pincode_lable").val()+' - '+data.item_list[i].pincode+'<br>'+data.item_list[i].city+','+data.item_list[i].state+'</td></tr>';  
                    j++;
                }
                txt=txt+'</tbody>';
                document.getElementById("addressdata").innerHTML=txt;
            }
        });
}


$(document).ready(function () {
    $('#FRQTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/frq_datatable/'+$("#package_id").val()+"/"+$("#type").val(),
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'question',
                name: 'question'
            }
            , {
                data: 'ans',
                name: 'ans'
            }, {
                data: 'action',
                name: 'action'
            }
        ],
        order: [
            [0, "DESC"]
        ]
    });
});

function edit_frq(id){
  $.ajax({
        url: $("#url_path").val()+"/getfrq"+"/"+id,
        method:"get",
        success: function( data ) {
            console.log(data);
            var str = JSON.parse(data);
            $("#edit_id").val(str.id);
            $("#edit_question").val(str.question);
            $("#edit_answer").val(str.ans);
        }
    });
}

$(document).ready(function () {
    $('#ParameterTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#url_path").val() + '/parameter_datatable',
        columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'name',
                name: 'name',
                 render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }
            , {
                data: 'short_desc',
                name: 'short_desc',
                 render: function(data) {
                    if (!data) {
                        return ''; // return blank if null, undefined, or empty
                    }
                    // Assuming memberName and relation are properties of the row object
                    return `<div style="width: 140px; white-space: normal; overflow-wrap: break-word;">${data}</div>`;
                }
            }, {
                data: 'mrp',
                name: 'mrp'
            },{
                data: 'frq',
                name: 'frq'
            },{
                data: 'lab_report',
                name: 'lab_report'
            }, {
                data: 'action',
                name: 'action'
            }
        ],columnDefs: [{
            targets: 4,
            render: function (data) {
                            
                if (data != null) {
                    var path = $("#url_path").val() +'/frq'+"/"+data+"/2";
                    return '<a href="'+path+'" class="btn btn-primary">'+$("#view_frq_lable").val()+'</a>';
                } else {
                    return '';
                }
            }
        },{
            targets: 5,
            render: function (data) {
                            
                if (data != null) {
                    var path = $("#url_path").val() +'/storage/app/public/sample_report'+"/"+data;
                    return '<a href="'+path+'" class="btn btn-primary" target="_blank">'+$("#view_report").val()+'</a>';
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

function changesubcategory(val){
   $.ajax({
        url: $("#url_path").val()+"/getsubcategorybycategory"+"/"+val,
        method:"get",
        success: function( data ) {            
            $("#subcategory_id").html(data);
        }
    });
}

function selecttesttype(type,id){
    $.ajax({
        url: $("#url_path").val()+"/gettestids"+"/"+type,
        method:"get",
        success: function( data ) {            
            $("#type_id_"+id).html(data);
        }
    });
}

function changepopulartype(val){
    if(val==""){
        alert("Please Select Vaild Type");
        $("#type_id").html("");
    }else{
         $.ajax({
            url: $("#url_path").val()+"/searchpopulartype"+"/"+val,
            method:"get",
            success: function( data ) {            
                $("#type_id").html(data);
            }
        });
    }
   
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
        if($("#is_demo_flag").val()=='1'){
            alert($("#admin_demo_msg").val());
        }else{
            window.location.href = url; 
        }                   
    } else {
        window.location.reload();
    }
}

function delete_user_detail(url){
    var msg = $("#record").val();
    // alert(url);
    if (confirm(msg)) {   
         if($("#is_demo_flag").val()=='1'){
            alert($("#admin_demo_msg").val());
         }else{
            window.location.href = url; 
         }                   
    } else {
        window.location.reload();
    }
}

$(document).ready(function () {
 $('#upload_image').on('change', function (e) {
    readURL(this, "basic_img");
  });
});


function readURL(input, field) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#basic_img1").val(e.target.result);
      $('#' + field).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function checkconfirmpassword(val){
    if(val!=$("#password").val()){
        alert($("#pass_match_msg").val());
        // alert("Password and Confirm Password Must Be Same");
        $("#cpassword").val("");
    }
}


  // Add row
  var row=1;
  $(document).on("click", "#add-row", function () {
       var rowst = document.querySelectorAll("#test-body tr");
    
      var rowCount = rowst.length;
      row = rowCount+1;
  var new_row = '<tr id="row'+row+'"><td><select class="form-control" name="testdetail['+row+'][type]" required onchange="selecttesttype(this.value,'+row+')"><option value="">'+$("#select_type_labal").val()+'</option><option value="1">'+$("#parameter_labal").val()+'</option><option value="2">'+$("#profile_labal").val()+'</option></select></td><td><select  onchange="updateTotalPrice();"  class="form-control select2t" name="testdetail['+row+'][type_id]" id="type_id_'+row+'"  required ><option value="">'+$("#select_test_labal").val()+'</option></select></td><td><input class="delete-row btn btn-primary" type="button" value="'+$("#delete_labal").val()+'" /></td></tr>';
    
  $('#test-body').append(new_row);
  row++;
   $('.select2t').select2({
            width: '100%',
            allowClear: true,
        });
        updateTotalPrice();
  return false;
  });
  
  // Remove criterion
  $(document).on("click", ".delete-row", function () {
  //  alert("deleting row#"+row);
    if(row>0) {
      $(this).closest('tr').remove();
      row--;
    }
      updateTotalPrice();
  return false;
  });


