<div class="testimonial-block-two" >
    <div class="inner-box">
      <div class="text">
        <div class="location">
          <div class="loc_1"><?php echo substr($df->name, 0, 85) ?> </div>
        </div> 
        <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color:black;">
          <i class="fa fa-map-marker" style="color:#e6ae05;"></i><small> :{{ number_format($df->distance, 2) }} KM </small>
          <hr style="border: 0; border-top: 0.1px dashed black;margin-top:0;">
        </p>
        
        <!--<p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color:black;">-->
        <!--  <small><i class="fa fa-phone" style="color:#1F3E6D;"></i> :{{$df->phone}} </small>-->
        <!--</p>-->
        <div class="d-flex" style="min-height:90px;overflow: hidden;">
            <small><i class="fas fa-map" style="color:#e6ae05;"></i>&nbsp;</small>
            <span style=" color:black;"> :{{$df->address}}</span>
        </div>
        <div class="col-12 px-4 " style="background-color:white;align-items: center;text-align: center; "> 
                <a href="javascript:void(0)" onclick="getDirections({{$df->location['lat']}},{{$df->location['lng']}})"  class="book_now" 
                   style="display: inline-block; text-align: center;padding: 5px 21px;">
                    Get Direction
                </a>
         </div>
      </div>
        
      
    </div>
</div>