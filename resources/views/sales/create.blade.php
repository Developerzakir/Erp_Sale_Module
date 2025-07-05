@extends('admin.admin_master')
@section('admin')
<div class="container my-4">
    <h2 class="mb-4">Create Sale</h2>

    <form id="sale-form">
        @csrf

        <div class="mb-3">
            <label class="form-label">Customer</label>
            <select name="user_id" id="user_id" class="form-select">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control">
        </div>

        <table class="table table-bordered" id="items-table">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{-- <select name="items[0][product_id]" class="form-select product-select">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select> --}}
                        <select name="items[0][product_id]" class="form-select product-select">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[0][quantity]" class="form-control quantity" value="1"></td>
                    <td><input type="number" name="items[0][price]" class="form-control price"></td>
                    <td><input type="number" name="items[0][discount]" class="form-control discount" value="0"></td>
                    <td class="item-total align-middle">0</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mb-3">
            <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>
            <button type="submit" class="btn btn-primary">Submit Sale</button>
        </div>
    </form>

    <div id="grand-total" class="alert alert-info mt-3">Total: 0</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/sales.js') }}"></script>
@endpush

