<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Size;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductSizeController extends Controller
{
    public function index(Product $product)
    {
        $sizes = Size::all();
        $productSizeQuantity = $product->sizes->sum('pivot.quantity');
        return view('product_sizes.sizes', compact('product', 'sizes', 'productSizeQuantity'));
    }

    public function store(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:0',
        ]);

        // جلوگیری از دوباره ثبت شدن سایز
        if ($product->sizes->contains($validatedData['size_id'])) {
            return redirect()->back()->with('error', 'این سایز قبلاً به محصول اختصاص داده شده است.');
        }

        $productSizeQuantity = $product->sizes->sum('pivot.quantity');
        if ($productSizeQuantity + $validatedData['quantity'] > $product->quantity) {
            return redirect()->back()->with('warning',  'تعداد وارد شده بیشتر از موجودی کل محصول است.');
        }

        $size = Size::find($validatedData['size_id']);
        try {

            $product->sizes()->attach($validatedData['size_id'], [
                'quantity' => $validatedData['quantity'],
            ]);
            return redirect()->back()->with('success', 'تعداد سایز ' . $size->name . ' با موفقیت ایجاد شد.');
        } catch (Exception $e) {
            Log::error("Error updating product size: " . $e->getMessage());

            return redirect()->back()->with('error','خطا در ایجاد سایز ' . $size->name . '. ' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره تلاش کنید.')
            );
        }
    }

    public function update(Request $request, Product $product, Size $size)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $productSizeQuantity = $product->sizes->sum('pivot.quantity');
        if ($productSizeQuantity + $validatedData['quantity'] > $product->quantity) {
            return redirect()->back()->with('warning',  'تعداد وارد شده بیشتر از موجودی کل محصول است.');
        }

        try {
            $product->sizes()->updateExistingPivot($size->id, [
                'quantity' => $validatedData['quantity'],
            ]);

            return redirect()->back()->with('success', 'تعداد سایز ' . $size->name . ' با موفقیت به‌روزرسانی شد.');
        } catch (Exception $e) {
            Log::error("Error updating product size: " . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'خطا در بروزرسانی سایز ' . $size->name . '. ' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره تلاش کنید.')
            );
        }
    }

    public function destroy(Product $product, Size $size)
    {
        $product->sizes()->detach($size->id);

        return redirect()->back()->with('success', 'سایز با موفقیت حذف شد.');
    }
}
