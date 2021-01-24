@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper">
        <!--  $getdoctor->diseases -->
          <h4 class="card-title">General Documentation</h4>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">General Documentation</h6>
                  <div class="row">
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Professional Id</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <div class="br-wrapper br-theme-fontawesome-stars">
                                 {{$doctor->general->professional_card}}
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         <?php 
                         $url= URL::to('/');
                         ?>
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">University Professional title</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                           <a href="{{$url}}/admin/images/doctor/{{$doctor->general->professional_title}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                          </div>
                        </div>
                      </div>
                    
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Curp</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            
                                 {{$doctor->general->curp}}
                          
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Curp Document</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->curp_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">RFC</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->general->rfc}}
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Address</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->general->proof_address}}
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Email</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->email}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>

          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">General Documentation</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Pofessional Card Document</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->professional_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Official identification</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->official_identification}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">S.S.A. Registration</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->general->ssa_registration}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">RFC Document</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->rfc_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Address Document</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->address_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Telephone</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->phone_number}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Billing Data</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->company_name}}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Address</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->billing->address}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Municipality</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->municipality}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">State</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->state}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Country</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{$doctor->billing->country}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Email</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->mail}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Billing Data</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Name or RFC</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->name_rfc}}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Number</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->billing->number}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Colonia</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->colonia}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Postal code</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->billing->zipcode}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Telephone</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{@$doctor->billing->telephone}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>


<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Use Of CFDI</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Acquisition of merchandise</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->cfdi->purchase_goods}}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">General expenses</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->cfdi->general_expenses}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Telephone communications</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->cfdi->telephone_communications}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Medical, dental and hospital fees</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->cfdi->hospital_fees}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Medical expense insurance premiums</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{@$doctor->cfdi->insurance_premiums}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Payments for educational services (tuition)</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{@$doctor->cfdi->educational_services}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>
<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Use Of CFDI</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Returns, discounts or bonuses</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{@$doctor->cfdi->returns}}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Computer equipment and accessories</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->cfdi->accessories}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Comunicaciones satelitales</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->cfdi->satellite_communications}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Medical expenses for disability or disability</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->cfdi->medical_expenses}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">To be defined</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{@$doctor->cfdi->be_defined}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Deposit Data</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Bank account Number</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{@$doctor->deposit->bank_account}}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Type of account</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->deposit->type_account}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">RFC</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->deposit->rfc}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Bank name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->deposit->bank_name}}
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>

          


           <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Deposit Data</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Bank account Document</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{@$doctor->deposit->bank_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Account type</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->deposit->account_type}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Interbank key</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->deposit->interbank_type}}
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>



          <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Tax Keys</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">CSD Digital Seal Certificate</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{@$doctor->fiscal->seal_certificate}}">
                                 <i class="fa fa-cloud-download"></i></a>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">FIEL electronic signature</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             <a href="{{$url}}/admin/images/doctor/{{$doctor->deposit->electronic_signature}}">
                                 <i class="fa fa-cloud-download"></i></a>
                         
                          </div>
                        </div>
                      </div>
                    </div>
                  
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Vinku chat Doctor Information</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Complete name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{@$doctor->medicalchat->fullname}}
                            
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Language</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->medicalchat->language}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Years of experience</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalchat->experience}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Degrees Documents</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalchat->degrees_documents}}">
                                 <i class="fa fa-cloud-download"></i></a>
                            
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Workplace</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalchat->workplace}}
                            
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
          </div>


           <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Vinku Chat Doctor Information</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Professional card</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             <a href="{{$url}}/admin/images/doctor/{{@$doctor->medicalchat->professional_card}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Short personal description</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->medicalchat->short_description}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Degrees</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalchat->degrees}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Profile photo</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                           <img src="{{$url}}/admin/images/doctor/{{$doctor->medicalchat->profile_photo}}" style="width: 90px; height: 65px;">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

           <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Vinku Pro Doctor Information</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Complete name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{@$doctor->medicalpro->fullname}}
                          </div>
                        </div>
                      </div>
                    </div>

                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Language</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->medicalpro->language}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Years of experience</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->experience}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Bachelor's degree and name of the university</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->b_degree}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Medical speciality and name of the university</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->m_speciality}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Sub medical speciality and name of the university</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->s_medical_speciality}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Master and name of the university</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->master_name}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">PhD and name of the university</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->phd_name}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Address</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->address}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Colonia</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->colonia}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">State</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->state}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Postal code</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->zipcode}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Price of first visit</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->price}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Awards</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->awards}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Courses</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->courses}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Profile Photo</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                              <img src="{{$url}}//{{$doctor->medicalpro->profile_photo}}" style="width: 90px; height: 65px;">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Vinku Pro Doctor Information</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Professional card</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             {{@$doctor->medicalpro->professional_card}}
                          </div>
                        </div>
                      </div>
                    </div>

                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Short personal description</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->medicalpro->short_description}}
                          </div>
                        </div>
                      </div>
                    </div>

                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Disease</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{@$doctor->diseases->name}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <small class="text-muted mb-0">Bachelor's degree Documents</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             <a href="{{$url}}/admin/images/doctor/{{@$doctor->medicalpro->b_degree_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Medical speciality Documents</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{@$doctor->medicalpro->m_speciality_documents}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Sub medical Documents</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                             <a href="{{$url}}/admin/images/doctor/{{@$doctor->medicalpro->s_medical_speciality_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Master and name of the university Documents</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{@$doctor->medicalpro->master_name_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">PhD and name of the university Documents</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{@$doctor->medicalpro->phd_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Number</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->number}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Municipality</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->municipality}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Country</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->country}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Recognition</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->recognition}}
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Days of attention</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->day}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Hours of attention</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->hours}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Contact number</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->medicalpro->contact_number}}
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Doctor Status</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Pre-registration</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                                 {{@$doctor->doctorstatus->pre_registration}}
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Interview</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->doctorstatus->interview}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Photo Registration</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->doctorstatus->photo_registration}}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Document registration</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                           {{$doctor->doctorstatus->document_registration}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php if($doctor->approved_status == '0'){ ?>
                    <a href="{{route('emailShoot',$doctor->id)}}" style="margin-top: 20px; margin-bottom: 10px;" class="btn btn-success mr-2 submit_button">Approved</a>
                  <?php }else{ ?>
                    <button type="button" style="margin-top: 20px; margin-bottom: 10px;" disabled class="btn btn-success mr-2 submit_button">Approved</button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Doctor Status</h6>
                  <div class="row">
                     <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Presentation</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                                 {{@$doctor->doctorstatus->presentation}}
                          </div>
                        </div>
                      </div>
                    </div>
                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Signing of contract</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                          {{$doctor->doctorstatus->contract}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Activation</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            {{$doctor->doctorstatus->activation}}
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                
              </div>
            </div>
          </div>

          
          
          
        
           </div>
        
        </div>
@endsection