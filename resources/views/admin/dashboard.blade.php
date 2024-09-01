@extends("layouts.main")
@section('main-container')
  

  <div class="main_content_iner border-0 p-3">
      <div class="container-fluid p-0 sm_padding_15px">
          <div class="row justify-content-center">
              <div class="col-lg-9 col-xl-9">
                  <div class="row">
                      <div class="col-md-3">
                          <div class="card mb-3 widget-chart border-0">
                              <div class="widget-subheading pt-2 text-secondary">Total Clients</div>
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="icon-wrapper rounded-circle">
                                      <div class="icon-wrapper-bg bg-primary"></div>
                                      <i class="fa fa-users"></i>
                                  </div>
                                  <div class="widget-numbers"><span>2273</span></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card mb-3 widget-chart border-0">
                              <div class="widget-subheading pt-2 text-secondary">Active Clients</div>
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="icon-wrapper rounded-circle">
                                      <div class="icon-wrapper-bg bg-primary"></div>
                                      <i class="fa fa-user-check"></i>
                                  </div>
                                  <div class="widget-numbers"><span>2273</span></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card mb-3 widget-chart border-0">
                              <div class="widget-subheading pt-2 text-secondary">Online Clients (PPPOE1)</div>
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="icon-wrapper rounded-circle">
                                      <div class="icon-wrapper-bg bg-primary"></div>
                                      <i class="fa fa-user-edit"></i>
                                  </div>
                                  <div class="widget-numbers"><span>2273</span></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card mb-3 widget-chart border-0">
                              <div class="widget-subheading pt-2 text-secondary">Online Clients (Hotspot)</div>
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="icon-wrapper rounded-circle">
                                      <div class="icon-wrapper-bg bg-primary"></div>
                                      <i class="fa fa-user-tag"></i>
                                  </div>
                                  <div class="widget-numbers"><span>2273</span></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card mb-3 widget-chart border-0">
                              <div class="widget-subheading pt-2 text-secondary">Total Clients</div>
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="icon-wrapper rounded-circle">
                                      <div class="icon-wrapper-bg bg-primary"></div>
                                      <i class="fa fa-users"></i>
                                  </div>
                                  <div class="widget-numbers"><span>2273</span></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="card mb-3 widget-chart border-0">
                              <div class="widget-subheading pt-2 text-secondary">Active Clients</div>
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="icon-wrapper rounded-circle">
                                      <div class="icon-wrapper-bg bg-primary"></div>
                                      <i class="fa fa-user-check"></i>
                                  </div>
                                  <div class="widget-numbers"><span>1273</span></div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="white_box mb_30">
                      <div class="box_header">
                          <div class="main-title">
                              <h3 class="mb_25">Client Status</h3>
                          </div>
                          <div class="float-end d-none d-md-inline-block">
                              <div class="btn-group mb-2" role="group">
                                  <button type="button" class="btn btn-sm btn-light">Today</button>
                                  <button type="button" class="btn btn-sm btn-light">Weekly</button>
                                  <button type="button" class="btn btn-sm btn-light">Monthly</button>
                              </div>
                          </div>
                      </div>
                      <div id="line-column-chart2"></div>
                      <div class="card_footer_white">
                          <div class="row">
                              <div class="col-sm-4 text-center">
                                  <div class="d-inline-flex">
                                      <h5 class="me-2">$12,253</h5>
                                      <div class="text-success">
                                          <i class="fas fa-caret-up font-size-14 line-height-2 me-2"> </i>2.2 %
                                      </div>
                                  </div>
                                  <p class="text-muted text-truncate mb-0">This month</p>
                              </div>
                              <div class="col-sm-4 text-center">
                                  <div class="mt-4 mt-sm-0">
                                      <p class="mb-2 text-muted text-truncate"><i
                                              class="fas fa-circle text-primary me-2 font-size-10 me-1"></i> This
                                          Year :</p>
                                      <div class="d-inline-flex align-items-center">
                                          <h5 class="mb-0 me-2">$ 34,254</h5>
                                          <div class="text-success">
                                              <i class="fas fa-caret-up font-size-14 line-height-2 me-2"> </i>2.1
                                              %
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-4 text-center">
                                  <div class="mt-4 mt-sm-0">
                                      <p class="mb-2 text-muted text-truncate"><i
                                              class="fas fa-circle text-success font-size-10 me-1"></i> Previous
                                          Year :</p>
                                      <div class="d-inline-flex align-items-center">
                                          <h5 class="mb-0">$ 32,695</h5>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="white_box mb_30">
                      <div id="apex_2"></div>
                  </div>
              </div>
              <div class="col-lg-3">
                  <div class="white_box mb-3 p-3">
                      <div class="box_header mb-0">
                          <div class="main-title">
                              <h3 class="m-0">Chart</h3>
                          </div>
                      </div>
                      <div class="casnvas_box">
                          <canvas height="210" width="210" id="canvasDoughnut"></canvas>
                      </div>
                      <div class="legend_style legend_style_grid mt_10px mt-2">
                          <li class="d-block"> <span style="background-color:#FFA70B;"></span>Due Amount</li>
                          <li class="d-block"> <span style="background-color: #9C52FD;"></span> Collection Amount
                          </li>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection