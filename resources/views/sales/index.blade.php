@extends('admin.admin_master')

@section('admin')
<div class="container my-4">
    <h2 class="mb-4">Sales List</h2>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('sales.index') }}" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="customer" value="{{ request('customer') }}" class="form-control" placeholder="Customer Name">
        </div>
        <div class="col-md-3">
            <input type="text" name="product" value="{{ request('product') }}" class="form-control" placeholder="Product Name">
        </div>
        <div class="col-md-3">
            <input type="date" name="from" value="{{ request('from') }}" class="form-control" placeholder="From Date">
        </div>
        <div class="col-md-3">
            <input type="date" name="to" value="{{ request('to') }}" class="form-control" placeholder="To Date">
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Sales Table --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>{{ $sale->date }}</td>
                <td>{{ $sale->formatted_total }}</td>
                <td>
                    <ul class="list-unstyled mb-0">
                        @foreach ($sale->items as $item)
                        <li>{{ $item->product->name }} (Qty: {{ $item->quantity }})</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No sales found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div>
        {{ $sales->withQueryString()->links() }}
    </div>

    {{-- Total amount in current page --}}
    <div class="alert alert-info mt-2">
        Total Amount (this page): 
        {{ number_format($sales->sum('total'), 2) }} BDT
    </div>
</div>
@endsection