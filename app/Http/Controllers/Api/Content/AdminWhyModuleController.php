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

public function index (Request $request){
    if ($request->id) {
        $whymodule = AdminWhyModule::with('advantages')->find($request->id);
        $result = [
            'title' => $whymodule->title,
            'text' => $whymodule->text,
            'advantages' => $whymodule->advantages->map(function ($advantage) {
                return [
                    'id' => $advantage->id,
                    'name' => $advantage->name
                ];
            })
        ];
        return response()->json($result, 200);
    } else {
        $whymodules = AdminWhyModule::with('advantages')->get();
        $result = $whymodules->map(function ($whymodule) {
            return [
                'title' => $whymodule->title,
                'text' => $whymodule->text,
                'advantages' => $whymodule->advantages->map(function ($advantage) {
                    return [
                        'id' => $advantage->id,
                        'name' => $advantage->name
                    ];
                })
            ];
        });
        return response()->json($result, 200);
    }
}
    public function storeAdvantage(Request $request)
    {
        $advantage = Advantages::create([
            'name' => $request->input('name')
        ]);

        $adminWhyModule = AdminWhyModule::find(1); // Замініть 1 на потрібний id модуля

        $adminWhyModule->advantages()->attach($advantage->id);

        return response()->json('Дані успішно додані і пов\'язані з модулем', 200);
    }

    public function updateAdvantage(Request $request, $id)
    {
        $advantage = Advantages::find($id);

        if (!$advantage) {
            return response()->json('Дані не знайдені', 404);
        }

        $advantage->name = $request->input('name');
        $advantage->save();

        return response()->json('Дані успішно оновлені', 200);
    }

    public function deleteAdvantage($id)
    {
        $advantage = Advantages::find($id);

        if (!$advantage) {
            return response()->json('Дані не знайдені', 404);
        }

        $advantage->delete();

        return response()->json('Дані успішно видалені', 200);
    }
    public function getAdvantagesWithNames()
    {
        $advantages = AdminWhyModuleAdvantages::with('advantage')->get();

        $data = [];
        foreach ($advantages as $advantage) {
            $advantageData = [
                'id' => $advantage->id,
                'admin_why_module_id' => $advantage->admin_why_module_id,
                'advantage_id' => $advantage->advantage_id,
                'name' => $advantage->advantage ? $advantage->advantage->name : null,
            ];
            $data[] = $advantageData;
        }

        return response()->json($data, 200);

    }
}
