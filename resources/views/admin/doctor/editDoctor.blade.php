@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
      
<style type="text/css">
  .field-icon {
    font-size: 15px;
    position: absolute;
    right: 9px;
    top: 11px;
}

</style>
      <div class="content-wrapper">
        <div class="row">
           <?php 
                         $url= URL::to('/');
                         ?>
          <h4 class="card-title">General Documentation</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/UpdateDoctor')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Professional Id</label>
                          <input type="text" class="form-control" name="gnprofessional_card" id="exampleInputEmail1" value="{{$doctor->general->professional_card}}" placeholder="Enter Professional Id" >
                          <input type="hidden" name="id" value="{{$doctor->id}}">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">University Professional title</label>
                      <input type="file" name="professional_title" id="professional_title" class="file-upload-default"  >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->professional_title}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="title_Professional" style="color: red;"></span>
                        </div>


                         <div class="form-group">
                          <label for="exampleInputPassword1">Curp</label>
                          <input type="text" name="curp" class="form-control" id="exampleInputPassword1" value="{{$doctor->general->curp}}" placeholder="Enter Curp" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Curp Document</label>
                      <input type="file" name="curp_document" id="curp_document" class="file-upload-default"  >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->curp_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>

                      <span id="curp_doc" style="color: red;"></span>
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">RFC</label>
                          <input type="text" name="rfc" class="form-control" id="exampleInputPassword1" value="{{$doctor->general->rfc}}" placeholder="Enter RFC" >
                        </div>

                         <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="proof_address" class="form-control" id="exampleInputPassword1" value="{{$doctor->general->proof_address}}" placeholder="Enter Address" >
                    </div>

                    <div class="form-group">
                          <label for="exampleInputPassword1">Email</label>
                          <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="{{$doctor->email}}" placeholder="Enter Email" >
                        </div>

                      
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">


                       <div class="form-group">
                      <label>Pofessional Card Document</label>
                      <input type="file" name="professional_document" id="professional_document" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>

                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->professional_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>

                      <span id="professional_doc" style="color: red;"></span>
                    </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">Official identification</label>
                           <input type="file" name="official_identification" id="official_identification" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->official_identification}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="official_ident" style="color: red;"></span>
                        </div>

                    <div class="form-group">
                      <label>S.S.A. Registration</label>
                      <input type="text" name="ssa_registration" class="form-control" id="exampleInputPassword1" value="{{$doctor->general->ssa_registration}}" placeholder="Enter S.S.A. Registration" >
                    </div>


                    <div class="form-group">
                      <label>RFC Document</label>
                      <input type="file" name="rfc_document" id="rfc_documents" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->rfc_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="rfc_docs" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                      <label>Address Document</label>
                      <input type="file" name="address_document" id="address_document" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                        <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->general->address_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>

                      <span id="address_doc" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                          <label for="exampleInputPassword1">Telephone</label>
                          <input type="text" name="phone_number" class="form-control" id="exampleInputPassword1" value="{{$doctor->phone_number}}" placeholder="Enter Telephone" >
                        </div>
                       
                    </div>
                  </div>
                </div>
              </div>
            </div>



             <h4 class="card-title">Billing data</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                  
                     
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name </label>
                          <input type="text" name="company_name" class="form-control" id="exampleInputEmail1" value="{{$doctor->billing->company_name}}" placeholder="Enter Company name" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Address</label>
                          <input type="text" value="{{$doctor->billing->address}}" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter Address" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Municipality</label>
                          <input type="text" value="{{$doctor->billing->municipality}}" name="municipality" class="form-control" id="exampleInputEmail1" placeholder="Enter Municipality" >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">State</label>
                          <input type="text" value="{{$doctor->billing->state}}" name="state" class="form-control" id="exampleInputEmail1" placeholder="Enter State" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Country</label>
                          <input type="text" value="{{$doctor->billing->country}}" name="country" class="form-control" id="exampleInputEmail1" placeholder="Enter Country" >
                        </div>

                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Email</label>
                          <input type="email" name="mail" value="{{$doctor->billing->mail}}" class="form-control" id="exampleInputPassword1" placeholder="Enter Email" >
                        </div>
                         
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                       <div class="form-group">
                          <label for="exampleInputEmail1">Name or RFC </label>
                          <input type="text" name="name_rfc" value="{{$doctor->billing->name_rfc}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Name or RFC " >
                        </div>

                       <div class="form-group">
                          <label for="exampleInputEmail1">Number</label>
                          <input type="text" name="number" value="{{$doctor->billing->number}}"  class="form-control" id="exampleInputEmail1" placeholder="Enter Number " >
                        </div>

                          <div class="form-group">
                          <label for="exampleInputEmail1">Colonia</label>
                          <input type="text" name="colonia" value="{{$doctor->billing->colonia}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Colonia " >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Postal code</label>
                          <input type="text" name="zipcode" value="{{$doctor->billing->zipcode}}"  class="form-control" id="exampleInputPassword1" placeholder="Postal code" >
                        </div>
                    
                    <div class="form-group">
                          <label for="exampleInputEmail1">Telephone</label>
                          <input type="text" name="telephone" value="{{$doctor->billing->telephone}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Telephone " >
                        </div>
                       
                    </div>
                  </div>
                </div>
              </div>
            </div>



             <h4 class="card-title">Use of CFDI</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                  
                      
                        <div class="form-group">
                          <label for="exampleInputEmail1">Acquisition of merchandise</label>
                          <input type="text" name="purchase_goods" class="form-control" id="exampleInputEmail1" value="{{$doctor->cfdi->purchase_goods}}" placeholder="Enter Acquisition of merchandise" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">General expenses</label>
                          <input type="text" name="accessories" class="form-control" id="exampleInputEmail1" value="{{$doctor->cfdi->accessories}}" placeholder="Enter General expenses" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Telephone communications</label>
                          <input type="text" name="telephone_communications" class="form-control" value="{{$doctor->cfdi->telephone_communications}}" id="exampleInputEmail1" placeholder="Enter Telephone communications" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Medical, dental and hospital fees</label>
                          <input type="text" name="hospital_fees" class="form-control" id="exampleInputPassword1" value="{{$doctor->cfdi->hospital_fees}}" placeholder="Enter Medical, dental and hospital fees" >
                        </div>
                         <div class="form-group">
                          <label for="exampleInputPassword1">Medical expense insurance premiums</label>
                          <input type="text" name="insurance_premiums" class="form-control" id="exampleInputPassword1" value="{{$doctor->cfdi->insurance_premiums}}" placeholder="Enter Medical expense insurance premiums" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">Payments for educational services (tuition)</label>
                          <input type="text" name="educational_services" class="form-control" id="exampleInputPassword1" value="{{$doctor->cfdi->educational_services}}" placeholder="Enter Payments for educational services" >
                        </div>

                        

                         
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                       <div class="form-group">
                          <label for="exampleInputEmail1">Returns, discounts or bonuses </label>
                          <input type="text" name="returns" class="form-control" id="exampleInputEmail1" value="{{$doctor->cfdi->returns}}" placeholder="Enter Returns, discounts" >
                        </div>

                       <div class="form-group">
                          <label for="exampleInputEmail1">Computer equipment and accessories</label>
                          <input type="text" name="accessories" class="form-control" id="exampleInputEmail1" value="{{$doctor->cfdi->accessories}}" placeholder="Enter >Computer equipment " >
                        </div>

                     <div class="form-group">
                          <label for="exampleInputEmail1">Comunicaciones satelitales</label>
                          <input type="text" name="satellite_communications" class="form-control" value="{{$doctor->cfdi->satellite_communications}}" id="exampleInputEmail1" placeholder="Enter Comunicaciones satelitales " >
                        </div>


                    <div class="form-group">
                          <label for="exampleInputEmail1">Medical expenses for disability or disability</label>
                          <input type="text" name="medical_expenses" class="form-control" id="exampleInputEmail1" value="{{$doctor->cfdi->medical_expenses}}" placeholder="Enter disability" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">To be defined</label>
                          <input type="text" name="be_defined" class="form-control" id="exampleInputEmail1" value="{{$doctor->cfdi->be_defined}}" placeholder="Enter To be defined" >
                        </div>
                       
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <h4 class="card-title">Deposit data</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                  
                        <div class="form-group">
                          <label for="exampleInputEmail1">Bank account Number</label>
                          <input type="text" name="bank_account" class="form-control" id="exampleInputEmail1" value="{{$doctor->deposit->bank_account}}" placeholder="Enter Bank account" >
                        </div>

                        <div class="form-group">
                    <label for="exampleSelectSuccess">Type of account</label>
                    <select class="form-control border-success accountTytpe" id="exampleSelectSuccess" name="account_type" >
                       <option value="">--Select--</option>
                      <option value="personal" <?php if($doctor->deposit->account_type == 'personal'){ echo "selected"; } ?>>Personal</option>
                      <option value="moral" <?php if($doctor->deposit->account_type == 'moral'){ echo "selected"; } ?>>Moral</option>
                    </select>
                  </div>

                  <div class="form-group">
                          <label for="exampleInputEmail1">RFC</label>
                          <input type="text" name="rfc" class="form-control" id="exampleInputEmail1" value="{{$doctor->deposit->rfc}}"  placeholder="Enter RFC" >
                        </div>

                   <div class="form-group">
                          <label for="exampleInputEmail1">Bank name</label>
                          <input type="text" name="bank_name" class="form-control" id="exampleInputEmail1" value="{{$doctor->deposit->bank_name}}" placeholder="Enter Bank name" >
                        </div>

                        

                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                      <div class="form-group">
                      <label></label>
                      <input type="file" name="bank_document" id="bank_document" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->deposit->bank_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="bank_doc" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                   <span id="account_new_type"></span>
                  </div>


                    <div class="form-group">
                    <label for="exampleSelectSuccess">Account type</label>
                     <input type="text" name="type_account" class="form-control" id="exampleInputEmail1" value="{{$doctor->deposit->type_account}}" placeholder="Enter Account type" >
                  </div>

                <div class="form-group">
                          <label for="exampleInputEmail1">Interbank key</label>
                          <input type="text" name="interbank_type" class="form-control" id="exampleInputEmail1" value="{{$doctor->deposit->interbank_type}}" placeholder="Enter Interbank key" >
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>


            <h4 class="card-title">Tax Keys</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                    <div class="form-group">
                      <label>CSD Digital Seal Certificate</label>
                      <input type="file" name="seal_certificate" id="seal_certificate" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                       <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->fiscal->seal_certificate}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="seal_cert" style="color: red;"></span>
                    </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">FIEL electronic signature</label>
                         <input type="file" name="electronic_signature" id="electronic_signature" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->fiscal->electronic_signature}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="electronic_sig" style="color: red"></span>
                        </div>
                        <!-- <div class="form-group">
                          <label for="exampleInputEmail1">Password</label>
                          <input type="password" name="password" class="form-control" id="pass_log_id" placeholder="Enter Password" ><span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>

                        </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

        <h4 class="card-title">Vinku Chat Doctor information</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Complete name</label>
                          <input type="text" name="chatfullname" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalchat->fullname}}" placeholder="Enter Full name" >
                        </div>

                        <div class="form-group">
                           <label for="exampleSelectSuccess">Language</label>
                        <select class="form-control border-success" id="exampleSelectSuccess" name="chatlanguage" >
                           <option value="">--Select--</option>
                         @foreach($language as $res)
                           <option value="{{$res->name}}" <?php if($doctor->medicalchat->language == $res->name) { echo "selected";} ?>>{{$res->name}}</option>
                            @endforeach
                        </select>
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Years of experience</label>
                          <input type="number" name="chatexperience" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalchat->experience}}" placeholder="Enter experience" >
                        </div>

                        <div class="form-group">
                      <label>Degrees Documents</label>
                      <input type="file" name="chatdegrees_documents"  id="chatchatdegees_documents" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalchat->degrees_documents}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="chatdegees_documents" style="color: red"></span>
                    </div>


                      <div class="form-group">
                          <label for="exampleInputEmail1">Workplace</label>
                          <input type="text" name="chatworkplace" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalchat->workplace}}" placeholder="Enter Workplace" >
                      </div>

                         
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                      <div class="form-group">
                          <label for="exampleInputEmail1">Professional card</label>
                          <input type="text" name="chatprofessional_card" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalchat->professional_card}}" placeholder="Enter Professional card" >
                        </div>

                     <div class="form-group">
                          <label for="exampleInputEmail1">Short personal description</label>
                          <input type="text" name="chatshort_description" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalchat->short_description}}" placeholder="Enter personal description" >
                        </div>

                 <div class="form-group">
                          <label for="exampleInputEmail1">Degrees</label>
                          <input type="text" name="chatdegrees" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalchat->degrees}}" placeholder="Enter Degrees" >
                        </div>

                  <div class="form-group">
                      <label>Profile photo</label>
                      <input type="file" name="chatprofile_photo"  id="chatprofile_photo" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                           <img src="{{$url}}/admin/images/doctor/{{$doctor->medicalchat->profile_photo}}" style="width: 90px; height: 65px;">
                          </div>
                      <span id="chatprofile_ph" style="color: red"></span>
                    </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>


            <h4 class="card-title">Vinku Pro Doctor information</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Complete name</label>
                          <input type="text" name="fullname" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->fullname}}" placeholder="Enter Full name" >
                        </div>

                        <div class="form-group">
                           <label for="exampleSelectSuccess">Language</label>
                        <select class="form-control border-success" id="exampleSelectSuccess" name="language" >
                           <option value="">--Select--</option>
                           @foreach($language as $res)
                           <option value="{{$res->name}}" <?php if($doctor->medicalpro->language == $res->name){ echo "selected"; }  ?>>{{$res->name}}</option>
                            @endforeach
                          
                        </select>
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Years of experience</label>
                          <input type="number" value="{{$doctor->medicalpro->experience}}" class="form-control" id="exampleInputEmail1" name="experience" placeholder="Enter experience" >
                        </div>
                         
                       <div class="form-group">
                          <label for="exampleInputEmail1">Bachelor's degree and name of the university</label>
                          <input type="text" name="b_degree" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->b_degree}}" placeholder="Enter Bachelor's degree and name of the university" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Medical speciality and name of the university</label>
                          <input type="text" name="m_speciality" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->m_speciality}}" placeholder="Enter Medical speciality and name of the university" >
                      </div>

                      

                      <div class="form-group">
                          <label for="exampleInputEmail1">Sub medical speciality and name of the university</label>
                          <input type="text" name="s_medical_speciality" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->s_medical_speciality}}" placeholder="Enter Sub medical speciality and name of the university" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Master and name of the university</label>
                          <input type="text" name="master_name" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->master_name}}" placeholder="Enter Master and name of the university" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">PhD and name of the university</label>
                          <input type="text" name="phd_name" value="{{$doctor->medicalpro->phd_name}}" class="form-control" id="exampleInputEmail1" placeholder="Enter PhD and name of the university" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Address</label>
                          <input type="text" name="address" value="{{$doctor->medicalpro->address}}" class="form-control" id="txtPlace" placeholder="Enter address" >
                      </div>


                      <div class="form-group">
                          <label for="exampleInputEmail1">Colonia</label>
                          <input type="text" name="colonia" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->colonia}}" placeholder="Enter Colonia" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">State</label>
                          <input type="text" name="state" class="form-control" id="txtState" placeholder="Enter State" value="{{$doctor->medicalpro->state}}" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Postal code</label>
                          <input type="text" name="zipcode" class="form-control" id="txtZip" placeholder="Enter Postal code" value="{{$doctor->medicalpro->zipcode}}" >
                      </div>

                       <div class="form-group">
                          <label for="exampleInputEmail1">Price of first visit</label>
                          <input type="text" name="price" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->price}}" placeholder="Enter Price" >
                          <input type="hidden" name="" id="txtCity">
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Awards</label>
                          <input type="text" value="{{$doctor->medicalpro->awards}}" name="awards" class="form-control" id="exampleInputEmail1" placeholder="Enter Awards" >
                      </div>

                      <div class="form-group">
                          <label for="exampleInputEmail1">Courses</label>
                          <input type="text" name="courses" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->courses}}" placeholder="Enter Courses" >
                      </div>

                       <div class="form-group">
                      <label>Profile Photo</label>
                      <input type="file" name="profile_photo"  id="chatprofile_photos" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                           <img src="{{$url}}//{{$doctor->medicalpro->profile_photo}}" style="width: 90px; height: 65px;">
                          </div>
                      <span id="chatprofile_phs" style="color: red"></span>
                    </div>
                      
                      
                      
                  
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Professional card</label>
                          <input type="text" name="proprofessional_card" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->proprofessional_card}}"   placeholder="Enter Professional card" >
                        </div>

                  <div class="form-group">
                          <label for="exampleInputEmail1">Short personal description</label>
                          <input type="text" name="short_description" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->short_description}}" placeholder="Enter personal description" >
                        </div>

                        <div class="form-group">
                           <label for="exampleSelectSuccess">Disease</label>
                        <select class="form-control border-success" id="exampleSelectSuccess" name="disease" >
                           <option value="">--Select--</option>
                           @foreach($disease as $res)
                           <option value="{{$res->id}}" <?php if($res->id == $doctor->disease){ echo "selected"; } ?>>{{$res->name}}</option>
                            @endforeach
                          
                        </select>
                      </div>

                    <div class="form-group">
                      <label>Bachelor's degree Documents</label>
                      <input type="file" name="b_degree_document"  id="degree_document" class="file-upload-default" > 
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalpro->b_degree_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="degree_doc" style="color: red"></span>
                    </div>

                     <div class="form-group">
                      <label>Medical speciality Documents</label>
                      <input type="file" name="m_speciality_documents"  id="speciality_documents" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalpro->m_speciality_documents}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="speciality_doc" style="color: red"></span>
                    </div>

                     <div class="form-group">
                      <label>Sub medical Documents</label>
                      <input type="file" name="s_medical_speciality_document"  id="medical_speciality_document" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                       <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalpro->s_medical_speciality_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="medical_speciality_doc" style="color: red"></span>
                    </div>

                    <div class="form-group">
                      <label>Master and name of the university Documents</label>
                      <input type="file" name="master_name_document"  id="master_name_document" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalpro->master_name_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="master_name_doc" style="color: red"></span>
                    </div>

                    <div class="form-group">
                      <label>PhD and name of the university Documents</label>
                      <input type="file" name="phd_document"  id="phd_document" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <div class="rating ml-auto d-flex align-items-center">
                            <a href="{{$url}}/admin/images/doctor/{{$doctor->medicalpro->phd_document}}">
                                 <i class="fa fa-cloud-download"></i></a>
                      </div>
                      <span id="phd_doc" style="color: red"></span>
                    </div>

                    <div class="form-group">
                          <label for="exampleInputEmail1">Number</label>
                          <input type="text" name="number" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->number}}" placeholder="Enter Number" >
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Municipality</label>
                          <input type="text" name="municipality" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->municipality}}" placeholder="Enter Municipality" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Country</label>
                          <input type="text" name="country" class="form-control" id="txtCountry" value="{{$doctor->medicalpro->country}}" placeholder="Enter Country" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Recognition</label>
                          <input type="text" name="recognition" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->recognition}}" placeholder="Enter Recognition" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Days of attention</label>
                          <input type="text" name="day" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->day}}" placeholder="Enter Days of attention" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Hours of attention</label>
                          <input type="text" name="hours" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->hours}}" placeholder="Enter Hours of attention" >
                        </div> 

                        <div class="form-group">
                          <label for="exampleInputEmail1">Contact number</label>
                          <input type="text" name="contact_number" class="form-control" id="exampleInputEmail1" value="{{$doctor->medicalpro->contact_number}}"  placeholder="Enter Contact number" >
                        </div> 

                    </div>
                  </div>
                </div>
              </div>
            </div>



            <h4 class="card-title">Doctor Status</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Pre-registration</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="registration" name="pre_registration" value="completed"  <?php if($doctor->doctorstatus->pre_registration == 'completed'){ echo "checked"; } ?> >
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="registration" name="pre_registration" value="pending" <?php if($doctor->doctorstatus->pre_registration == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>

                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="registration" name="pre_registration" value="rejected" <?php if($doctor->doctorstatus->pre_registration == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>

                 <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Presentation</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Presentation" name="presentation" value="completed" <?php if($doctor->doctorstatus->presentation == 'completed'){ echo "checked"; } ?>>
                              Completed
                            <i class="input-helper"></i></label>
                          </div>

                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Presentation" name="presentation" value="pending" <?php if($doctor->doctorstatus->presentation == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>

                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Presentation" name="presentation" value="rejected" <?php if($doctor->doctorstatus->presentation == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Interview</label>
                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Interview" name="interview" value="completed" <?php if($doctor->doctorstatus->interview == 'completed'){ echo "checked"; } ?>>
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Interview" name="interview" value="pending" <?php if($doctor->doctorstatus->interview == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Interview" name="interview" value="rejected" <?php if($doctor->doctorstatus->interview == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Signing of contract </label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="contract" name="contract" value="completed" <?php if($doctor->doctorstatus->contract == 'completed'){ echo "checked"; } ?>>
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="contract" name="contract" value="pending" <?php if($doctor->doctorstatus->contract == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="contract" name="contract" value="rejected" <?php if($doctor->doctorstatus->contract == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


             <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Photo Registration</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Photo" name="photo_registration" value="completed" <?php if($doctor->doctorstatus->photo_registration == 'completed'){ echo "checked"; } ?>>
                              Completed
                            <i class="input-helper"></i></label>
                          </div>

                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Photo" name="photo_registration" value="pending" <?php if($doctor->doctorstatus->photo_registration == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Photo" name="photo_registration" value="rejected" <?php if($doctor->doctorstatus->photo_registration == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Activation</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="activation" value="completed" <?php if($doctor->doctorstatus->activation == 'completed'){ echo "checked"; } ?>>
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="activation" value="pending" <?php if($doctor->doctorstatus->activation == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="activation" value="rejected" <?php if($doctor->doctorstatus->activation == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
               
               <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Document registration</label>
                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="document_registration" value="completed" <?php if($doctor->doctorstatus->document_registration == 'completed'){ echo "checked"; } ?>>
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="document_registration" value="pending" <?php if($doctor->doctorstatus->document_registration == 'pending'){ echo "checked"; } ?>>
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="document_registration" value="rejected" <?php if($doctor->doctorstatus->document_registration == 'rejected'){ echo "checked"; } ?>>
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          <button type="submit" class="btn btn-success mr-2 submit_button">Submit</button>
     </form>
          </div>
        </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
        $(".accountTytpe").change(function() {
    var drop= $('option:selected', $(this)).text();
    if(drop == 'Personal'){
       $('#account_new_type').html("<label for='exampleInputEmail1'>Complete Name</label><input type='text' name='complete_name' class='form-control' id='exampleInputEmail1' placeholder='Enter Complete Name' required=''>");
    }else{
      $('#account_new_type').html("<label for='exampleInputEmail1'>Company Name</label><input type='text' name='company_name' class='form-control' id='exampleInputEmail1' placeholder='Enter Company Name' required=''>");
    }
        });
</script>
<!-- <script>
$(document).ready(function(){
  $(".submit_button").click(function(){
    var professional_title =$('#professional_title').val();
    if(professional_title == ''){
      $('#title_Professional').html('Feild is required');
    }else{
      $('#title_Professional').html('');
    }


     var professional_document =$('#professional_document').val();
    if(professional_document == ''){
      $('#professional_doc').html('Feild is required');
    }else{
       $('#professional_doc').html('');
    }

     var speciality_documents =$('#speciality_documents').val();
    if(speciality_documents == ''){
      $('#speciality_doc').html('Feild is required');
    }else{
       $('#speciality_doc').html('');
    }

    var medical_speciality_document =$('#medical_speciality_document').val();
    if(medical_speciality_document == ''){
      $('#medical_speciality_doc').html('Feild is required');
    }else{
       $('#medical_speciality_doc').html('');
    }

    
    

     var degree_document =$('#degree_document').val();
    if(degree_document == ''){
      $('#degree_doc').html('Feild is required');
    }else{
       $('#degree_doc').html('');
    }

    var master_name_document =$('#master_name_document').val();
    if(master_name_document == ''){
      $('#master_name_doc').html('Feild is required');
    }else{
       $('#master_name_doc').html('');
    }

    



    var official_identification =$('#official_identification').val();
    if(official_identification == ''){
      $('#official_ident').html('Feild is required');
    }else{
       $('#official_ident').html('');
    }

    var phd_document =$('#phd_document').val();
    if(phd_document == ''){
      $('#phd_doc').html('Feild is required');
    }else{
       $('#phd_doc').html('');
    }

    


    var curp_doc =$('#curp_document').val();
    if(curp_doc == ''){
      $('#curp_doc').html('Feild is required');
    }else{
      $('#curp_doc').html('');
    }


    var rfc_document =$('#rfc_document').val();
    if(rfc_document == ''){
      $('#rfc_doc').html('Feild is required');
    }else{
      $('#rfc_doc').html('');
    }

    var rfc_documents =$('#rfc_documents').val();
    if(rfc_documents == ''){
      $('#rfc_docs').html('Feild is required');
    }else{
      $('#rfc_docs').html('');
    }

    var bank_document =$('#bank_document').val();
    if(bank_document == ''){
      $('#bank_doc').html('Feild is required');
    }else{
      $('#bank_doc').html('');
    }

    var seal_certificate =$('#seal_certificate').val();
    if(seal_certificate == ''){
      $('#seal_cert').html('Feild is required');
    }else{
      $('#seal_cert').html('');
    }

    var electronic_sig =$('#electronic_signature').val();
    if(electronic_sig == ''){
      $('#electronic_sig').html('Feild is required');
    }else{
      $('#electronic_sig').html('');
    }

    var chatprofile_photo =$('#chatprofile_photo').val();
    if(chatprofile_photo == ''){
      $('#chatprofile_ph').html('Feild is required');
    }else{
      $('#chatprofile_ph').html('');
    }
    var chatprofile_photos =$('#chatprofile_photos').val();
    if(chatprofile_photos == ''){
      $('#chatprofile_phs').html('Feild is required');
    }else{
      $('#chatprofile_phs').html('');
    }
    
    var profile_photo =$('#profile_photo').val();
    if(profile_photo == ''){
      $('#profile_ph').html('Feild is required');
    }else{
      $('#profile_ph').html('');
    }

    var address_document =$('#address_document').val();
    if(address_document == ''){
      $('#address_doc').html('Feild is required');
    }else{
      $('#address_doc').html('');
    }

    

    var proof_address =$('#proof_address').val();
    if(proof_address == ''){
      $('#proof_add').html('Feild is required');
    }else{
      $('#proof_add').html('');
    }
    var newdeegre= $('#chatchatdegees_documents').val();
     if(newdeegre == ''){
      $('#chatdegees_documents').html('Feild is required');
    }else{
      $('#chatdegees_documents').html('');
    }
  });
});
</script> -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&key=AIzaSyDZk6aefM2lt5ipxaMmMXIRO-pYznqDxFA"></script>
<script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('txtPlace'));
        google.maps.event.addListener(places, 'place_changed', function () {
            var place = places.getPlace();
            var address = place.formatted_address;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var latlng = new google.maps.LatLng(latitude, longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var address = results[0].formatted_address;
                        var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
                        var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                        var state = results[0].address_components[results[0].address_components.length - 3].long_name;
                        var city = results[0].address_components[results[0].address_components.length - 4].long_name;
                        document.getElementById('txtCountry').value = country;
                        document.getElementById('txtState').value = state;
                        document.getElementById('txtCity').value = city;
                        document.getElementById('txtZip').value = pin;
                    }
                }
            });
        });
    });
</script>
<script type="text/javascript">
  
  $(document).on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    
    var input = $("#pass_log_id");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});

</script>


@endsection