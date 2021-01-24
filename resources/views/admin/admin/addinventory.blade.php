@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">

          <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
                          <div class="col-md-2">
                          <label for="exampleInputEmail1">Food Product List</label>
                        </div>
                          <div class="col-md-10">
                          <select class="form-control border-primary eventName" name="item_group" id="exampleSelectPrimary" required="">
                          <option>--Select--</option>
                           @foreach($groupitem as $rest)
                          <option value="{{$rest->id}}">{{$rest->item_name}}</option>
                          @endforeach
                          </select></div>
            </div>
             <h4 class="card-title">Add Food Product</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/createInventory')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Food Product Name</label>
                          <input type="text" name="item_name" class="form-control" id="item_name" placeholder="Enter Item Name" required="">
                           <input type="hidden" name="id" class="form-control" id="id" placeholder="Enter Item Name" >
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Food Image</label>
                          <input type="file" name="image" class="form-control" id="sale_price" placeholder="Enter Sale Price" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Barcode</label>
                          <input type="text" name="barcode" class="form-control" id="barcode" placeholder="Enter Barcode" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Food Category</label>
                          <select class="form-control border-primary" name="item_group" id="item_group" required="">
                          <option>--Select--</option>
                           @foreach($group as $res)
                          <option value="{{$res->id}}">{{$res->heading}}</option>
                          @endforeach
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Food Sub Category</label>
                          <input type="text" name="sub_group" class="form-control" id="sub_group" placeholder="Enter Sub Group" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Re Order</label>
                          <input type="text" name="re_order" class="form-control" id="re_order" placeholder="Enter Re Order" required="">
                        </div>

                         <button type="submit" class="btn btn-success mr-2">Submit</button>
                    </div>
                  </div>
                </div>
              
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      
                        <div class="form-group">
                          <label for="exampleInputEmail1">Sale Price</label>
                          <input type="text" name="sale_price" class="form-control" id="sale_price" placeholder="Enter Sale Price" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Food Description</label>
                          <input type="text" name="food_description" class="form-control" id="sale_price" placeholder="Enter Sale Price" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Tax</label>
                          <input type="text" name="tax" class="form-control" id="tax" placeholder="Enter Tax" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Discount</label>
                          <input type="text" name="discount" class="form-control" id="discount" placeholder="Enter Discount" >
                        </div>
                     
                        

                        <div class="form-group">
                          <label for="exampleInputEmail1">Min Stock</label>
                          <input type="text" name="min_stock" class="form-control" id="min_stock" placeholder="Enter Min Stock" required="">
                        </div>

                        
                        <div class="form-group">
                          <label for="exampleInputEmail1">GST</label>
                          <input type="text" name="gst" class="form-control" id="gst" placeholder="Enter GST" required="">
                        </div>

                     </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
                
          </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
          
    $(document).ready(function(){
      $(".eventName").change(function(){
              var id=$(this).val();
              //alert(id);
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: 'GET',
          url: "{{route('get_inventory')}}?user_id="+id,
          dataType:'json',
          success:function(data){
            //console.log(data.length);
              var n =data.length;
            for(i=0;i<n;i++) {
          
            var id =data[i].id;
            $("#id").val(id);

            var item_name =data[i].item_name;
             $("#item_name").val(item_name);

            var barcode =data[i].barcode;
            $("#barcode").val(barcode);

            var item_group =data[i].item_group;
            $("#item_group").val(item_group);

            var sub_group =data[i].sub_group;
            $("#sub_group").val(sub_group);

            var sale_price =data[i].sale_price;
            $("#sale_price").val(sale_price);

            var tax =data[i].tax;
            $("#tax").val(tax);

            var discount =data[i].discount;
            $("#discount").val(discount);

            var min_stock =data[i].min_stock;
            $("#min_stock").val(min_stock);

            var re_order =data[i].re_order;
            $("#re_order").val(re_order);

            var gst =data[i].gst;
            $("#gst").val(gst);

            // alert(id);
            // alert(item_name);
            // alert(barcode);
            // alert(item_group);
            // alert(sub_group);
            // alert(sale_price);
          }
            
            
    

           }
        });
     });
});

        </script>

@endsection