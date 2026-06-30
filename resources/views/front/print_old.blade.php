<html>
    <head>
        <title></title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body style="margin-top:25px">
        <div class="col-md-12" style="float:left;width:100%">
             <div class="col-md-6" style="float:left;">
                 <img src="{{asset('public/img').'/'.$setting->logo}}" style="width:120px;height:75px;" />
             </div>
             <div class="col-md-6" style="float:right">
                 <div>{{__("message.site_name")}}</div>
                 <div>{{$setting->address}}</div>
                 <div>{{$setting->email}}</div>
                 <div>{{$setting->phone}}</div>
             </div>
        </div>
        
        <div class="col-md-12" style="float: left;margin-top: 10px;width:100%;margin-bottom:15px">
                  <div class="container">
                     
                     <div><b id="username"><?=Auth::user()->name?></b></div>
                     <div><b id="username">{{ $data->customer->name }}</b></div>
                     <div id="ordertime">{{ $data->customer->phone }}</div>
                     <div id="ordertime">{{$data->date.' '.$data->time}}</div>
                     <div>
                         {{$data->useraddressdetails->house_no}},{{$data->useraddressdetails->address}}
                     </br>
                     {{$data->useraddressdetails->city}},{{$data->useraddressdetails->state}}</br>{{$data->useraddressdetails->pincode}}
                     </div>
                     
                     
                  </div>
                  
                  <table class="table" id="itemdata">
                        <thead>
                                <tr>
                                  <th>{{__("message.Member Info")}}</th>
                                  <th>{{__("message.Item Info")}}</th>
                                  <th>{{__("message.Price")}}</th>
                                </tr>
                        </thead> 
                        <tbody>
                             @foreach($data->orderdata as $do)
                                    <tr>
                                       <td>
                                            {{$do->memberdetails->name}} | {{$do->memberdetails->relation}} </br>
                                            {{$do->memberdetails->gender}}
                                        </td>
                                      <td>
                                          Name : {{$do->item_name}}</br>
                                          Parameters : {{$do->parameter}}</br>
                                          MRP : {{$currency}}{{number_format($do->mrp,2,'.','')}}</br>
                                          Price : {{$currency}}{{number_format($do->price,2,'.','')}}</br>
                                      </td>
                                      <td>{{$currency}}{{number_format($do->price,2,'.','')}}</td>
                                    </tr>
                             @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <th>Visit Type</th>
                                <td>@if($data->visit_type == 0 )  Home Visit @else Lab Visit @endif</td>
                            </tr>
                            <tr>
                                <td></td>
                                <th>{{__("message.Subtotal")}}</th>
                                <td>{{$currency}}{{number_format($data->subtotal,2,'.','')}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <th>Wallet Discount</th>
                                <td>{{$currency}}{{$data->wallet_discount}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <th>Coupon Discount</th>
                                <td>{{$currency}}{{ $data->coupon_discount != '' ? $data->coupon_discount : 0 }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <th>{{__("message.Total")}}</th>
                                <th>{{$currency}}{{number_format($data->final_total,2,'.','')}}</th>
                            </tr>
                        </tfoot>
                </table>
               </div>
    </body>
    <script type="text/javascript">
    $(function(){
       window.print();
       setTimeout(window.close, 5000);
    });
</script>
</html>