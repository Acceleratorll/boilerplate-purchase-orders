<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolsRequest;
use App\Models\Product;
use App\Models\PurchaseOrderLine;
use DateTime;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function getProductList()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', ['products' => $products]);
    }

    public function getProductShow($id)
    {
        return view('admin.products.index');
    }

    public function getProductEdit($id)
    {
        return view('admin.products.index');
    }

    public function getProductDestroy($id)
    {
        return view('admin.products.index');
    }

    public function getPurchaseOrderLinesList()
    {
        $pols = PurchaseOrderLine::paginate(10);
        return view('admin.purchaseOrderLines.index', ['pols' => $pols]);
    }

    public function getPurchaseOrderLinesShow($id)
    {
    }

    public function getPurchaseOrderLinesCreate()
    {

        return view('admin.purchaseOrderLines.create');
    }

    public function getPurchaseOrderLinesEdit($id)
    {
    }

    public function postPurchaseOrderLineInsert(PolsRequest $request, PurchaseOrderLine $purchaseOrderLine)
    {
        // $purchaseOrderLine->product_id = $request->post('product');
        $purchaseOrderLine->qty = $request['qty'];
        $purchaseOrderLine->price = $request['price'];
        $purchaseOrderLine->discount = $request['discount'];
        $purchaseOrderLine->total = ((int)$request['qty'] * (int)$request['price']) - ((int)$request['discount'] * (int)$request['price'] / 100);
        // $purchaseOrderLine->created_at = new DateTime();
        // $purchaseOrderLine->updated_at = new DateTime();
        $purchaseOrderLine->save();

        return redirect()->intended(route('admin.purchase.order.lines'));
    }

    public function getPurchaseOrderLinesDestroy($id)
    {
    }
}
