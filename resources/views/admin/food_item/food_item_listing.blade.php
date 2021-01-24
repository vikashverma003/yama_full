@extends('admin.layouts.app')
@section('content')
        
        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="card">
            <div class="card-body">
                @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
                <a href="{{url('admin/food_item/create')}}" class="btn addLangBtn">
                  ADD FOOD ITEMS
                          </a>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Item Id</th>
                            <th width="5%">Food Name</th>
                            <th width="5%">Group Name</th>
                            <th width="5%">Sub Group</th>
                            <th width="5%">Building Name</th>
                            <th width="5%">Food Type</th>
                            <th width="5%">Image</th>

                            <th width="5%">Price</th>
                            <th width="5%">Taxes</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($food_item as $inventory)
                        <tr>
                            <td>{{$inventory['id']}}</td>
                            <td>{{$inventory['food_name']}}</td>
                            <td>{{$inventory['group_name']}}</td>
                            <td>{{$inventory['sub_group']}}</td>
                            <td>{{$inventory['building_name']}}</td>
                            <td>{{$inventory['food_type']}}</td>
                            <td><img src="{{$inventory['image']}}" width="100" height="100" alt="image"/></td>
                            <td>{{$inventory['price']}}</td>
                            <td>{{$inventory['taxes']}}</td>
                            
                        </tr>
                        @endforeach
                      </tbody>
                    </table>                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection