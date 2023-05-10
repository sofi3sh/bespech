<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityZone extends Model
{
    use HasFactory;

    protected $table = 'city_zones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id',
        'name',
    ];

    public function getCityIdAndRegionIDByCityName($cityName){
        $arrCityRegionId = $this->select('id', 'region_id')->where('name', $cityName)->first();
        if(!is_null($arrCityRegionId)){
            return ['city_id'=>$arrCityRegionId->id,'region_id'=>$arrCityRegionId->region_id];
        }else{
            return ['city_id'=>0,'region_id'=>0];
        }
    }
    public function getCityNameById($city_id){
        if($city_id){
            $sityQuerryResult = $this->select('name', 'region_id')->where('id', $city_id)->first();
            if(!$sityQuerryResult){
                return ['city_name'=>null, 'region_name'=>null];
            }
            $sityName = $sityQuerryResult->name;
            $regionName = Region::where('id', $sityQuerryResult->region_id)->select('name')->first()->name;
            return ['city_name'=>$sityName, 'region_name'=>$regionName];
        }else{
            return ['city_name'=>null, 'region_name'=>null];
        }
    }

    // test

}
