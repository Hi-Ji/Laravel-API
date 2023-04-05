<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'slug' => 'required',
    //         'price' => 'required',
    //         'description' => 'required',
    //         'product_image' => 'mimes:png,jpg,jpeg',
    //     ]);
    //     return Product::create($request->all());
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'description' => 'required',
            'product_image' => 'mimes:png,jpg,jpeg',
        ]);
        if($request->has('product_image')){
            $imageName = time().'.'.$request->product_image->extension();

            //最后是 product_images 还是 product_image
            $image_path = $request -> file('product_image') -> store('product_images','public');

            return Product::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'price' => $request->price,
                'description' => $request->description,
                'product_image' => $image_path,
            ]);
        }else{
            return Product::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'price' => $request->price,
                'description' => $request->description,
            ]);
        }     
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if($product->product_image !='' && $product->product_image != null && $request->product_image){
            Storage::disk('public')->delete($product->product_image);
            $imageName = time().'.'.$request->product_image->extension();

            $image_path = $request -> file('product_image') -> store('product_image','public');

            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'price' => $request->price,
                'description' => $request->description,
                'product_image' => $image_path,
            ]);
        }elseif($request->product_image != ''){
            $imageName = time().'.'.$request->product_image->extension();

            $image_path = $request -> file('product_image') -> store('product_image','public');

            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'price' => $request->price,
                'description' => $request->description,
                'product_image' => $image_path,
            ]);
        }else{
            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'price' => $request->price,
                'description' => $request->description,
            ]);
        }

        // 返回更新后的产品信息
        // return response()->json([
        //     'name' => $product->name,
        //     'slug' => $product->slug,
        //     'price' => $product->price,
        //     'description' => $product->description,
        //     'product_image' => $product->product_image,
        // ]);
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }

    /**
     * Search for a name.
     */
    public function search($name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
