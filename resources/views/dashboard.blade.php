@extends('main')
@section('content')
<div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tổng quan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tổng quan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$totalCustomers}}</h3>
                <p>Tổng số khách hàng</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-users"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$wonderCustomers}}</h3>
                <p>Khách hàng tiềm năng</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-people-group"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$smsSpamedCustomers}}</h3>
                <p>Đã spam SMS</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-envelope"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{$zaloSpamedCustomers}}</h3>
                <p>Đã spam Zalo</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-z"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
      </div>
    </section>

  </div>
@endsection