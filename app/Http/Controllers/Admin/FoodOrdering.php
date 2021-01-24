<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodMenu;
use App\Models\Group;
use App\Models\Order;
use App\Models\OrderItem;
use DB;
use Session;
class FoodOrdering extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $food_menuu=FoodMenu::all();

        $food_group=Group::all();
        foreach($food_group as $food_groups){
            $food_menu=FoodMenu::where('item_group','=',$food_groups->id)->get();
            $food_menu_count=FoodMenu::where('item_group','=',$food_groups->id)->get()->count();
            $sub_menus[]=[
            'category_name'=>$food_groups->heading,
            'category_id'=>$food_groups->id,
            'food_menu_id'=>$food_menu,
            'food_menu_count'=>$food_menu_count,
            ];

        }
                   
        return view('admin.food_ordering.food_listing',['food_menu'=>$food_menuu,'food_group'=>$food_group,'sub_menus'=>$sub_menus]);
    }

     public function category_item($id){

                $category_item=FoodMenu::where('item_group','=',$id)->get();

                $food_group=Group::all();
                foreach($food_group as $food_groups){
                    $food_menu=FoodMenu::where('item_group','=',$food_groups->id)->get();
                    $food_menu_count=FoodMenu::where('item_group','=',$food_groups->id)->get()->count();
                    $sub_menus[]=[
                    'category_name'=>$food_groups->heading,
                    'category_id'=>$food_groups->id,
                    'food_menu_id'=>$food_menu,
                    'food_menu_count'=>$food_menu_count,
                    ];
                }                
                return view('admin.food_ordering.category_item',['food_menu'=>$category_item,'food_group'=>$food_group,'sub_menus'=>$sub_menus]);


     }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function cart(Request $request)
    {
        //echo 232;die();
        return view('admin.food_ordering.checkout');
    }

    public function create()
    {
        //
        return view('admin.food_ordering.food_ordering');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }



    public function add_to_cart(Request $request,$id){
       // Session::forget('cart') ;die();
        //echo $id;
        $food_menu=FoodMenu::where('id','=',$id)->first();
        // echo "<pre>";
        // print_r($food_menu);
        if(!$food_menu) {
            abort(404);
        }
        $cart = session()->get('cart');
 
        // if cart is empty then this the first product
        if(!$cart) {
 
            $cart = [
                    $id => [
                        "name" => $food_menu->item_name,
                        "quantity" => 1,
                        "price" => $food_menu->sale_price,
                        "photo" => $food_menu->image
                    ]
            ];

            $insertData = [
                    'user_id' => auth()->id(),
                    'item_count' => 1,
                    'status' => 'pending',
                    'order_number' => uniqid('OrderNumber-'),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ];
            $insert =  Order::insertGetId($insertData);

            $ordered_item = [
                    'order_id' => $insert,
                    'product_id' => $food_menu->id,
                    'quantity' => 1,
                    'price' =>$food_menu->sale_price,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ];
            $insert_item =  OrderItem::insertGetId($ordered_item);

            session()->put('order_id', $insert);
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

         // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
 
            $cart[$id]['quantity']++;
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Product added to cart successfully!');
 
        }

         // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $food_menu->item_name,
            "quantity" => 1,
            "price" => $food_menu->sale_price,
            "photo" => $food_menu->image
        ];

        $order_id=session()->get('order_id');
              $ordered_item = [
                    'order_id' =>  $order_id,
                    'product_id' => $food_menu->id,
                    'quantity' => 1,
                    'price' =>$food_menu->sale_price,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ];
        $insert_item =  OrderItem::insertGetId($ordered_item);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');

    }

    public function update_cart(Request $request)
        {
            if($request->id and $request->quantity)
            {
                $cart = session()->get('cart');

                $cart[$request->id]["quantity"] = $request->quantity;

                session()->put('cart', $cart);

                session()->flash('success', 'Cart updated successfully');
            }
        }

        public function remove(Request $request)
        {
            if($request->id) {

                $cart = session()->get('cart');

                if(isset($cart[$request->id])) {

                    unset($cart[$request->id]);

                    session()->put('cart', $cart);
                }

                session()->flash('success', 'Product removed successfully');
            }
        }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
