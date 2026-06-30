@extends('admin.layout.index')
@section('title')
{{__("message.Save Package")}}
@stop
@section('content')
<div class="page-header">
   <h3 class="page-title">{{__("message.Save Package")}} </h3>
   <div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
      <ol class="breadcrumb float-sm-left">
      @else
      <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('show-package')}}">{{__("message.Package")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Save Package")}}</li>
      </ol>
   </div>
</div>
<div class="row" style="display: flex;justify-content: center;">
   <div class="col-md-9">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{__("message.Save Package")}}</h3>
         </div>
         <div class="card-body p-6">
            <div class="panel panel-primary">
               <div class=" tab-menu-heading p-0 bg-light">
                  <div class="tabs-menu1 ">
                     <!-- Tabs --> 
                     <ul class="nav panel-tabs">
                        <li class=""><a href="#tab5" class="<?=isset($tab)&&$tab==1?'active':''?>"  data-bs-toggle="tab">{{__("message.General Information")}}</a></li>
                        <li><a href="#tab6" data-bs-toggle="tab" class="<?=isset($tab)&&$tab==2?'active':''?>" >{{__("message.Lab Test Information")}}</a></li>
                        <li><a href="#tab8" data-bs-toggle="tab" class="<?=isset($tab)&&$tab==3?'active':''?>" >{{__("message.Test Information")}}</a></li>
                        <li><a href="#tab9" data-bs-toggle="tab" class="<?=isset($tab)&&$tab==9?'active':''?>" >Branch User</a></li>
                     </ul>
                  </div>
               </div>
               <div class="panel-body tabs-menu-body">
                  <div class="tab-content">
                     <div class="tab-pane <?=isset($tab)&&$tab==1?'active':''?>" id="tab5">
                        <form action="{{route('save-package-basic-info')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" id="id" value="{{$id}}">
                           <div class="form-group">
                              <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                              <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Package Name")}}' required="" value="{{isset($data->name)?$data->name:''}}">
                           </div>
                           <div class="form-group">
                              <label for="short_desc">{{__("message.Short Description")}}</label>
                              <input type="text" id="short_desc" name="short_desc" class="form-control" placeholder='{{__("message.Enter Short Description")}}'  value="{{isset($data->short_desc)?$data->short_desc:''}}">
                           </div>
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="inputStatus">{{__("message.Category")}}<span class="reqfield">*</span></label>
                                 <select id="category" name="category[]" required="" class="form-control select2" multiple  >
                                     <?php $arr = array();
                                     if(isset($data->category_id)){
                                           $arr = explode(",",$data->category_id);
                                           
                                     }
                              
                                    ?>
                                    <option value="">{{__("message.Select Category")}}</option>
                                    @foreach($category as $c)
                                    <option value="{{$c->id}}" <?=in_array($c->id,$arr)?'selected="selected"':''?>  >{{$c->name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="mrp">{{__("message.MRP")}}<span class="reqfield">*</span></label>
                                 <input type="number" step="0.00" id="mrp" name="mrp" class="form-control" placeholder='{{__("message.Enter MRP")}}' required="" value="{{isset($data->mrp)?$data->mrp:''}}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="price">{{__("message.Price")}}<span class="reqfield">*</span></label>
                                 <input type="number" step="0.00" id="price" name="price" class="form-control" placeholder='{{__("message.Enter Selling Price")}}' required="" value="{{isset($data->price)?$data->price:''}}">
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="name">{{__("message.Description")}}<span class="reqfield">*</span></label>
                              <textarea id="description" name="description" required class="ckeditor form-control">
                              {{isset($data->description)?$data->description:''}}
                              </textarea>                           
                           </div>
                           <div class="row">
                              <div class="col-12">
                                  @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                                 
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane <?=isset($tab)&&$tab==2?'active':''?>" id="tab6">
                        <form action="{{route('save-package-lab-info')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" id="id" value="{{$id}}">
                          
                           <div class="row">                              
                              <div class="form-group col-md-6">
                                 <label for="report_time">{{__("message.Report Time")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="report_time" name="report_time" class="form-control" placeholder='{{__("message.Enter Report Time")}}' required="" value="{{isset($data->report_time)?$data->report_time:''}}">
                              </div>
                           </div>

                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="sample_collection">{{__("message.Sample Collection")}}<span class="reqfield">*</span></label>
                                 <select id="sample_collection" name="sample_collection" class="form-control" required="" onchange="samplecollectionchange(this.value)">
                                      <option value="1" <?=isset($data->sample_collection)&&$data->sample_collection=='1'?'selected="selected"':''?> >{{__("message.Free")}}</option>
                                      <option value="2" <?=isset($data->sample_collection)&&$data->sample_collection=='2'?'selected="selected"':''?>>{{__("message.Paid")}}</option>
                                 </select>
                                 
                              </div>
                               @if(isset($data->sample_collection_fee))
                              <div class="form-group col-md-6" id="sample_collection_fee_div">
                              @else
                              <div class="form-group col-md-6" id="sample_collection_fee_div" style="display:none;">
                              @endif                                 
                              <label for="sample_collection_fee">{{__("message.Sample Collection Fee")}}<span class="reqfield">*</span></label>
                                <input type="text" id="sample_collection_fee" name="sample_collection_fee" class="form-control" placeholder='{{__("message.Enter Sample Collection Fee")}}'  value="{{isset($data->sample_collection_fee)?$data->sample_collection_fee:''}}">
                              </div>
                           </div>

                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="fasting_time">{{__("message.Is Fast Required")}}<span class="reqfield">*</span></label>
                                 <select id="fasting_time" name="fasting_time" class="form-control" required="" onchange="fasttimedivhcnage(this.value)">
                                      <option value="1" <?=isset($data->fasting_time)&&$data->fasting_time=='0'?'selected="selected"':''?> >{{__("message.No")}}</option>
                                      <option value="2" <?=isset($data->fasting_time)&&$data->fasting_time=='1'?'selected="selected"':''?> >{{__("message.Yes")}}</option>
                                 </select>
                                 
                              </div>
                               @if(isset($data->fast_time))
                              <div class="form-group col-md-6" id="fast_time_div">
                              @else
                              <div class="form-group col-md-6" id="fast_time_div" style="display:none;">
                              @endif
                                 <label for="fast_time">{{__("message.Fast Time")}}<span class="reqfield">*</span></label>
                                <input type="text" id="fast_time" name="fast_time" class="form-control" placeholder='{{__("message.Enter Fast Time")}}'  value="{{isset($data->fast_time)?$data->fast_time:''}}">
                              </div>
                           </div>

                           <div class="row">
                             <div class="form-group col-md-6">
                                 <label for="test_recommended_for">{{__("message.Test Recommended For")}}<span class="reqfield">*</span></label>
                                 <?php $arr = array(); isset($data->test_recommended_for)?$arr = explode(",",$data->test_recommended_for):''; ?>
                                 <select id="test_recommended_for" name="test_recommended_for[]" class="form-control" required="" multiple>
                                      <option value="Male" <?=isset($data->test_recommended_for)&&in_array("Male", $arr)?'selected="selected"':''?> >{{__("message.Male")}}</option>
                                      <option value="Female" <?=isset($data->test_recommended_for)&&in_array("Female", $arr)=='Female'?'selected="selected"':''?> >{{__("message.Female")}}</option>

                                 </select>
                                
                              </div>

                              <div class="form-group col-md-6">
                                 <label for="test_recommended_for_age">{{__("message.Recommended For Age")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="test_recommended_for_age" name="test_recommended_for_age" class="form-control" placeholder='{{__("message.Enter Age Recommended For Report")}}' required="" value="{{isset($data->test_recommended_for_age)?$data->test_recommended_for_age:''}}">
                              </div>
                           </div>

                          <div class="form-group ">
                              <label class="realted_package">{{__("message.Realted Package")}}</label>
                                 <select class="form-control select2" name="realted_package[]"  data-placeholder="Choose Browser" multiple>
                                    @foreach($packages as $p)
                                    <option value="{{$p->id}}">
                                       {{$p->name}}
                                    </option>
                                   @endforeach
                                 </select>
                              </div>
                           <div class="form-group">
                                <label for="lab_report">{{__("message.Sample Lab Report")}}<span class="reqfield">*</span></label>
                                 <input type="file" id="lab_report" name="lab_report" class="form-control"  required="">
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                                 
                              </div>
                           </div>
                        </form>
                     </div>
                     
                     <div class="tab-pane <?=isset($tab)&&$tab==3?'active':''?>" id="tab8">
                        <form action="{{route('save-package-test-info')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" id="id" value="{{$id}}">
                           
                           <input id='add-row' class='btn btn-primary' type='button' value='{{__("message.Add Profile")}}' />
                             
                              <div class="row" style="margin-left: -15px">
                                <div class="table-responsive">
                                  <table id="test-table" class="table table-condensed">
                                    <thead>
                                      <tr>
                                        <th>{{__("message.Test Type")}}</th>
                                        <th>{{__("message.Test Id")}}</th>
                                      </tr>
                                    </thead>
                                   
                                    <tbody id="test-body">
                                       <?php $i=0;?>
                                    @if(count($test_details)>0)
                                        @foreach($test_details as $td)
                                        <tr id="row{{$i}}">                                       
                                        <td>
                                          <select class="form-control" name="testdetail[{{$i}}][type]" required onchange="selecttesttype(this.value,'{{$i}}')">
                                             <option value="">{{__("message.Select Type")}}</option>
                                             <option value="1" <?=$td->type==1?'selected="selected"':''?> >Parameter</option>
                                             <option value="2" <?=$td->type==2?'selected="selected"':''?>>Profile</option>
                                          </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="testdetail[{{$i}}][type_id]" id="type_id_{{$i}}"  required >
                                              <option value="">{{__("message.Select Test")}}</option>
                                              @if($td->type==1)
                                                   @foreach($get_all_paramter as $a)
                                                     <option value="{{$a->id}}" <?=$td->type_id==$a->id?'selected="selected"':''?>>{{$a->name}}</option>
                                                   @endforeach
                                              @else
                                                  @foreach($get_profiles as $a)
                                                     <option value="{{$a->id}}" <?=$td->type_id==$a->id?'selected="selected"':''?>>{{$a->profile_name}}</option>
                                                   @endforeach
                                              @endif
                                            </select>
                                        </td>
                                        <td>
                                          <input class='delete-row btn btn-primary' type='button' value='{{__("message.Delete")}}' />
                                        </td>
                                      </tr>
                                          <?php $i++;?>
                                        @endforeach
                                    @else
                                      <tr id="row0">                                       
                                        <td>
                                          <select class="form-control" name="testdetail[0][type]" required onchange="selecttesttype(this.value,'0')">
                                             <option value="">{{__("message.Select Type")}}</option>
                                             <option value="1">{{__("message.Parameter")}}</option>
                                             <option value="2">{{__("message.Profile")}}</option>
                                          </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="testdetail[0][type_id]" id="type_id_0"  required >
                                              <option value="">{{__("message.Select Test")}}</option>
                                                @foreach($get_all_paramter as $a)
                                                  <option value="{{$a->id}}">{{$a->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                          <input class='delete-row btn btn-primary' type='button' value='{{__("message.Delete")}}' />
                                        </td>
                                      </tr>
                                    @endif
                                    <input type="hidden" name="total_test_no" id="total_test_no" value="{{$i}}">
                                    </tbody>
                                  </table>
                                  
                                </div>
                              </div>
                         
                           <div class="row">
                              <div class="col-12">
                                  @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane <?=isset($tab)&&$tab==9?'active':''?>" id="tab9">
                        <form action="{{route('save-package-branch-info')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" id="id" value="{{$id}}">
                           
                         <div class="form-group">
                               
                                <div class="row">
                                <input type="checkbox" id="check-all" onclick="toggleCheckboxes(this)">
                                <label for="check-all">Check All</label>
                                
                                </div>
                               <?php $arruser = array();
                                     if(isset($data->branch_id)){
                                           $arruser = explode(",",$data->branch_id);
                                     }
                              
                               ?>
                                    @foreach($branch as $row)
                                    
                                        <label class="form-label">{{ $row->name }} -  {{ $row->company_name}}</label>
                                        <input type="checkbox" name="branch_id[]" <?= in_array($row->id, $arruser) ? 'checked="checked"' : '' ?> value="{{ $row->id }}">
                               
                                    @endforeach
                                
                           </div> 
                         
                           <div class="row">
                              <div class="col-12">
                                  @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
    function toggleCheckboxes(source) {
        var checkboxes = document.getElementsByName('branch_id[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
@endsection