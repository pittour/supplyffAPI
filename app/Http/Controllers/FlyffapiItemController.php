<?php

namespace App\Http\Controllers;

use App\Models\FlyffapiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlyffapiItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $apiItems =  FlyffapiItem::where('tradable', 1)->with('class');
        Log::alert($request->query('search'));

        if ($request->query('search')) {
            $apiItems->where('name', 'LIKE', '%' . $request->query('search') . '%');
        }
        return $apiItems->paginate(40);
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
}
