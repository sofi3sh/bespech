<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Vacancy;
use App\Models\CityZone;


class FiltersController extends Controller{
    public function filterVacantions($search, $minsalary, $maxsalary, $condition, $cityid, $regionid){
        $query = Vacancy::query();
        if (!empty($search)) {
            $query->whereHas('getVacancyDescription', function ($subquery) use ($search) {
                $subquery->where('vac_name', 'LIKE', "%$search%");
            });
        }
        if (!empty($minsalary)) {
            $query->whereHas('getVacancySalary', function ($subquery) use ($minsalary) {
                $subquery->where('salary', '>=', $minsalary);
            });
        }
        if (!empty($maxsalary)) {
            $query->whereHas('getVacancySalary', function ($subquery) use ($maxsalary) {
                $subquery->where('salary', '<=', $maxsalary);
            });
        }
        if (!empty($cityid)) {
            $query->where('city_id', $cityid);
        }
        if (!empty($regionid)) {
            $query->where('region_id', $regionid);
        }
        if (!empty($condition)) {
            $condition = explode(",", $condition);
            $condition = array_map('intval', $condition);
            $query->whereHas('getVacancyCondition', function ($subquery) use ($condition) {
                $subquery->whereIn('condition_id', $condition);
            });
        }
        return $query;
    }
}
