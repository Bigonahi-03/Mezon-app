<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\View\ViewName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(6);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        // dd($categories);
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request, Product $product)
    {

        $validatedData = $request->validated();

        // Save the primary image
        $imageName = $request->primary_image->getClientOriginalName();
        $primaryImageName = createImageName($imageName);
        $request->primary_image->storeAs('images/products/', $primaryImageName);

        $validatedData['primary_image'] = $primaryImageName;

        // Checking for the existence of images and saving them
        if ($request->has('images') && $request->images !== null) {
            $fileNameImages = [];
            foreach ($request->images as $image) {
                $imageName = $image->getClientOriginalName();
                $fileNameImage = createImageName($imageName);;
                $image->storeAs('images/products/', $fileNameImage);
                array_push($fileNameImages, $fileNameImage);
            }
        }

        // Generate slug
        $slug = makeSlug($request->name);
        $validatedData['slug'] = $slug;

        $validatedData['sale_price'] = $request->sale_price !== null ?  $request->sale_price : 0 ;


        // Convert dates to Gregorian
        $validatedData['date_on_sale_from'] = $request->date_on_sale_from !== null ?   getMiladiDate($request->date_on_sale_from) : null;
        $validatedData['date_on_sale_to'] = $request->date_on_sale_to !== null ?  getMiladiDate($request->date_on_sale_to) : null ;

        // dd($validatedData);

        try {
            DB::beginTransaction();
            $createdProduct = $product->create($validatedData);
            if ($request->has('images') && $request->images !== null) {
                foreach ($fileNameImages as $fileNameImage) {
                    ProductImage::create([
                        'product_id' => $createdProduct->id,
                        'image' => $fileNameImage
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('products.index')->with('success', 'محصول با موفقیت ذخیره شد.');
        } catch (Exception $e) {
            Log::error("Error create product:" . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'ایجاد ویژگی با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product, ProductImage $productImage)
{
    $validatedData = $request->validated();

    // Handle primary image upload (optional on update)
    if ($request->hasFile('primary_image')) {
        $imageName = $request->primary_image->getClientOriginalName();
        $primaryImageName = createImageName($imageName);

        // Delete old image if exists
        Storage::delete('images/products/' . $product->primary_image);

        // Save new image
        $request->primary_image->storeAs('images/products/', $primaryImageName);
        $validatedData['primary_image'] = $primaryImageName;
    }

    // Handle other product images (replace all if provided)
    if ($request->hasFile('images')) {
        // Delete old images
        foreach ($product->images as $image) {
            Storage::delete('images/products/' . $image->image);
            $image->delete();
        }

        // Save new images
        $fileNameImages = [];
        foreach ($request->images as $image) {
            $imageName = $image->getClientOriginalName();
            $fileNameImage = createImageName($imageName);
            $image->storeAs('images/products/', $fileNameImage);
            $fileNameImages[] = $fileNameImage;
        }
    }

    // Generate slug only if name has changed
    $validatedData['slug'] = $request->name === $product->name
        ? $product->slug
        : makeSlug($request->name);

    // Set default sale price if not provided
    $validatedData['sale_price'] = $request->sale_price ?? 0;

    // Convert Jalali date to Gregorian
    $validatedData['date_on_sale_from'] = $request->date_on_sale_from
        ? getMiladiDate($request->date_on_sale_from)
        : null;

    $validatedData['date_on_sale_to'] = $request->date_on_sale_to
        ? getMiladiDate($request->date_on_sale_to)
        : null;

    try {
        DB::beginTransaction();

        // Update product
        $product->update($validatedData);

        // Save new images if provided
        if (!empty($fileNameImages)) {
            foreach ($fileNameImages as $fileNameImage) {
                $product->images()->create([
                    'image' => $fileNameImage
                ]);
            }
        }

        DB::commit();

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت به‌روزرسانی شد.');
    } catch (Exception $e) {
        DB::rollBack();
        Log::error("Error updating product: " . $e->getMessage());

        return redirect()->route('products.index')->with(
            'error',
            'ویرایش محصول با خطا مواجه شد. ' .
            (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.')
        );
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'محصول با موفقیت حذف شد.');
        } catch (Exception $e) {
            Log::error("Error deleting product:" . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'حذف محصول با خطا مواجه شد. لطفاً دوباره امتحان کنید.' . (env('APP_ENV') === 'local' ? $e->getMessage() : 'لطفاً دوباره امتحان کنید.'));
        }
    }
}
