<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <!-- Meta data -->
      <meta charset="UTF-8">
      <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
      <meta content="Laboratory Admin" name="description">
      <meta content="Freaktemplate" name="author">
      <meta name="keywords" content="">
      <title>{{__("message.Laboratory Manager Login")}}</title>
      <link rel="icon" href="https://spruko.com/demo/azea/Azea/assets/images/brand/favicon.ico" type="image/x-icon"/>
      <!--Bootstrap css -->
      <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <!-- Style css -->
      <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet" />
      <link href="{{ asset('public/assets/css/dark.css') }}" rel="stylesheet" />
      <link href="{{ asset('vassets/css/skin-modes.css') }}" rel="stylesheet" />
      <!-- Animate css -->
      <link href="{{ asset('public/assets/css/animated.css') }}" rel="stylesheet" />
      <!---Icons css-->
      <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
      <!-- Color Skin css -->
      <link id="theme" href="{{ asset('public/assets/colors/color1.css') }}" rel="stylesheet" type="text/css"/>
   </head>
   <body class="register-2">
      <div class="page">
         <div class="page-content">
            <div class="container">
               <div class="row">
                  <div class="col mx-auto">
                     <div class="row justify-content-center">
                        <div class="col-md-4">
                           <div class="text-center mb-5">
                              <img src="{{ asset('public/assets/images/brand/logo1.png')}}" class="header-brand-img desktop-lgo" alt="Azea logo">
                           </div>
                           <div class="card">
                              <div class="card-body">
                                 <div class="text-center mb-3">
                                    <h1 class="mb-2">{{__("message.log_in")}}</h1>
                                    <a href="javascript:void0;" class="">{{__("message.welcome_back")}}</a>
                                 </div>
                                 @if(Session::has('message'))
                                 <div class="col-sm-12">
                                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                       <span aria-hidden="true">&times;</span></button>
                                    </div>
                                 </div>
                                 @endif										
                                 <form class="mt-5" action="{{route('manager-postlogin')}}" method="post">
                                 	{{csrf_field()}}
                                    <div class="input-group mb-4">
                                       <div class="input-group-text"> <i class="fe fe-user"></i> </div>
                                      <input type="email" class="form-control" placeholder="{{__('message.email')}}" name="email" id="email" required="" value="{{isset($_COOKIE['email'])?$_COOKIE['email']:''}}">
                                    </div>
                                    <div class="input-group mb-4">
                                       <div class="input-group" id="Password-toggle1"> <a href="" class="input-group-text"> <i class="fe fe-eye" aria-hidden="true"></i> </a> <input type="password" class="form-control form-control-lg" placeholder="{{__('message.password')}}" name="password" id="password" required="" value="{{isset($_COOKIE['password'])?$_COOKIE['password']:''}}"> </div>
                                    </div>
                                    <div class="form-group"> <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input"> <span class="custom-control-label">{{__('message.remember_me')}}</span> </label> </div>
                                    <div class="form-group text-center mb-3"> <button class="btn btn-primary btn-lg w-100 br-7" type="submit">{{__("message.log_in")}}</button> </div>
                                    
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
      <!-- Bootstrap5 js-->
      <script src="{{ asset('public/assets/plugins/bootstrap/popper.min.js') }}"></script>
      <script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
      <!--Othercharts js-->
      <script src="{{ asset('public/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>
      <!-- Circle-progress js-->
      <script src="{{ asset('public/assets/js/circle-progress.min.js') }}"></script>
      <!-- Jquery-rating js-->
      <script src="{{ asset('public/assets/plugins/rating/jquery.rating-stars.js') }}"></script>
      <!-- Show Password -->
      <script src="{{ asset('public/assets/js/bootstrap-show-password.min.js') }}"></script>
      <!-- Custom js-->
      <script src="{{ asset('public/assets/js/custom.js') }}"></script>
   </body>
</html>