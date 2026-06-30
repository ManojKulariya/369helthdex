@extends('transport.layout.index')
@section('title')
Lab {{__("message.User")}}
@stop
@section('content')


<div class="page-header">
	<h3 class="page-title">Lab {{__("message.User")}} </h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('transport-admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Lab {{__("message.User")}}</li>
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
<a href="{{url('savelabuser/0')}}"  class="btn btn-success" style="margin-bottom: 10px">Add Lab User</a>
            <div class="table-responsive">
                 <table id="TransportUserTable" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	 <th>{{__("message.ID")}}</th>
                         <!--<th>{{__("message.Image")}}</th>-->
                         <th>{{__("message.Name")}}</th>
                         <th>{{__("message.email")}}</th>
                         <th>{{__("message.Member")}} Of</th>
                         <th>Role</th>
                         <th>{{__("message.Action")}}</th>
                     </tr>
                   	</thead>
                   	<tbody>                        
                   	</tbody>
                   	<tfoot>
                        <tr>
                           <th>{{__("message.ID")}}</th>
                           <!--<th>{{__("message.Image")}}</th>-->
                           <th>{{__("message.Name")}}</th>
                           <th>{{__("message.email")}}</th>
                           <th>{{__("message.Member")}} Of</th>
                           <th>Role</th>
                           <th>{{__("message.Action")}}</th>
                        </tr>
                     </tfoot>
                 </table>
              </div>
         </div>
       </div>
     </div>
</div>
  
  
  <div class="modal fade" id="normalmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content" style="width:110%; overflow: scroll;">
                  <div class="modal-header">
                     <h5 class="modal-title" id="normalmodal1">{{__("message.Family Members Detail")}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div>
                        <div class="container"style="margin-top: 13px;margin-bottom: 5px; ">
                          <h5 class="orderh">{{__("message.Family Members")}}</h5>
                        </div>
                        <table class="table" id="itemdata">
                           <tbody>
                              <tr>
                                 <th>#</th>
                                 <th>{{__("message.Name")}}</th>
                                 <th>{{__("message.Phone")}}</th>
                                 <th>{{__("message.Age")}}</th>
                                 <th>{{__("message.DOB")}}</th>
                                 <th>{{__("message.Relation")}}</th>
                                 <th>{{__("message.Gender")}}</th>
                              </tr>
                           </tbody>
                          </table>
                       </div>
                  </div>
            </div>
         </div>
  </div>

  <div class="modal fade" id="addressmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content" style="overflow: scroll;">
                  <div class="modal-header">
                     <h5 class="modal-title" id="normalmodal1">{{__("message.Address")}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div>
                        <div class="container"style="margin-top: 13px;margin-bottom: 5px; ">
                          <h5 class="orderh">{{__("message.User Address")}}</h5>
                        </div>
                        <table class="table" id="addressdata">
                           <tbody>
                              <tr>
                                 <th>#</th>
                                 <th>{{__("message.Address")}}</th>
                              </tr>
                           </tbody>
                          </table>
                       </div>
                  </div>
            </div>
         </div>
  </div>

@endsection

