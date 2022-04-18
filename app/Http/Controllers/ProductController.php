<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // เช็คสิทธิ์ admin (role = 1)
        $user = auth()->user();
        if ($user->tokenCan("1")) {
            $request->validate([
                'name' => 'required|min:5',
                'slug' => 'required',
                'price' => 'required',
            ]);
            return Product::create($request->all());
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Permission denied to create',
            ];
            return response($response, 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->tokenCan("1")) {
            $product = Product::find($id);
            $product->update($request->all());

            return $product;
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Permission denied to create',
            ];
            return response($response, 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->tokenCan("1")) {
            return Product::destroy($id);
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Permission denied to created',
            ];
            return response($response, 403);
        }
    }
}
