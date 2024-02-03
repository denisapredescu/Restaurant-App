<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
//        $name = "Frigarui";
//        "%$name%"
//        "%". $name . "%"
//        sprintf("/%%s/%", $name);
//        dd(
//            var_dump($request->name)
//        );
        return Dish::when(
            $request->name,
            fn(Builder $query, string $value) => $query->where('name', 'like', "%{$value}%")
        )->simplePaginate();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDishRequest $request
     * @return Response
     */
    public function store(StoreDishRequest $request)
    {
        $data = $request->all();  // ia datele ca json

        return Dish::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return Dish::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    //fara regula de unicitate
    public function update(UpdateDishRequest $request, $id)
    {
        $dish = Dish::findOrFail($id);

        $data = $request->validated();

        $dish->update($data);

        return $dish;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string[]
     */
    public function destroy($id)
    {
        $dish = Dish::findOrFail($id);
        $dish->delete();
        return ['status' => 'success'];
    }
}
