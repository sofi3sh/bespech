<?php

namespace App\Http\Controllers\Api\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Content\AdminWhyModule;
use App\Models\Content\Advantages;
use App\Models\Content\AdminWhyModuleAdvantages;



class AdminWhyModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null)
    {
        //комент
        $whymodules = AdminWhyModule::with('advantages')->get();

        $result = $whymodules->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'text' => $item->text,
                'advantages' => $item->advantages->map(function ($advantage) {
                    return [
                        'id' => $advantage->id,
                        'text' => $advantage->name
                    ];
                })
            ];
        });

        return response()->json($result, 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $whymodule = AdminWhyModule::with('advantages')->find($id);

        if (!$whymodule) {
            return response()->json('Данних не знайденно', 404);
        }

        $result = [
            'id' => $whymodule->id,
            'title' => $whymodule->title,
            'text' => $whymodule->text,
            'advantages' => $whymodule->advantages->map(function ($advantage) {
                return [
                    'id' => $advantage->id,
                    'text' => $advantage->name
                ];
            })
        ];
        return response()->json($result, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id) {
        $adminWhyModule = AdminWhyModule::findOrFail($id);
        // Оновити поля title та text
        $adminWhyModule->title = $request->input('title');
        $adminWhyModule->text = $request->input('text');
        $adminWhyModule->save();

        // Оновити пов'язані записи в таблиці advantages
        $advantages = $request->input('advantages');

        if ($advantages && is_array($advantages)) {
            // Видалити всі пов'язані записи
            $adminWhyModule->advantages()->detach();

            // Додати нові пов'язані записи
            foreach ($advantages as $advantage) {
                $advantageModel = Advantages::create([
                    'name' => $advantage['name']
                ]);

                $adminWhyModule->advantages()->attach($advantageModel->id);
            }
        }

        return response()->json('Дані успішно оновлені', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
