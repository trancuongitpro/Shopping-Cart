<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class ShoppingCartController extends Controller
{
    public static $menu_parent = 'shopping-cart';


    public function show(){
        $shoppingCart = null;
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        } else {
            $shoppingCart = [];
        }
        return view('cart', [
            'shoppingCart'=>$shoppingCart
        ]);
    }
    //
    public function Add(Request $request)
    {
        $productId = $request->get('id');
        $productQuantity = $request->get('quantity');
        if ($productQuantity <= 0) {
            return view('admin.errors.404', [
                'msg' => 'số lượng sản phẩm phải lớn hơn 0',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }

        $obj = Product::find($productId);

        if ($obj == null) {
            return view('admin.errors.404', [
                'msg' => 'số lượng sản phẩm phải lớn hơn 0',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }
        $shoppingCart = null;
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        } else {
            $shoppingCart = [];
        }
        if (array_key_exists($productId, $productQuantity)){

            $existingCartItem = $shoppingCart[$productId];

            $existingCartItem->quantyti += $productQuantity;

            $shoppingCart[$productId] = $existingCartItem;
        } else {
            $cartItem = new StdClass();
            $cartItem->id = $obj->id;
            $cartItem->name = $obj->name;
            $cartItem->unitPrice = $obj->unitPrice;
            $cartItem->quantity = $productQuantity;

            $shoppingCart[$productId] = $cartItem;
        }
        Session::put('shoppingCart', $shoppingCart);
        return redirect('/cart/show');
    }

    public function update(Request $request){
        $productId = $request->get('id');
        $productQuantity = $request->get('quantity');
        if ($productQuantity <= 0) {
            return view('admin.errors.404', [
                'msg' => 'số lượng sản phẩm phải lớn hơn 0',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }

        $obj = Product::find($productId);

        if ($obj == null) {
            return view('admin.errors.404', [
                'msg' => 'số lượng sản phẩm phải lớn hơn 0',
                'menu_parent' => self::$menu_parent,
                'menu_action' => 'create'
            ]);
        }
        $shoppingCart = null;
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        } else {
            $shoppingCart = [];
        }
        if (array_key_exists($productId, $productQuantity)){

            $existingCartItem = $shoppingCart[$productId];

            $existingCartItem->quantyti += $productQuantity;

            $shoppingCart[$productId] = $existingCartItem;
        } else {
            $cartItem = new StdClass();
            $cartItem->id = $obj->id;
            $cartItem->name = $obj->name;
            $cartItem->unitPrice = $obj->unitPrice;
            $cartItem->quantity = $productQuantity;

            $shoppingCart[$productId] = $cartItem;
        }
        Session::put('shoppingCart', $shoppingCart);
        return redirect('/cart/show');
    }
    public function remove(Request  $request){
        $productId = $request->get('id');
        $shoppingCart = null;
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        } else {
            $shoppingCart = [];
        }
        unset($shoppingCart[$productId]);
        Session::put('shoppingCart', $shoppingCart);
        return redirect('/cart/show');
    }
}

