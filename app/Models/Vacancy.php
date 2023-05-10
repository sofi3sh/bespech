<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Filters\VacancyFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\hasManyThrough;





class Vacancy extends Model
{
    use HasFactory;

    protected $table = 'vacancies';
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_dcz_vac',
        'status',
        'region_id',
        'city_id',
        'company_name',
        'education',
        'source',
        'register_date'
    ];
     public function scopeFilter(Builder $builder, $request)
    {
        return (new VacancyFilter($request))->filter($builder);
    }
    public function getVacancyDescription($search=0){
        return $this->hasMany(VacancyDescription::class, 'vac_id');
    }
    public function getVacancySalary(){
        return $this->hasMany(VacanciesSalary::class, 'vac_id');
    }
    //    public function getVacancyCondition(){
//        return $this->hasManyThrough(
//            VacanciesConditionDoc::class,
//            VacanciesCondition::class,
//            'vac_id',
//            'id',
//            'id',
//            'condition_id',
//        );
//    }
    public function getVacancyCondition(){
        return $this->belongsToMany(VacanciesConditionDoc::class, 'vacancies_condition_types','vac_id','condition_id');
    }
    public function getVacancyCurrency(){
        return $this->belongsToMany(Currency::class, 'vacancies_salaries','vac_id','currency_id');
    }
    public function getVacancyContacts(){
        return $this->hasMany(VacanciesContact::class, 'vac_id');
    }
    public function getOnlyDczVac(){
        $ourData = Vacancy::where('source', '=', 'dcz')->update(['status' => 0]);
    }
    public function addVacancyDescription($vacancyDescriptions){
        VacancyDescription::insert($vacancyDescriptions);
    }
    public function addVacanciesContact($vacancyContact){
        VacanciesContact::insert($vacancyContact);
    }
    public function addVacanciesCondition($vacancyCondition){
        VacanciesCondition::insert($vacancyCondition);
    }
    public function addVacanciesSalary($vacancySalary){
        VacanciesSalary::insert($vacancySalary);
    }

}

