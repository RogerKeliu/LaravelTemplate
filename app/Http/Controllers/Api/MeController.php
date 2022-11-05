<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use App\Policies\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(new UserResource(User::with('roles')->findOrFail(Auth::user()->id)), 200);
    }

    public function lang()
    {
        return response()->json(Auth::user()->toArray()['lang']);
    }

    public function langStore(Request $request) {
        $validated = $request->validate([
            'lang' => 'required'
        ]);
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $user->lang = $validated['lang'];
        $user->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function canView(Request $request) {

        $route = 'view ' . $request->input('route')['name'];
        if(Helpers::userCanDoAction(Auth::user(), $route)) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }

    }
}
