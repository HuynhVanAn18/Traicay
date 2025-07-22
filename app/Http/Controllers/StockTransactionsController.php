<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransactions;
use App\Models\Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// use DB;
use Illuminate\Support\Facades\DB;
class StockTransactionsController extends Controller
{
    // Show all stock transactions
    public function all_stock_transactions()
    {
        $transactions = StockTransactions::with(['product'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.StockTransactions.all_stock_transactions', compact('transactions'));
    }

    // Show form to import stock
    public function add_stock_transaction()
    {
        $products = Products::orderBy('product_name', 'asc')->get();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();
        return view('admin.StockTransactions.add_stock_transaction')
            ->with('products', $products)
            ->with('cate_product', $cate_product)
            ->with('brand_product', $brand_product);
    }

    // Save new stock transaction
    public function save_stock_transaction(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:tbl_product,product_id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|string',
        ]);
        $admin_id = Auth::id();
        // print admin id use dump
        // dd($admin_id);

        // Update product quantity based on transaction type
        $product = Products::where('product_id', $request->product_id)->first();
        if ($product) {
            if ($request->type === 'import') {
                $product->product_qty += $request->quantity;
            } elseif ($request->type === 'export') {
                $product->product_qty -= $request->quantity;
                if ($product->product_qty < 0) {
                    $product->product_qty = 0;
                }
            }
            $product->save();
        }

        StockTransactions::create([
            'product_id' => $request->product_id,
            'admin_id' => $admin_id,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'note' => $request->note,
        ]);
        Session::put('message', 'Stock transaction added successfully!');
        return redirect()->route('all-stock-transactions');
    }
}
