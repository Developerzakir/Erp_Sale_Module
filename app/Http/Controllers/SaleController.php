<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSaleRequest;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
   {
        $query = Sale::with(['user', 'items.product']);

        if ($request->filled('customer')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->customer.'%');
            });
        }

        if ($request->filled('product')) {
            $query->whereHas('items.product', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->product.'%');
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $sales = $query->latest()->paginate(10);

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // customer list
        $products = Product::all(); // product list
        return view('sales.create', compact('users', 'products'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        DB::transaction(function() use ($request) {
            $total = calculateSaleTotal($request->items);
            $sale = Sale::create([
                'user_id' => $request->user_id,
                'date' => $request->date,
                'total' => $total
            ]);

            foreach ($request->items as $item) {
                $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0,
                    'total' => ($item['quantity'] * $item['price']) - ($item['discount'] ?? 0),
                ]);
            }
        });

        return response()->json(['message' => 'Sale created successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // trash view
    public function trash() {
        $sales = Sale::onlyTrashed()->paginate(10);
        return view('sales.trash', compact('sales'));
    }

    public function restore($id) {
        Sale::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('sales.trash')->with('success', 'Sale restored!');
    }
}
