<!DOCTYPE html>
<html lang="zxx">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>MyBilling 2.0</title>
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
    <link rel="stylesheet" href="{{url('css/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{url('css/colors/default.css') }}" id="colorSkinCSS" />

    <link rel="stylesheet" href="{{url('css/fontawesome-css/fontawesome.css') }}" />
    {{-- <link rel="stylesheet" href="{{url('css/fontawesome-css/brands.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{url('css/fontawesome-css/solid.css') }}" /> --}}
    <link rel="stylesheet" href="{{url('css/fontawesome-css/all.css') }}" />
    {{-- <link rel="stylesheet" href="{{url('css/fontawesome-css/all.min.css') }}" /> --}}
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script> 
    
    {{-- Sidebar --}}
    <link rel="stylesheet" href="{{url('css/sidemenu.css') }}" />

    {{-- Date Time Picker --}}
    <link rel="stylesheet" type="text/css" href="{{url('css/jquery.datetimepicker.css') }}" />

    {{-- Dropify File Input --}}
    <link rel="stylesheet" href="{{url('vendors/dropify/dist/css/dropify.min.css') }}" />
 
  </head>
  <body class="crm_body_bg">
    <!-- Sidebar -->
    <nav class="sidebar theme_bg_1">
      <div class=" d-flex justify-content-center">
        <a href="/"><img width="200px" src="{{url('img/logo.png') }}" alt /></a>
        <div class="sidebar_close_icon d-lg-none">
          <i class="ti-close"></i>
        </div>
      </div>

      <div class="navbar-menu ">
        <ul class="navbar-nav">


          @foreach ($menus as $levelZero)
            @if ($levelZero->is_parent==1 && $levelZero->level==0)
              <li class="nav-item">
                <a href="#levelOneMenu{{ $levelZero->id }}" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="levelOneMenu{{ $levelZero->id }}">
                  {!! $levelZero->icon !!}
                  <span>{{ $levelZero->name }}</span>
                </a>
                <div class="collapse menu-dropdown" id="levelOneMenu{{ $levelZero->id }}">
                  <ul class="nav nav-sm flex-column">
                    @foreach ($menus as $levelOne)
                      @if ($levelOne->is_parent==1 && $levelOne->level==1 && $levelOne->pid==$levelZero->id)
                        <li class="nav-item">
                          <a href="#levelTwoMenu{{ $levelOne->id }}" class="nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="levelTwoMenu{{ $levelOne->id }}"><span>{{ $levelOne->name }}</span></a>
                          <div class="collapse menu-dropdown" id="levelTwoMenu{{ $levelOne->id }}">
                            <ul class="nav nav-sm flex-column">
                              @foreach ($menus as $levelTwo)
                                @if ($levelTwo->is_parent==1 && $levelTwo->level==2 && $levelTwo->pid==$levelOne->id)
                                  <li class="nav-item">
                                    <a href="#levelThreeMenu{{ $levelTwo->id }}" class="nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="levelThreeMenu{{ $levelTwo->id }}">{{ $levelTwo->name }}</a>
                                    <div class="collapse menu-dropdown" id="levelThreeMenu{{ $levelTwo->id }}">
                                      <ul class="nav nav-sm flex-column">
                                        @foreach ($menus as $levelThree)
                                          @if ($levelThree->is_parent==0 && $levelThree->level==3  && $levelThree->pid==$levelTwo->id)
                                            <li class="nav-item">
                                              <a href="{{ url($levelThree->route) }}" class="nav-link">
                                                  {{ $levelThree->name }}
                                              </a>
                                            </li>                              
                                          @endif
                                        @endforeach
                                      </ul>
                                    </div>
                                  </li>
                                @elseif($levelTwo->is_parent==0 && $levelTwo->level==2 && $levelTwo->pid==$levelOne->id)
                                  <li class="nav-item">
                                    <a href="{{ url($levelTwo->route) }}" class="nav-link">{{ $levelTwo->name }}</a>
                                  </li>
                                @endif
                              @endforeach
                            </ul>
                          </div>
                        </li>
                      @elseif($levelOne->is_parent==0 && $levelOne->level==1 && $levelOne->pid==$levelZero->id)
                        <li class="nav-item">
                          <a href="{{ url($levelOne->route) }}" class="nav-link">{{ $levelOne->name }}</a>
                        </li>
                      @endif
                    @endforeach
                    
                  </ul>
                </div>
              </li>
            @elseif($levelZero->is_parent==0 && $levelZero->level==0)
              <li class="nav-item">
                <a href="{{ url($levelZero->route) }}" class="nav-link">
                  {!! $levelZero->icon !!}
                  <span>{{ $levelZero->name}}</span> 
                </a>
              </li>
            @endif
          @endforeach

          

          

        </ul>
      </div>
    </nav>
    
    <!-- Sidebar End-->

    <section class="main_content dashboard_part">
      <div class="container-fluid g-0">
        <div class="row">
          <div class="col-lg-12 p-0">
            <div
              class="header_iner d-flex justify-content-between align-items-center p-0"
            >
              <div class="sidebar_icon d-lg-none">
                <i class="ti-menu"></i>
              </div>
              <div class="serach_field-area">
                {{-- <div class="search_inner">
                  <form action="#">
                    <div class="search_field">
                      <input type="text" placeholder="Search here..." />
                    </div>
                    <button type="submit">
                      <img src="{{url('img/icon/icon_search.svg') }}" alt />
                    </button>
                  </form>
                </div> --}}
              </div>
              <div
                class="header_right d-flex justify-content-between align-items-center"
              >
                {{-- <div class="header_notification_warp d-flex align-items-center">
                  <li>
                    <a class="bell_notification_clicker" href="#">
                      <img src="{{url('img/icon/bell.svg') }}" alt />
                      <span>04</span>
                    </a>

                    <div class="Menu_NOtification_Wrap">
                      <div class="notification_Header">
                        <h4>Notifications</h4>
                      </div>
                      <div class="Notification_body">
                        <div class="single_notify d-flex align-items-center">
                          <div class="notify_thumb">
                            <a href="#"><img src="{{url('img/staf/2.png') }}" alt /></a>
                          </div>
                          <div class="notify_content">
                            <a href="#"><h5>Cool Directory</h5></a>
                            <p>Lorem ipsum dolor sit amet</p>
                          </div>
                        </div>

                        <div class="single_notify d-flex align-items-center">
                          <div class="notify_thumb">
                            <a href="#"><img src="{{url('img/staf/4.png') }}" alt /></a>
                          </div>
                          <div class="notify_content">
                            <a href="#"><h5>Awesome packages</h5></a>
                            <p>Lorem ipsum dolor sit amet</p>
                          </div>
                        </div>

                        <div class="single_notify d-flex align-items-center">
                          <div class="notify_thumb">
                            <a href="#"><img src="{{url('img/staf/3.png') }}" alt /></a>
                          </div>
                          <div class="notify_content">
                            <a href="#"><h5>what a packages</h5></a>
                            <p>Lorem ipsum dolor sit amet</p>
                          </div>
                        </div>

                        <div class="single_notify d-flex align-items-center">
                          <div class="notify_thumb">
                            <a href="#"><img src="{{url('img/staf/2.png') }}" alt /></a>
                          </div>
                          <div class="notify_content">
                            <a href="#"><h5>Cool Directory</h5></a>
                            <p>Lorem ipsum dolor sit amet</p>
                          </div>
                        </div>

                        <div class="single_notify d-flex align-items-center">
                          <div class="notify_thumb">
                            <a href="#"><img src="{{url('img/staf/4.png') }}" alt /></a>
                          </div>
                          <div class="notify_content">
                            <a href="#"><h5>Awesome packages</h5></a>
                            <p>Lorem ipsum dolor sit amet</p>
                          </div>
                        </div>

                        <div class="single_notify d-flex align-items-center">
                          <div class="notify_thumb">
                            <a href="#"><img src="{{url('img/staf/3.png') }}" alt /></a>
                          </div>
                          <div class="notify_content">
                            <a href="#"><h5>what a packages</h5></a>
                            <p>Lorem ipsum dolor sit amet</p>
                          </div>
                        </div>
                      </div>
                      <div class="nofity_footer">
                        <div class="submit_button text-center pt_20">
                          <a href="#" class="btn_1">See More</a>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <a class="CHATBOX_open" href="#">
                      <img src="{{url('img/icon/msg.svg') }}" alt /> <span>01</span>
                    </a>
                  </li>
                </div> --}}
                <div class="profile_info">
                  <img src="{{url('img/client_img.png')}}" alt="#" />
                  <div class="profile_info_iner">
                    <div class="profile_author_name">
                      
                      <h5>{{ Auth::user()->name }}</h5>
                    </div>
                    <div class="profile_info_details">
                      <a href="#">My Profile </a>
                      <a href="#">Change Password</a>
                      <form action="{{ route('logout') }}" id="logoutForm" method="POST">
                        @csrf
                        <a href="javascript:{}" onclick="document.getElementById('logoutForm').submit();">Log Out</a>
                        
                      </form>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



