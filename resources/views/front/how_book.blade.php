<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>timelines</title>
    <style>
        .timelines {
            position: relative;
            padding: 20px 0;
        }

        /* Horizontal line for desktop */
        .timelines::before {
            content: "";
            position: absolute;
            top: 35px;
            left: 10%;
            width: 80%;
            height: 3px;
            background: red;
            z-index: -1;
        }

        .timelines-steps {
            text-align: center;
            position: relative;
            /*background-color: pink;*/
            padding: 20px;
            border-radius: 10px;
        }

        .timelines-steps .icons {
            width: 35px;
            height: 35px;
            background: #e6ae05;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            margin: 0 auto 10px;
        }

        .timelines-steps span {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }
        .span {
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        .timelines-steps p {
            font-size: 12px;
            color: white;
        }

        /* Mobile: Vertical timelines */
        @media (max-width: 767px) {
            .timelines {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .timelines::before {
                display: none;
            }

            .timelines-steps {
                text-align: left;
                width: 100%;
                position: relative;
                padding-left: 55px;
            }

            .timelines-steps .icons {
                position: absolute;
                left: 11px;
            }

            .timelines-steps::after {
                content: "";
                position: absolute;
                left: 30px;
                top: 55px;
                height: 100%;
                width: 1px;
                border-left: 1px dashed #FFFFFF;
            }


            /* Remove last line */
            .timelines-steps:last-child::after {
                display: none;
            }
        }
        /* Add arrows between steps for larger screens */
@media (min-width: 768px) {
    .timelines-steps {
        position: relative;
    }

    .timelines-steps:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 50%;
        right: -10px; /* Adjust as needed */
        transform: translateY(-50%);
        width: 40px; /* Adjust width based on the arrow size */
        height: 100%; /* Full height */
        background: url('/public/right.png') no-repeat center;
        background-size: contain;
    }
}

    </style>
</head>
<body>
<section class="cta-section alternat-2 bg-color-2" >
    <div class="container-fluid p-2">
        <span class="span">How to book Full Body Checkup Package in {{$cityName}}</span>
        <div class="row justify-content-center timelines">
            <div class="col-12 col-md-2 timelines-steps">
                
                <div class="icons">1</div>
                <span>Booking Made Easy</span>
                <p>Book on our website or app, or request a Health Advisor callback.</p>
            </div>
            <div class="col-12 col-md-2 timelines-steps">
                <div class="icons">2</div>
                <span>Guidance</span>
                <p>Health Advisor & medical advisor provide guidance of testing process.</p>
            </div>
            <div class="col-12 col-md-2 timelines-steps">
                <div class="icons">3</div>
                <span>Sample Collection</span>
                <p>Enjoy free sample collection at home or office by expert phlebotomists.</p>
            </div>
            <div class="col-12 col-md-2 timelines-steps">
                <div class="icons">4</div>
                <span>Processing & Verify</span>
                <p>Your sample is transported, processed, and verified by our expert team.</p>
            </div>
            <div class="col-12 col-md-2 timelines-steps">
                <div class="icons">5</div>
                <span>Report and Support</span>
                <p>Receive AI-based Smart Reports with free consultations.</p>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
