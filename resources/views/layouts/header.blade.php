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
          {{-- <li class="nav-item">
            <a href="#sidebarDashboard" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboard">
              <i class="fa-solid fa-chart-line"></i>
              <span>Dashboard</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarDashboard">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="/" class="nav-link">Index</a>
                </li>
                <li class="nav-item">
                  <a href="/customers" class="nav-link">Customers</a>
                </li>

                <li class="nav-item">
                  <a href="#sidebarDirectory" class="nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarDirectory"><span>Directory</span></a>
                  <div class="collapse menu-dropdown" id="sidebarDirectory">
                    <ul class="nav nav-sm flex-column">
                      <li class="nav-item">
                        <a href="index.html" class="nav-link">Sub Menu-1</a>
                      </li>
                      <li class="nav-item">
                        <a href="add_new_client.html" class="nav-link">Sub Menu-2</a>
                      </li>
                      <li class="nav-item">
                        <a href="#submenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="submenu">Sub Menu-3</a>
                        <div class="collapse menu-dropdown" id="submenu">
                          <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                              <a href="#" class="nav-link">
                                  Level 3.1
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="#" class="nav-link">
                                  Level 3.2
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </li> --}}

          @foreach ($menus as $menu)
            @if ($menu->is_parent==1)
              <li class="nav-item">
                <a href="#sidebarMenu-{{$menu->id}}" class="nav-link has-arrow" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMenu-{{$menu->id}}">
                  {!!$menu->icon!!}
                  <span>{{ $menu->name }}</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarMenu-{{$menu->id}}">
                  <ul class="nav nav-sm flex-column">
                    @foreach ($menus as $childmenu)
                      @if ($childmenu->pid == $menu->id)
                        <li class="nav-item">
                          <a href="{{ url($childmenu->route) }}" class="nav-link has-arrow" aria-expanded="false">{{ $childmenu->name }}</a>
                        </li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              </li>
              @elseif($menu->is_parent==0 && $menu->level==0)
                <li class="nav-item">
                  <a href="{{ url($menu->route) }}" class="nav-link has-arrow" aria-expanded="false">
                      <span>{{ $menu->name }}</span> 
                  </a>
                </li>
              @endif
          @endforeach

          {{-- @foreach ($menus as $menu)
            @if ($menu->is_parent==1)
              <li class="nav-item">
                <a href="#sidebarMenu-{{$menu->id}}" class="nav-link has-arrow" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarMenu-{{$menu->id}}">
                  {!!$menu->icon!!}
                  <span>{{ $menu->name }}</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarMenu-{{$menu->id}}">
                  <ul class="nav nav-sm flex-column">
                    @foreach ($menus as $childmenu)
                      @if ($childmenu->pid == $menu->id)
                        <li class="nav-item">
                          <a href="{{ url($childmenu->route) }}" class="nav-link has-arrow" aria-expanded="false">{{ $childmenu->name }}</a>
                        </li>
                      @elseif ($childmenu->pid != $menu->id && $childmenu->level==2)
                        <li class="nav-item">
                          <a href="#sidebarSubMenu-{{$childmenu->id}}" class="nav-link has-arrow" data-bs-toggle="collapse" aria-expanded="false" aria-controls="sidebarSubMenu-{{$childmenu->id}}">
                            <span>{{ $childmenu->name }}</span>
                          </a>
                          <div class="collapse menu-dropdown" id="sidebarSubMenu-{{$childmenu->id}}">
                            <ul class="nav nav-sm flex-column">
                              @foreach ($menus as $grandChildmenu)
                                @if ($grandChildmenu->pid == $childmenu->id)
                                  <li class="nav-item">
                                    <a href="{{ url($grandChildmenu->route) }}" class="nav-link has-arrow" aria-expanded="false">{{ $grandChildmenu->name }}</a>
                                  </li>
                                @endif
                              @endforeach
                            </ul>
                          </div>
                        </li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              </li>

            @elseif($menu->is_parent==0 && $menu->level==0)
              <li class="nav-item">
                <a href="{{ url($menu->route) }}" class="nav-link has-arrow" aria-expanded="false">
                    <span>{{ $menu->name }}</span> 
                </a>
              </li>
            @endif
          @endforeach --}}
        </ul>
      </div>

      {{-- <ul id="sidebar_menu">
        <li class="mm-active">
          <a href="/" aria-expanded="false">
            <img src="{{url('img/menu-icon/dashboard.svg') }}" alt />
            <span>Dashboard</span>
          </a>
          <ul>
            <!-- <li><a class="active" href="index.html">Directory</a></li> -->
            <li>
                <a class="has-arrow" href="#" aria-expanded="false">Directory</a>
                <ul>
                    <li><a href="index.html">Sub Menu-1</a></li>
                    <li><a href="add_new_client.html">Sub Menu-2</a></li>
                    <li><a href="index_2.html">Sub Menu-3</a></li>
                </ul>
            </li>
            <li><a href="add_new_client.html">Add New Client</a></li>
            <li><a href="index_2.html">Default</a></li>
          </ul>
        </li>
        @foreach ($menus as $menu)
          @if ($menu->is_parent==1)
            <li>
              <a href="#" class="has-arrow" aria-expanded="false">
                <img src="img/menu-icon/dashboard.svg" alt />
                <span>{{ $menu->name }}</span>
              </a>
              <ul>
                @foreach ($menus as $childmenu)
                  @if ($childmenu->pid == $menu->id)
                    <li><a href="{{ url($childmenu->route) }}">{{ $childmenu->name }}</a></li>
                  @endif
                @endforeach
              </ul>
            </li>
          @elseif($menu->is_parent==0 && $menu->level==0)
            <li>
              <a href="{{ url($menu->route)  }}" aria-expanded="false">
                <img src="{{url('img/menu-icon/dashboard.svg') }}" alt />
                  <span>{{ $menu->name }}</span> 
              </a>
            </li>
          @endif
        @endforeach
      </ul> --}}
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

