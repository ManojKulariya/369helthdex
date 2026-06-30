function checkconfirmpassword(val){
    var error_msg = $("#password_match_error").val();
    if(val!=$("#password").val()){
        alert(error_msg);
        $("#cpassword").val("");
    }
}
 $('#us2').locationpicker({
    location: {
        latitude: $("#us2-lat").val(),
        longitude: $("#us2-lon").val()
    },
    radius: 300,
    inputBinding: {
        latitudeInput: $('#us2-lat'),
        longitudeInput: $('#us2-lon'),
        radiusInput: $('#us2-radius'),
        locationNameInput: $('#us2-address')
    },
    enableAutocomplete: true
});
 
 function storeorderfeedback(id){
        $("#feedback_order_id").val(id);
 }
 function fnGetPatientReport(TestRegnID) {
    if (TestRegnID > 0) {
        var url = $("#url_path").val() + "/reliable-report-download-api?testRegnID=" + TestRegnID;
        window.open(url, '_blank');
    } else {
        alert("Invalid Test Registration ID.");
    }
}

//  function fnGetPatientReport(TestRegnID) {
     
//     var LabID = "4bee96ca-3ea8-4e89-a575-04d2beed400c";
//     if (TestRegnID > 0) {
//         $.ajax({
//             cache: false,
//             type: "GET",
//             beforeSend: function() {
//             },
//             // url: 'https://reliabletest.elabassist.com/Services/Test_RegnService.svc/GetReleaseTestReport_Global',
            
//             url: 'http://reliable.elabassist.com/Services/Test_RegnService.svc/GetReleaseTestReport_Global',
//             data: {
//                 LabID: LabID,
//                 UserTypeID: 6,
//                 TestRegnID: TestRegnID,
//             },
//             dataType: 'json',
//             contentType: "application/json; charset=utf-8",
//             success: function(objresult) {
//                 if (objresult) {
//                     console.log(TestRegnID);
//                     console.log(objresult)
//                     var objres = objresult.d[0];
//                     if (objres) {
//                         if (objres.PdfName != "") {
//                             var filename = objres.PdfName.replace("../", "").replace("~", "");
//                             filename = 'http://reliable.elabassist.com/' + filename;
//                             alert(filename);
//                             // Force download using fetch and blob
//                             fetch(filename)
//                                 .then(response => {
//                                     if (!response.ok) {
//                                         throw new Error('Network response was not ok.');
//                                     }
//                                     return response.blob();
//                                 })
//                                 .then(blob => {
//                                     const url = window.URL.createObjectURL(blob);
//                                     const link = document.createElement('a');
//                                     link.href = url;
//                                     link.download = 'report.pdf'; // Customize the file name
//                                     document.body.appendChild(link);
//                                     link.click();
//                                     link.remove();
//                                     window.URL.revokeObjectURL(url); // Clean up
//                                 })
//                                 .catch(error => {
//                                     console.error('There was a problem with the fetch operation:', error);
//                                     alert("Error to Load PDF for Registration.");
//                                 });
                           
//                         } else {
//                             alert("Error to Load PDF for Registration.");
                           
                            
//                         }
//                     }
//                 } else {
//                     console.log('Error To retrieve Data');
//                     alert("Error to Load PDF for Registration.");
                    
//                 }
//             },
//             completed: function() {
                
//             },
//             error: function(result) {
//                 alert("Error to Load PDF for Registration");
//             }
//         });
//     }
// }



 $('#us2_edit').locationpicker({
    location: {
        latitude: $("#us2-lat-edit").val(),
        longitude: $("#us2-lon-edit").val()
    },
    radius: 300,
    inputBinding: {
        latitudeInput: $('#us2-lat-edit'),
        longitudeInput: $('#us2-lon-edit'),
        radiusInput: $('#us2-radius'),
        locationNameInput: $('#us2-address_edit')
    },
    enableAutocomplete: true
});
function closemodal(modalId) {
    $('#' + modalId).modal('hide');

    $('#' + modalId).one('hidden.bs.modal', function () {
        $('.modal-backdrop').remove(); // Forcefully remove the backdrop
    });
}


function addcart(id,mrp,price,parameter){
   var name = $("#package_name").html();
   var package_add_cart = $("#package_add_cart").val();
   // alert(package_add_cart);
   $.ajax({
        url: $("#url_path").val()+"/addcart",
        data : {id:id,name:name,parameter:parameter,price:price,mrp:mrp,user:'self'},
        method:"get",
        success: function( data ) {
            $("#totalcart").html(data);
            $("#msg").html('<div class="col-sm-12"><div class="alert  alert-success alert-dismissible fade show" role="alert">'+package_add_cart+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>');
        }
    });
}

function addnewsletter(){
     var email=$("#emailnews").val();
     var email_enter_error = $("#email_enter_error").val();
     if(email==""){
         alert(email_enter_error);   
     }else{
            if(ValidateEmail(email)){
                 $.ajax({
                            url: $("#url_path").val()+"/addnewsletter"+"/"+email,
                            method:"get",
                            success: function( data ) {
                               var thanks_msg = $("#thanks_msg").val();
                               $("#emailnews").val("");
                               alert(thanks_msg); 
                            }
                });
                
            }else{
                var email_invalid_err = $("#email_invalid_err").val();
                $("#emailnews").val("");
                alert(email_invalid_err);
            }
        
     }
}

function ValidateEmail(mail) 
{
  if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail))
  {
    return (true)
  }
  return (false)
}

function opennewpanel(current,next){
    $("#collapse"+current).removeClass("show");
    $("#collapse"+next).addClass("show");
}

function addprofilecart(id,mrp,price,parameter){
   var name = $("#profile_name").html();
    var package_add_cart = $("#package_add_cart").val();
   // alert(package_add_cart);
   $.ajax({
        url: $("#url_path").val()+"/addcart",
        data : {id:id,name:name,parameter:parameter,price:price,mrp:mrp,user:'self'},
        method:"get",
        success: function( data ) {
            $("#totalcart").html(data);
            $("#msg").html('<div class="col-sm-12"><div class="alert  alert-success alert-dismissible fade show" role="alert">'+package_add_cart+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>');
        }
    });
}

function addcustomizepackage(val){
    console.log($("#member_"+val).prop("checked"));
    if($("#member_"+val).prop("checked")==true){
        $.ajax({
                url: $("#url_path").val()+"/addcustomizepackage",
                data : {id:val},
                method:"get",
                success: function( data ) {
                   $("#member_on_cart").append(data.content);
                   $("#subtotal").html(data.subtotal);
                   $("#txt_charges").html(data.txt);
                   $("#main_total").html(data.main_total);

                }
        });
    }else{
        $.ajax({
                url: $("#url_path").val()+"/removecustomizepackage",
                data : {id:val},
                method:"get",
                success: function( data ) {
                   $("#cart_member_"+val).remove();
                   $("#subtotal").html(data.subtotal);
                   $("#txt_charges").html(data.txt);
                   $("#main_total").html(data.main_total);
                }
        });
    }
}

function deletecart(id){
        $.ajax({
                url: $("#url_path").val()+"/deletecart",
                data : {id:id},
                method:"get",
                success: function( data ) {
                   $("#itemcart"+id).remove();                   
                   $("#subtotal").html(data.subtotal);
                   $("#txt_charges").html(data.txt);
                   $("#main_total").html(data.main_total);
                }
        });
}

function removememberitemoncart(id,member_id){
        $.ajax({
                url: $("#url_path").val()+"/deletemembercart",
                data : {id:id},
                method:"get",
                success: function( data ) {
                   $("#member_"+id).remove();                   
                   $("#subtotal").html(data.subtotal);
                   $("#txt_charges").html(data.txt);
                   $("#main_total").html(data.main_total);
                   if(data.total_member_cart==0){
                        $("#cart_member_"+member_id).remove();
                   }
                   updatecoupon_and_wallet(data.subtotal);
                }
        });
}
function rvmmemberitemoncart(member_id){
    var member_id=member_id.value;
    var book_type_id = $('#book_type_id').val();
    // get cart ID----------
        $.ajax({
            url: $("#url_path").val()+"/getcart_id_ajax",
            data : {member_id:member_id,book_type_id:book_type_id},
            method:"get",
            success: function( data ) {
               if(data){
                    data.forEach(function(member){
                        var id = member;
                        $.ajax({
                            url: $("#url_path").val()+"/deletemembercart",
                            data : {id:id},
                            method:"get",
                            success: function( data ) {
                               $("#member_"+id).remove();                   
                               $("#subtotal").html(data.subtotal);
                               $("#txt_charges").html(data.txt);
                               $("#main_total").html(data.main_total);
                               if(data.total_member_cart==0){
                                    $("#cart_member_"+member_id).remove();
                               }
                               updatecoupon_and_wallet(data.subtotal);
                            }
                        });
                    });
               }
            }
        });
    // ---------------------
}
function addmemberdatas(){
        $.ajax({
            type: 'GET',
            url: $("#url_path").val()+'/update_user_family_ajax', // Get the form action URL
            data: $('#member_form').serialize(),
            success: function(response) {
                closemodal('add_members');
                if (response.success) {
                    let newMember = `
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="card-box-member">
                            <div class="row">
                                <div class="col-2">
                                    <input type="checkbox" id="family_member" onclick="this.checked ? addmemberitemoncart(this) : rvmmemberitemoncart(this)" name="family_member[]" value="${response.member.id}" class="yellow-radio" checked>
                                </div>
                                <div class="col-10">
                                    <label for="member_${response.member.id}" style="margin: 0;">
                                        <b>${response.member.name}</b> <br>
                                        ${response.member.relation}<br>
                                        ${response.member.gender} | ${response.member.age}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    $('.memberapend').append(newMember); // Append the new member to the list
                    var member = {
                        value: response.member.id // Use response.member.id as the value
                    };

                    addmemberitemoncart(member)
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Handle errors
            }
        });
     }
     
function updatecoupon_and_wallet(subtotal){
    // var subtotal = parseFloat($("#subtotal").html()) || 0;
    let cartItems = [];
            $(".cart-item").each(function () {
                cartItems.push({
                    type_id: $(this).data("typeid"),   // backend needs type_id
                    type: $(this).data("type"),   // Package / Parameter / Profile
                    price: parseFloat($(this).data("price")) || 0,
                    mrp: parseFloat($(this).data("mrp")) || 0
                });
            });
    var code= $("#cp_code").val();
    
    if(cp_code != ''){
        $.ajax({
        url: '/applycoupon/',
        type: 'GET',
        data: {
            code: code,
            subtotal: subtotal,
            cart: cartItems
        },
        dataType: 'json',
            success: function (data) {
                var wal_discount = parseFloat($("#wal_discount").html()) || 0; // Convert to float, default to 0 if NaN
                var final_total = subtotal - wal_discount - data; // Calculate final total
                
                $("#discount").html(data);
                $("#main_total").html(final_total.toFixed(2));
                 $(".coupon_dis").val(data);
                
            },
        });
    }
}
function addmemberitemoncart(family_members){
    
    var book_type = $('#book_type').val();
    var book_type_id = $('#book_type_id').val();
    var parameter = $('#parameter').val();
    var family_members=family_members.value;
    
        $.ajax({
            url: $("#url_path").val()+"/add_cart_member_ajax",
            data: { member: family_members,type:book_type,type_id:book_type_id,parameter:parameter},
            method:"get",
            success: function(data) {
                $("#subtotal").html(data.subtotal);
                $("#txt_charges").html(data.txt);
                $("#main_total").html(data.main_total);
                data.data.forEach(function(member) {
            let memberId = member.member_id;
            let memberTests = '';

            // Build HTML for member's tests
            member.testdata.forEach(function(test) {
                let discount = 0;
                let discountFixed = test.price && test.price ? test.price : 0;
                let discountPercentage = 0;

                if (test.price  > 0) {
                    discountPercentage = 100 *  (test.price - test.mrp)/test.price;
                }
                var dishtml = '';
                if(test.price  > 0){
                    dishtml = `<p><span style="${test.price > 0 ? 'text-decoration:line-through;color:#f9f9f9;' : ''}" >
                                    ${test.price}
                                </span> | <span style="color:#fff;">${test.mrp}</span></p>`;
                }else{
                   dishtml=`<p><span style="color:#fff;"> ${test.mrp}</span></p>`;
                }

                memberTests += `
                    <div class="row cart-item" 
                                 data-typeid="${test.type_id}" 
                                 data-parameter="${test.parameter}" 
                                 data-family_member_id="${memberId}" 
                                 data-type="${test.type}" 
                                 data-mrp="${test.mrp}"
                                 data-price="${test.price}"
                                 id="member_${test.id}" style="border-top: 1px solid white;">
                        <div class="col-md-9">
                            <p style="color: #ffffff;">${test.test_name}<br>
                            <small>Parameters Included : ${test.parameter}</small></p>
                            ${dishtml}
                        </div>
                        <div class="col-md-3">
                            ${test.price  > 0 ? `<p style="background: green;color: white; padding: 2px;">${Math.round(discountPercentage)}%</p>` : ''}
                            <span>
                                <a style="color: white;" href="javascript:void(0)" onclick="removememberitemoncart('${test.id}','${memberId}')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                `;
            });

            // Check if the member already exists in the cart
            if ($("#cart_member_" + memberId).length > 0) {
                // Member exists, update the HTML
                $("#cart_member_" + memberId).html(`
                    <div class="team-block-three">
                        <div class="inner-box">
                            <div class="lower-content" style="padding-top: 5px;padding-bottom: 5px;">
                                <ul class="name-box clearfix">
                                    <li class="name">
                                        <h5><a href="#">${member.member_name} | ${member.relation}</a></h5>
                                    </li>
                                </ul>
                                <span class="designation">${member.gender}, ${member.age} years</span>
                                ${memberTests}
                            </div>
                        </div>
                    </div>
                `);
            } else {
                // Member does not exist, append new entry
                $("#member_on_cart").append(`
                    <div class="col-xl-12 col-lg-12 col-md-12 doctors-block member_Cart" id="cart_member_${memberId}">
                        <div class="team-block-three">
                            <div class="inner-box">
                                <div class="lower-content" style="padding-top: 5px;padding-bottom: 5px;">
                                    <ul class="name-box clearfix">
                                        <li class="name">
                                            <h5><a href="#">${member.member_name} | ${member.relation}</a></h5>
                                        </li>
                                    </ul>
                                    <span class="designation">${member.gender}, ${member.age} years</span>
                                    ${memberTests}
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }
        });
                // Update cart summary if necessary
                if (data.total_member_cart == 0) {
                $("#cart_member_" + member_id).remove();
                }
                updatecoupon_and_wallet(data.subtotal);
                
            }
        });
}

function deletemember(id){
    var msg = $("#delete_member_err").val();
    if (confirm(msg)) { 
            window.location.href = $("#url_path").val()+"/deletememer"+"/"+id;
    } else {
        window.location.reload();
    }
}

function deleteaddress(id){
    var msg = $("#delete_address_err").val();
    if (confirm(msg)) { 
            window.location.href = $("#url_path").val()+"/deleteaddress"+"/"+id;
    } else {
        window.location.reload();
    }
}

function deletevisit(id){
    var msg = "do you want to delete!";
    if (confirm(msg)) { 
            window.location.href = $("#url_path").val()+"/deletevisit"+"/"+id;
    } else {
        window.location.reload();
    }
}

function editmember(id){
        $.ajax({
                url: $("#url_path").val()+"/getmember",
                data : {id:id},
                method:"get",
                success: function( data ) {
                   var str = JSON.parse(data);
                   $("#edit_id").val(str.id);
                   
                   $("#name").val(str.name);
                   $("#email").val(str.email);
                   $("#phone").val(str.mobile_no);
                   $("#age").val(str.age);
                   $("#dob").val(str.dob);
                   if($("#edit_gender_1").val()==str.gender){
                        $("#edit_gender_1").prop("checked",true);
                   }
                   if($("#edit_gender_2").val()==str.gender){
                        $("#edit_gender_2").prop("checked",true);
                   }
                   $('#edit_relation').val(str.relation).niceSelect('update');    
                }
        });
}

function editaddress(id){
       $.ajax({
                url: $("#url_path").val()+"/getaddress",
                data : {id:id},
                method:"get",
                success: function( data ) {
                    console.log(data);
                   var str = JSON.parse(data);
                   $("#edit_id").val(str.id);                   
                   $("#us2-lat-edit").val(str.lat);
                   $("#us2-lon-edit").val(str.long);
                   $("#us2-address_edit").val(str.address);
                //   $("#name").val(str.name);
                   $("#house_no").val(str.house_no);
                    
                   $("#state").val(str.state);
                   $("#pincode").val(str.pincode);
                   if($("#is_default_edit").val()==str.is_default){
                        $("#is_default_edit").prop("checked",true);
                   }  
                    $('#city').val(str.city); // Update city select dropdown value
            $('#name').val(str.name);
                //   $('#city').val(str.city).Select('update');  
                //   $('#name').val(str.name).Select('update');  
                     
                }
        });
}

function checkcurrentpassword(val){
    $.ajax({
        url: $("#url_path").val()+"/checkadminpassword"+"/"+val,
        method:"get",
        success: function( data ) {
            if(data==1){
                var msg = $("#currect_pass_err").val();
                alert(msg);
                $("#old_password").val("");
            }
        }
    });
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

function checkbothpassword(val){
    var msg = $("#new_con_pass_err").val();   
    var newpassword = $("#npassword").val();
    if(newpassword!=val){
        alert(msg);
        $("#npassword").val("");
        $("#cpassword").val("");
    }
}

function resetpassword(){
    $("#npassword").val("");
    $("#cpassword").val("");
    $("#old_password").val("");
}
$(function() {  
     $.ajax({
        url: $("#url_path").val()+"/getallpack",
        method:"get",
        success: function( data ) {
            var str = JSON.parse(data);
            var availableTags = [];  
            for(var i=0;i<str.length;i++){
                availableTags.push(str[i].name);
            }
            // $( "#tags" ).autocomplete({  
            //   source: availableTags,  
            //   minLength:1    
            // }); 
        }
    });
     
  });  
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

$('.brand-carousel-lab').owlCarousel({
        items: 1,  // Set the number of items to show
        loop: true,
        rtl: false,
        autoplay: true,
        nav: true,

        navText: ["<span class='carousel-nav-left'><i class='fa fa-chevron-left'></i></span>", "<span class='carousel-nav-right'><i class='fa fa-chevron-right'></i></span>"],
        dots: true,
        //	dotsClass: 'custom-dots',
    });
$(document).ready(function () {
    urlMap();
    var selectedCityId = $("#locationdata").val();

    const queryString = `id=${selectedCityId}`;
    const url = `/update-location-city?${queryString}`;

    fetch(url, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            // console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });

});

        function urlMap() {
            const url = `/get-map-url`;
            fetch(url, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    var testHTML = '<div class="class="row"> <div class="col-12  copyright pull-left" ><p style="color:#FFFFFF">'; // Store the HTML for the options
                    $.each(data.profile_test, function (index, test) {
                        // Use concatenation to build the HTML string correctly
                        var capitalizedData = test.data.charAt(0).toUpperCase() + test.data.slice(1).toLowerCase();


                        testHTML += '<a href="' + test.url + '" style="text-decoration: none;color: #FFFFFF;" class="uppercase-lineheight"><small>' + capitalizedData + ', </small></a>';
                    });
                    testHTML += '</p></div></div>';
                    $('#Browse_Popular_Blood_Tests').html(testHTML);


                    var pkgHTML = '<div class="class="row"> <div class="col-12  copyright pull-left" ><p style="color:#FFFFFF">'; // Store the HTML for the options
                    $.each(data.package_test, function (index, test) {
                        // Use concatenation to build the HTML string correctly
                        pkgHTML += '<a href="' + test.url + '" style="text-decoration: none;color: #FFFFFF;"><small>' + test.data + ', </small></a>';
                    });
                    pkgHTML += '</p></div></div>';
                    $('#Browse_Popular_Blood_Packages').html(pkgHTML);

                    var disHTML = '<div class="class="row"> <div class="col-12  copyright pull-left" ><p style="color:#FFFFFF">'; // Store the HTML for the options
                    $.each(data.package_disorder, function (index, test) {
                        // Use concatenation to build the HTML string correctly
                        disHTML += '<a href="' + test.url + '" style="text-decoration: none;color: #FFFFFF;"><small>' + test.data + '<span style="color: #999;"> / </span> </small>  </a>';
                    });
                    disHTML += '</p></div></div>';
                    $('#Browse_Tests_by_Lifestyl_Disorder').html(disHTML);

                    var cityHTML = '<div class="class="row"> <div class="col-12  copyright pull-left" ><p style="color:#FFFFFF">'; // Store the HTML for the options
                    $.each(data.city_test, function (index, test) {
                        // Use concatenation to build the HTML string correctly
                        cityHTML += '<a href="' + test.url + '" style="text-decoration: none;color: #FFFFFF;"><small>' + test.data + '<span style="color: #999;"> / </span> </small>  </a>';
                    });
                    cityHTML += '</p></div></div>';
                    $('#our_presence').html(cityHTML);
                })
        }
  function newurl(CityName) {
            const currentURL = window.location.href;

            // Split the URL by '/' to get an array of segments
            const urlSegments = currentURL.split('/');

            console.log(urlSegments);
            if (urlSegments.length <= 4) {
                location.reload();
            }
            if (urlSegments.length == 5) {
                urlSegments[urlSegments.length - 1] = CityName;
                const newURL = urlSegments.join('/');
                window.location.href = newURL;

            }
            if (urlSegments.length == 6) {
                urlSegments[urlSegments.length - 2] = CityName;
                const newURL = urlSegments.join('/');
                window.location.href = newURL;

            }
            if (urlSegments.length > 6) {
                location.reload();
            }

        }
        
   function onCityClick(selectedCityId, CityName) {
            const queryString = `id=${selectedCityId}`;
            const url = `/update-location-city?${queryString}`;

            fetch(url, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    newurl(CityName);

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        
function openCityModal() {
    document.getElementById("cityModal").style.display = "block";
}

function closeCityModal() {
    document.getElementById("cityModal").style.display = "none";
}

// JavaScript to handle city search
document.getElementById("citySearch").addEventListener("keyup", function () {
    var input, filter, cities, cityItem, i, txtValue;
    input = document.getElementById("citySearch");
    filter = input.value.toUpperCase();
    cities = document.querySelectorAll(".city-item");

    for (i = 0; i < cities.length; i++) {
        cityItem = cities[i];
        txtValue = cityItem.textContent || cityItem.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            cityItem.style.display = "";
        } else {
            cityItem.style.display = "none";
        }
    }
});
function getDirections(latitude, longitude) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var currentLatitude = position.coords.latitude;
                    var currentLongitude = position.coords.longitude;
                    var url = "https://www.google.com/maps/dir/" + currentLatitude + "," + currentLongitude + "/" + latitude + "," + longitude;
                    window.open(url, "_blank");
                }, function (error) {
                    
                });
            } else {
                // Geolocation is not supported by the browser
                console.log("Geolocation is not supported");
            }
        }
   $(document).ready(function () {
        $('.brand-offer').owlCarousel({
            loop: true,
            margin: 10,
            rtl: true,
            autoplay: true,
            autoplayTimeout: 5000,
            responsive: {


                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });

    });   
      // JavaScript for the slider functionality
    const images = document.querySelectorAll('.slider img');
    const dots = document.querySelectorAll('.slider-dot');
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((image, i) => {
            if (i === index) {
                image.style.display = 'block';
                dots[i].classList.add('active');
            } else {
                image.style.display = 'none';
                dots[i].classList.remove('active');
            }
        });
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function previousImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }

    function selectImage(index) {
        currentIndex = index;
        showImage(currentIndex);
    }

    showImage(currentIndex);

    setInterval(nextImage, 5000); // Change slide every 5 seconds
