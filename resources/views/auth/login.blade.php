<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Log In</title>
        <link rel="icon" href="{{url('img/logo.png') }}" type="image/png" />

        <link rel="stylesheet" href="{{url('css/bootstrap.min.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/themefy_icon/themify-icons.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/swiper_slider/css/swiper.min.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/select2/css/select2.min.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/niceselect/css/nice-select.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/owl_carousel/css/owl.carousel.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/gijgo/gijgo.min.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/font_awesome/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{url('vendors/tagsinput/tagsinput.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/datepicker/date-picker.css') }}" />

        <link
        rel="stylesheet"
        href="{{url('vendors/datatable/css/jquery.dataTables.min.css') }}"
        />
        <link
        rel="stylesheet"
        href="{{url('vendors/datatable/css/responsive.dataTables.min.css') }}"
        />
        <link
        rel="stylesheet"
        href="{{url('vendors/datatable/css/buttons.dataTables.min.css') }}"
        />

        <link rel="stylesheet" href="{{url('vendors/text_editor/summernote-bs4.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/morris/morris.css') }}" />

        <link rel="stylesheet" href="{{url('vendors/material_icon/material-icons.css') }}" />

        <link rel="stylesheet" href="{{url('css/metisMenu.css') }}" />

        <link rel="stylesheet" href="{{url('css/style.css') }}" />
        <link rel="stylesheet" href="{{url('css/colors/default.css') }}" id="colorSkinCSS" />
    </head>
    <body class="admin_login">
        <div class="col-lg-12">
            <div class="mb_30 mt_30">
                <div class="login_card">
                    <div class="col-lg-6" style="box-shadow: 20px 50px 50px -12px rgba(0, 0, 0, 0.25);">
                        <div class="modal-content cs_modal">
                            <div class="modal-header justify-content-center theme_bg_1">
                                <h5 class="modal-title text-white">Log in</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('login') }}" method="POST" id="loginForm">
                                    @csrf
                                    <div class="">
                                        <input type="text" name="email" class="form-control" placeholder="Enter your email" style="border-radius: 1000px; border-color: cornflowerblue;">
                                    </div>
                                    <div class="">
                                        <input type="password" name="password" class="form-control" placeholder="Password" style="border-radius: 1000px; border-color: cornflowerblue;">
                                    </div>
                                    
                                    <button type="submit" class="btn_1 full_width text-center theme_bg_1" onclick="document.getElementById('loginForm').submit();"  style="border-radius: 1000px;">Log in</button>

                                    <div class="login_card_bottom">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgot_password" data-bs-dismiss="modal" class="pass_forget_btn">Forgot Password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>