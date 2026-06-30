@extends('front.layout')

@section('title')
Search Test
@stop
@section('content')
<section class="page-title-two">
 <style>
.clear_btn {
    background: none;
    border: none;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    color: #233646;
    text-align: center;
}
.clear_btn:focus {
    outline: none;
}
.btn_primary:focus {
    outline: none;
}
.btn_primary {
    background: none;
    border: none;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    color: #233646;
    text-align: center;
}
</style>
<?php 
$sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
$sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
?>
  <div class="lower-content">
    <div class="auto-container">
      <ul class="bread-crumb clearfix">
        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
        <li>Test List</li>
      </ul>
    </div>
  </div>
</section>
<section class="pricing-section bg-color-3 sec-pad pt-3">
<div class="auto-container">
<!---->
    <div class="clinic-block-one">
        <div class="inner-box" style="padding: 16px 16px 13px 13px !important;">
          <div class="form-group clearfix ">
            <div class="row justify-content-center align-items-center">
            <div class="row col-md-6">
                <input type="text" name="searchtags" id="searchtags" class="col-10" value="{{$searchText}}"  placeholder="Search Packages,Test by Name & tag" required="">
                <button type="button" id="clear-search" class="clear_btn col-1">X</button>
            </div>
            </div>
          </div>
        </div>   
        <div class="inner-content">
            <div class="row clearfix appendtest" id="results-container">
            </div>
        </div>
    </div>
    <!-- Results Section -->
    
    <div id="results-containerload" class="mt-4">  <!-- Search results will be appended here -->  </div>
    <div class="row justify-content-center align-items-center" id="show-more-container"></div>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    let typingTimer;                // Timer for debounce
    const debounceDelay = 400;      // Delay time in ms
    let currentPage = 1;
    console.log($('#searchtags').val());
    if($('#searchtags').val() != ''){
        clearTimeout(typingTimer); // Clear the timer to debounce
        typingTimer = setTimeout(function () {
            currentPage = 1; // Reset to the first page on new search
            $('#results-container').html('');
            $('#show-more-container').html('');
            fetchResults(1);
        }, debounceDelay);
    }

    // Live search on input
    $('#searchtags').on('input', function () {
        
        clearTimeout(typingTimer); // Clear the timer to debounce
        typingTimer = setTimeout(function () {
            currentPage = 1; // Reset to the first page on new search
            $('#results-container').html('');
            $('#show-more-container').html('');
            fetchResults(1);
        }, debounceDelay);
    });
    

    // Function to fetch results
    function fetchResults(page) {
        let searchText = $('#searchtags').val();
        let token = $('input[name="_token"]').val();
        // Skip AJAX if the search text is empty
        if (!searchText.trim()) {
            $('#results-container').html('');
            $('#show-more-container').html('');
            return;
        }
        $.ajax({
            url: "{{ route('searchtag') }}?page=" + page,
            type: "GET",
            data: {
                _token: token,
                tags: searchText
            },
            beforeSend: function () {
                $('#results-containerload').html('<p>Loading results...</p>');
            },
            success: function (response) {
                // console.log(response.output);
                $('#results-containerload').html('');
                // $('#results-container').append(renderResults(response.data));
                $('#results-container').append(response.output);
                if (response.next_page_url) {
                    currentPage++; // Increment the current page
                    $('#show-more-container').html(`
                        <button id="show-more-btn" class="btn_primary">Show More <i class="fa fa-angle-down" style="font-weight:800"></i></button>
                                      
                    `);
                } else {
                    $('#show-more-container').html(''); // Remove "Show More" button if no more pages
                }
            },
            error: function () {
                $('#results-container').html('<p>Something went wrong. Please try again.</p>');
            }
        });
    }

    // Function to render results
    function renderResults(data) {
        let html = '';
        console.log(data);

        if (data.length > 0) {
            data.forEach(function (item) {
                html += `
                    <div class="result-item">
                        <h5>${item.tag} (${item.profile_name || item.name})</h5>
                    </div>
                    <hr>
                `;
            });
        } else {
            html = '<p>No results found.</p>';
        }

        return html;
    }

    // Handle "Show More" button click
    $(document).on('click', '#show-more-btn', function () {
        fetchResults(currentPage); // Fetch data for the next page
    });
    $('#clear-search').on('click', function () {
        $('#searchtags').val(''); // Clear the input field
        $('#results-container').html('<p>Type to search...</p>'); // Reset the results
        $('#show-more-container').html('');
    });
});
</script>

@stop

@section('footer')

@stop