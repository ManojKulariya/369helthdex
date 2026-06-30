@extends('manager.layout.index')
@section('title')
{{__("message.Orders List")}}
@stop
@section('content')
<style>
        .custom-select {
            /* Add your desired styling here */
            background-color: #f2f2f2;
            color: #333;
            border: 1px solid #ccc;
            padding: 2%;
            font-size: 14px;
        } 
        .applied-coupon {
            background-color: #4CAF50; 
            color: green;
        }
        .cards-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            max-width: 800px;
            padding:2%;
        }

        .cardcp {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2%;
            text-align: center;
            transition: transform 0.2s;
        }

        .cardcp:hover {
            transform: translateY(-5px);
        }

        .coupon-code {
            font-weight: bold;
        }

        .coupon-value {
            color: #4CAF50;
            margin: 3% 0;
        }

        .coupon-type {
            color: #888;
            padding: 2%;
            overflow:hidden;
        }
    </style>

<div class="page-header">
   <h3 class="page-title">{{__("message.Orders List")}}</h3>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Orders List")}}</li>
      </ol>
   </nav>
</div>
<div class="row">
   <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
         <div class="card-body">
            @if(Session::has('message'))
            <div class="col-sm-12">
               <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            </div>
            @endif
            <div class="table-responsive">
               <table  class="table table-bordered text-nowrap dataTable no-footer">
                     @php
                      $total = 0;
                     @endphp
                     <tr>
                        <th>Order Id</th> 
                        <th>Test Name</th>
                        <th>Member</th>
                        <th>{{__("message.Test Type")}}</th>
                        <th>{{__("message.Parameter")}}</th>
                        <th>{{__("message.MRP")}}</th>
                        <th>{{__("message.Price")}}</th>
                     </tr>

                     @foreach($cart as $row)
                     <tr>
                     <?php $total = $total+$row['price']; ?>

                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['test_name'] }}</td>
                        <td>{{ isset($row['member_name']) ? $row['member_name'] : 'Not set' }}</td>

                        <td>
                           @if($row['type'] ==1 )
                              Package
                           @elseif($row['type'] ==2)
                              Parameter
                           @else
                              Profile
                           @endif
                        </td>
                        <td>{{ $row['parameter'] }}</td>
                        <td>{{ $row['mrp'] }}</td>
                        <td>{{ $row['price'] }}</td>
                        
                     </tr>
                     @endforeach
                  
                  
               </table>
            </div>
            
         </div>
      </div>
     
   </div>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Enter coupon code" id="CodeCoupon" >
        <div class="input-group-append">
          <button class="btn btn-primary" type="button" onclick="applyCoupon()" >Apply Coupon</button>
        </div>
      </div>
    </div>
  </div>
</div>
   
                  <div class="col-xl-12 col-lg-12 col-md-12 doctors-block" style="margin-top: 10px; padding:3%;">
                     <div class="team-block-three">
                        <div class="inner-box">
                           <div class="lower-content">
                              <ul class="name-box clearfix">
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-8">
                                          <h5><a href="#">{{__('message.Sub Total')}}</a></h5>
                                       </div>
                                       <div class="col-4">
                                          <p style="float: right;">{{$currency}}<span id="subtotal">{{number_format($total,2,'.','')}}</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-8">
                                          <h5><a href="#">Coupon Discount</a></h5>
                                       </div>
                                       <div class="col-4">
                                          <p style="float: right;">{{$currency}}<span id="discount">0</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <!-- <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <h3><a href="#">Wallet Point Discount</a></h3>
                                       </div>
                                       <div class="col-md-4">
                                          <p style="float: right;">{{$currency}}<span id="wal_discount">0</span></p>
                                       </div>
                                    </div>
                                 </li> -->
                                 <!--<li class="name"  >-->
                                 <!--   <div class="row">-->
                                 <!--      <div class="col-8">-->
                                 <!--         <h5><a href="#">Tax</a></h5>-->
                                 <!--      </div>-->
                                 <!--      <div class="col-4">-->
                                 <!--         <?php $txt = ($total*$setting->txt_charge)/100;?>-->
                                 <!--         <p style="float: right;">{{$currency}}<span id="txt_charges">{{number_format($txt,2,'.','')}}</span></p>-->
                                 <!--      </div>-->
                                 <!--   </div>-->
                                 <!--</li>-->
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-8">

                                          <h3><a href="#">{{__('message.Total')}}</a></h3>
                                       </div>
                                       <div class="col-4">
                                          <!--<?php $final_total =  $total + $txt;?>-->
                                          <?php $final_total =  $total;?>
                                          <p style="float: right;">{{$currency}}<span id="main_total">{{number_format($final_total,2,'.','')}}</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <?php if( $order_status->payment_method != "cod" ) { ?>
                                    <li class="name" style="display: list-item;">
                                        <div class="row">
                                           <div class="col-8">
    
                                              <h3><a href="#">Extra Payable Amount</a></h3>
                                           </div>
                                           <div class="col-4">
                                              <?php $final_total =  $total + $txt;?>
                                              <p style="float: right;">{{$currency}}<span id="main_total_extra">{{number_format($final_total,2,'.','') - $order_status->final_total}} </span></p>
                                           </div>
                                        </div>
                                    </li>
                                 <?php } ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
  
 <input name="coupon_id" type="hidden"  id="coupon_id">
 <input name="book_test" type="hidden" id="book_test" value="{{json_encode($cart);}}">
 <input name="final_total" type="hidden" id="final_total_vl" value="{{$final_total}}">
 <input name="subtotal" type="hidden"  id="subtotal_vl" value="{{$total}}">
 <input name="order_id" type="hidden" id="order_id_vl" value="{{ $order_id}}">
 <input name="tax" type="hidden" id="tx" value="{{$txt}}">

 <button type="submit" class="btn btn-success" id="verifyButton">Check Out</button>



</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $(document).ready(function() {
        $('#verifyButton').click(function() {
            var coupon_id = $('#coupon_id').val();
            var book_test = $('#book_test').val();
            var final_total = $('#final_total_vl').val();
            var subtotal = $('#subtotal_vl').val();
            var tx = $('#tx').val();
            var order_id = $('#order_id_vl').val();
            var subtotal_payment = <?php echo $order_status->final_total; ?> ;
           
            var payment_mode = '<?php echo $order_status->payment_method; ?>';
            console.log(subtotal_payment);
            console.log(final_total);
            if(payment_mode == "ccavenue"){
                if(subtotal_payment > final_total){
                    alert('in online payment can not check out if new payable amount is less then your paid amount');
                }else{
                    $.ajax({
                    url: 'sampleboy_by_check_out',
                    type: 'GET',
                    data: { tax:tx,order_id:order_id,coupon_id: coupon_id,book_test:book_test ,final_total:final_total,subtotal:subtotal},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            window.location.href = '{{ route("manager-orders") }}';
                        } else {
                         alert('something went wrong');
                        }
                    },
                    
                });
                }
            }else{
            

                $.ajax({
                    url: 'sampleboy_by_check_out',
                    type: 'GET',
                    data: { tax:tx,order_id:order_id,coupon_id: coupon_id,book_test:book_test ,final_total:final_total,subtotal:subtotal},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            window.location.href = '{{ route("manager-orders") }}';
                        } else {
                         alert('something went wrong');
                        }
                    },
                    
                });
        }
        });
    });

  function applyCoupon() {
        var subtotal = <?php echo $final_total; ?>  ;
        var book_test = $('#book_test').val();
        var couponId = $('#CodeCoupon').val();
        $.ajax({
            url: 'applycoupons',
            type: 'GET',
            data: {
                id: couponId,
                subtotal: subtotal,
                book_test:book_test
            },
            dataType: 'json',
                success: function (data) {
          //console.log(data);
             
                var final_total_pre = <?php echo $order_status->final_total; ?>;
                var final_total = <?php echo $final_total; ?>  - data ;
                var main_total_extra = final_total - final_total_pre;
                 $("#discount").html(data);
                 $("#main_total").html(final_total.toFixed(2));
                 $("#main_total_extra").html(main_total_extra.toFixed(2));
                    $("#coupon_id").val(couponId);
           
                },
            });
  }

   function toggleCoupon(couponId,price,type,value) {
            var subtotal = <?php echo $final_total; ?>  ;
            var book_test = $('#book_test').val();

            $.ajax({
            url: 'applycoupons',
            type: 'GET',
            data: {
                id: couponId,
                subtotal: subtotal,
                book_test:book_test
            },
            dataType: 'json',
                success: function (data) {
                    
                    console.log(data);
                  //  if(data != 0){
            const cards = document.querySelectorAll('.cardcp');
            cards.forEach(card => {
                card.classList.remove('applied-coupon');
                const button = card.querySelector('.apply-button');
                button.innerText = 'Apply coupon';
            });

            const selectedCard = document.getElementById(`coupon${couponId}`);
            console.log(selectedCard);
            if (selectedCard) {
                selectedCard.classList.add('applied-coupon');
                const button = selectedCard.querySelector('.apply-button');
                button.innerText = 'Applied';
                const couponCode = selectedCard.querySelector('.coupon-code').innerText;
                const couponValue = selectedCard.querySelector('.coupon-value').innerText;
                const couponType = selectedCard.querySelector('.coupon-type').innerText;
                
             
                var final_total_pre = <?php echo $order_status->final_total; ?>;
              var final_total = <?php echo $final_total; ?>  - data ;

                 $("#discount").html(data);
                 $("#main_total").html(final_total.toFixed(2));
                 $("#main_total_extra").html(final_total.toFixed(2) - final_total_pre) ;
                 $("#coupon_id").val(couponId);
           // }
                    }
                },
            });
            
        }
</script>
@endsection