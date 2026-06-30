
            <div class="pricing-block-one">
              <div class="pricing-table">
                <!--<div class="box_badges" style="font-size:11px;">{{$pl->no_of_parameter}}<br/>Parameters</div>-->
                
                  <div class="box_badges" ><strong>{{round($discount)}}% </strong>off</div>
                
                
                <div class="table-header"> 
                  <h6 class="h2_text mb-2"><strong><a href="{{ route('profile', ['city'=>$cityName,'id' => $pl->slug ]) }}" style="text-decoration: none; color: inherit;">{{$pl->profile_name}}</a></strong></h6>
                 <small>
    <b>
        <mark>{{ sprintf('%02d', $pl->no_of_parameter) }}</mark> Parameters
    </b>
</small>
                </div>
                <div class="table-content">
                    @php
                    $arr = explode(",", $pl->paramater_data); // Convert the data to an array
                    $arr = array_slice($arr, 0, 8); // Limit to the first 8 items
                    $chunks = array_chunk($arr, 4); // Split into chunks of 4
                    @endphp
                    <div class="row" style="font-size:11px;line-height:17px;">
                        @foreach ($chunks as $chunk)
                            <div class="col-6" >
                                @foreach ($chunk as $arr)
                                <div style="display: flex; align-items: flex-start;">
                                <span style="margin-right: 5px;">&bull;</span> 
                                <span style="display: inline-block;">{{ $arr }}</span>
                                    
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('profile', ['city'=>$cityName,'id' => $pl->slug ]) }}" class="more-link">+ Know More</a>
                
                <?php $res_curr = explode("-", $setting->currency); ?>
                <div class="table-footer"> 
            		@if($pl->price > 0 )
                	<h3><span class="discount_price">{{$res_curr[1]}}{{number_format($pl->mrp,2,'.','')}}</span><br><span class="price">{{$res_curr[1]}}{{number_format($pl->price,2,'.','')}}</span>  </h3>
                    @else
                    <h3><span class="discount_price">{{$res_curr[1]}}{{number_format($pl->mrp,2,'.','')}}</span></h3>
                    @endif
                        <div class="btn-box">
                            <a href="{{ route('checkouts', ['id' => $pl->id, 'type' => 3, 'parameter' => $pl->no_of_parameter ?? '0']) }}"  class="book_now">
                                {{ __('message.Book Now') }}
                            </a>
                        </div>
                </div>
                
              </div>
            </div>
