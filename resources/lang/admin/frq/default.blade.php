@extends('admin.layout.index')
@section('title')
{{__("message.FRQ")}}
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">{{__("message.FRQ")}}</h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.FRQ")}}</li>
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
            <input type="hidden" name="package_id" id="package_id" value="{{$id}}">
            <input type="hidden" name="type" id="type" value="{{$type}}">
           
                 <button type="button" class="btn btn-secondary mt-3" data-bs-toggle="modal" data-bs-target="#normalmodal" style="margin-bottom: 25px;">{{__("message.Add FRQ")}}</button>
           
          
            <div class="table-responsive">
                 <table id="FRQTable" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	 <th>{{__("message.ID")}}</th>
                         <th>{{__("message.Question")}}</th>
                         <th>{{__("message.Answer")}}</th>
                         <th>{{__("message.Action")}}</th>
                     </tr>
                   	</thead>
                   	<tbody>                        
                   	</tbody>
                   	<tfoot>
                        <tr>
                           <th>{{__("message.ID")}}</th>
                           <th>{{__("message.Question")}}</th>
                           <th>{{__("message.Answer")}}</th>
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
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="normalmodal1">{{__("message.Add FRQ")}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form  action="{{route('update-frq')}}" method="post">
                      {{csrf_field()}}
                       <input type="hidden" name="package_id"  value="{{$id}}">
                       <input type="hidden" name="type" value="{{$type}}">
                       <input type="hidden" name="id" value="0">
                     <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                           <label class="form-label">{{__("message.Question")}}</label>
                           <textarea class="form-control" name="question" id="question" required="" placeholder="{{__('message.Enter Question')}}"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                           <label class="form-label">{{__("message.Answer")}}</label>
                           <textarea class="form-control" name="answer" id="answer" required="" placeholder="{{__('message.Enter Answer')}}"></textarea>
                        </div>
                     </div>               
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('message.Close')}}</button>
                      @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                  </div>
                  </form>
               </div>
            </div>
         </div>

         <div class="modal fade" id="editfrq" tabindex="-1" aria-labelledby="editfrq" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="normalmodal1">{{__('message.Edit FRQ')}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form  action="{{route('update-frq')}}" method="post">
                      {{csrf_field()}}
                       <input type="hidden" name="package_id"  value="{{$id}}">
                       <input type="hidden" name="type" value="{{$type}}">
                       <input type="hidden" name="id" id="edit_id" >
                     <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                           <label class="form-label">{{__("message.Question")}}</label>
                           <textarea class="form-control" name="question" id="edit_question" required="" placeholder="{{__('message.Enter Question')}}"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                           <label class="form-label">{{__("message.Answer")}}</label>
                           <textarea class="form-control" name="answer" id="edit_answer" required="" placeholder="{{__('message.Enter Answer')}}"></textarea>
                        </div>
                     </div>               
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('message.Close')}}</button>
                      @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                  </div>
                  </form>
               </div>
            </div>
         </div>
@endsection