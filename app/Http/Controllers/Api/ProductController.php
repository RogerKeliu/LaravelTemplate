<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if( Auth::user()->can('viewAny', [Product::class, 'api']) ) {
            return response()->json([
                'data' => Product::get()->toArray(),
                'status'  => 200,
            ]);
        }

        return response()->json([
            'message' => 'Method Not Allowed',
            'status'  => 405,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( Auth::user()->can('viewAny', Product::class ) ){
            return 'hola';
        }

        return 'adeu';

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $role)
    {
        return Product::find($role->id)->first()->toArray();
    }
}
