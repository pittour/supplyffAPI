<?php

namespace App\Http\Controllers;

use App\Models\Classified;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassifiedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Classified::with(['item', 'item.flyffItem', 'user.server', 'item.flyffItem.class'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'general_level' => 'required|numeric|between:0,10',
            'elemental_level' => 'required|numeric|between:0,10',
            'element_type' => 'required_if:classified.elementalBonus, >, 0',
            'weekly_rate' => 'required|numeric|between:0,999999999',
            'deposit' => 'required|numeric|between:0,999999999',
            'description' => 'string|max:256',
            'awake' => 'boolean',
            'piercings' => 'boolean',
            'free_boolean' => 'boolean',
        ]);

        $classifiedData = array_merge($request->all(), ["user_id" => auth()->user()->id]);
        $classified = Classified::create($classifiedData);

        $itemData = array_merge($request->all(), ["classified_id" => $classified->id, "flyffapi_item_id" => $request->input('item.flyff_api_id')]);
        $item = Item::create($itemData);

        if ($request->free_boolean) {
            $classified->weekly_rate = 0;
            $classified->save();
        }

        return $classified;



        // if ($request->has('classified.freeBoolean')) {

        // }
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
    public function update(Request $request, Classified $classified)
    {
        if (auth()->user()->id !== $classified->user_id) {
            return response()->json(['error' => 'Permission denied'], 404);
        }

        $request->validate([
            'weekly_rate' => 'required|numeric|between:0,999999999',
            'deposit' => 'required|numeric|between:0,999999999',
            'description' => 'string|max:256',
        ]);

        $classified->weekly_rate = $request->weekly_rate;
        $classified->deposit = $request->deposit;
        $classified->description = $request->description;
        $classified->save();

        return $classified;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classified $classified)
    {
        if (auth()->user()->id !== $classified->user_id && !auth()->user()->admin) {
            return response()->json(['error' => 'Permission denied'], 404);
        }

        $classified->delete();
        return response()->json(['message' => 'Classified deleted successfully.'], 200);
    }

    public function userClassifieds(User $user)
    {
        if ($user->id !== auth()->user()->id && !auth()->user()->admin) {
            return response()->json(['error' => 'Permission denied'], 404);
        }

        $classifieds = Classified::where('user_id', $user->id)->with(['item', 'user', 'user.server', 'item.flyffItem.class'])->get();
        return $classifieds;
    }
}
