@extends('front.layout')
@section('title', trans('Delete Account'))

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>#header {
    background-color: #fef3e9;
    border-bottom: 1px solid #ddd;
    padding: 30px;
    text-align: center;
    color: #666;
    font-size: 30px;
  }

  #contents {
    padding: 0px 20px 20px 20px;
    text-align: center;
    font-size: 18px;
  }

  #content a {
    color: #3e68ff;
  }

  #getstarted {
    border-radius: 10px;
    font-size: 18px;
    max-width: 800px;
    margin: 10px auto 20px auto;
    padding: 10px;
    color: #444;
  }
  
  #getstarted-top{
    border-radius: 10px;
    font-size: 18px;
    max-width: 800px;
    margin: 20px auto 0px auto;
    padding: 10px;
    color: #444;
  }

  .section {
    margin-bottom: 40px;
    padding: 0 20px;
  }

  h2 {
    font-size: 20px;
    font-weight: normal;
  }

  h2 a {
    text-decoration: none;
  }

  .section p {
    font-size: 14px;
  }

  #footer {
    padding: 20px;
    text-align: center;
    font-size: 12px;
    color: #888;
    max-width: 540px;
    margin-left: auto;
    margin-right: auto;
  }

  #footer a {
    color: #555;
  }

  .container-delete {
    margin-top: 20px;
    max-width: 750px;
    margin: 0px auto;
  }

  .link-img-width{
    width: 200px;
  }

  .img-size{
    text-align: center;
    margin: 15px auto;
    height: 500px;
  }

  .col-6 b{
    font-size: 18px;
  }

  @media screen and (max-width: 576px) {

    .img-size{
      text-align: center;
      margin: 15px auto;
      height: 300px;
    }

    .col-6{
      padding-left: 5px;
      padding-right: 5px;
    }
  
    .col-6 b{
      font-size: 14px;
    }

    .link-img-width{
      width: 120px;
    }
  }


  @media screen and (max-width: 375px) {

    .img-size{
      text-align: center;
      margin: 15px auto;
      height: 200px;
    }

    .col-6{
      padding-left: 5px;
      padding-right: 5px;
    }
  
    .col-6 b{
      font-size: 14px;
    }

    .link-img-width{
      width: 120px;
    }
  }
</style>
</head>
<body>
    <div class="termsCondtion">
        <!-- Header Component -->
        <header>
            <!-- Include your header content here -->
        </header>

        <div class="container page-container">
            <div id="contents">
                <div id="getstarted-top">
                    <h3>Steps to Delete Account</h3>
                    It is very painful to see you go. However, we are here to help you out.
                </div>
            </div>
            <div id="contents" class="container-delete">
                <b>Deleting your account will delete the following,</b>
            </div>
            <div class="container-delete row">
                <div class='col-6'>
                    <b>369 HealthDex App:</b>
                    <ol style="list-style: square;">
                        <li>Delete your account from 369 HealthDex</li>
                    </ol>
                </div>
            </div>

            <div id="contents">
                <div id="getstarted">
                    <b>Please follow the below steps to delete your account</b>
                    <br><br>
                    Step 1. Open the 369 HealthDex app on your mobile phone. If the app is not installed, please install the app
                    first using the link below. You can also visit the Google Play Store or Apple App Store and search 369 HealthDex to
                    install the app.
                    <div class="row">
                        <div class="row-6">
                            <b>369 HealthDex App Links</b>
                            <div style="display: flex; justify-content: center; gap: 15px; margin: 15px auto;">
                                <a href="#" target="_blank">
                                    <img class="link-img-width" alt="Get it on Google Play" src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png">
                                </a>
                                <a href="#" target="_blank">
                                    <img class="link-img-width" style="padding: 6px 0px;" alt="Get it on App Store" src="https://propertytouchgroup.com/assets/uploads/deleteAcoount/app-store.png">
                                </a>
                            </div>
                        </div>
                    </div>

                    <br>
                    Step 2. Login into the app. If already logged in, you will be redirected to the home screen in the app.
                    <br><br>
                    Step 3. Please click on the top right button. It will redirect you to the my profile screen in the app.
                    <br>
                    <div class='row'>
                        <div class='row-6'>
                            <b>369 HealthDex App</b><br>
                            <img class='img-size' alt="369 HealthDex" src="https://HealthDex 369oratory.com/public/assets/uploads/deleteAcoount/ss.jpeg">
                        </div>
                    </div>

                    <br><br>
                    Step 4. In the my profile screen, please click on <b>Delete Account</b>. Then, a confirmation dialog will open. Click on <b>Yes</b>.
                    <br>
                    <div class='row'>
                        <div class='row-6'>
                            <b>369 HealthDex App</b><br>
                            <!--<img class='img-size' alt="369 HealthDex" src="https://HealthDex 369oratory.com/assets/uploads/deleteAcoount/ss.jpeg">-->
                        </div>
                    </div>
                    <br><br>
                    <!--<img class='img-size' alt="369 HealthDex" src="https://HealthDex 369.com/assets/uploads/deleteAcoount/img3.png">-->
                    <br><br>
                    It will redirect you to the login screen. Now your account and data have been deleted.
                    <br><br>
                    You can sign up again if you wish to come back in the future.
                </div>
            </div>
        </div>

        <!-- Footer Component -->
        <footer>
            <!-- Include your footer content here -->
        </footer>
    </div>
</body>
</html>

@endsection
