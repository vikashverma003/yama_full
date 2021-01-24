@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper">
          <div class="row">

             <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/building_list')}}">
                      <p class="mb-0">Building</p>
                      <h6>{{$building}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/building_floor_listing')}}">
                      <p class="mb-0">Floor</p>
                      <h6>{{$floor}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-chart-line-stacked icon-lg text-danger"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/viewowner')}}">
                      <p class="mb-0">Owner</p>
                      <h6>{{$owner}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/viewcollaborators')}}">
                      <p class="mb-0">Collaborators</p>
                      <h6>{{$collaborators}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/viewadministrator')}}">
                      <p class="mb-0">Adminsitators</p>
                      <h6>{{$adminsitators}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            
          </div>
        </div>
@endsection