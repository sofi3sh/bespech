<?php

namespace App\Models\CvEmployee;

use App\Models\VacanciesConditionDoc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesCv extends Model
{
    use HasFactory;
    protected $table = 'employees_cv';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'lang_id',
        'photo',
        'user_name',
        'education',
        'course',
        'work_experience',
        'job',
        'convenient_time',
        'description',
        'bad_habits',
        'beneficiaries',
        'your_expectation',
        'salary',
        'moving',
    ];
    public function cvConditions(){
        return $this->hasMany(EmployeesCvCondition::class, 'cv_id');
    }
    public function cvConditionsDescriptions(){
        return $this->belongsToMany(VacanciesConditionDoc::class, 'employees_cv_conditions','cv_id','condition_id');
    }
    public function getCvConditions(){
        $cvConditions = $this->cvConditionsDescriptions()->select('vacancies_condition_types_doc.id', 'name')->get();
        $result = $cvConditions->map(function ($condition) {
            return [
                'id' => $condition->id,
                'name' => $condition->name,
            ];
        });
        return $result;
    }

    public function addOrUpdateCvConditions($cvConditionsEmails, $cvId){
        EmployeesCvCondition::where('cv_id', $cvId)->delete();
        if ($cvConditionsEmails) {
            $cvEmails = collect($cvConditionsEmails)->map(function ($idEmail) use ($cvId) {
                return new EmployeesCvCondition([
                    'cv_id' => $cvId,
                    'condition_id' => $idEmail,
                ]);
            });
            EmployeesCvCondition::insert($cvEmails->toArray());
        }
    }

    public function cvPhones(){
        return $this->hasMany(EmployeeCvPhone::class, 'cv_id');
    }
    public function getCvPhones(){
        return $this->cvPhones()->pluck('phone')->toArray();
    }
    public function addOrUpdateCvPhones($cvConditionsEmails, $cvId){
        EmployeeCvPhone::where('cv_id', $cvId)->delete();
        if ($cvConditionsEmails) {
            $cvEmails = collect($cvConditionsEmails)->map(function ($idEmail) use ($cvId) {
                return new EmployeeCvPhone([
                    'cv_id' => $cvId,
                    'phone' => $idEmail,
                ]);
            });
            EmployeeCvPhone::insert($cvEmails->toArray());
        }
    }
    public function cvEmails(){
        return $this->hasMany(EmployeeCvEmail::class, 'cv_id');
    }
    public function getCvEmails(){
        return $this->cvEmails()->pluck('email')->toArray();
    }
    public function addOrUpdateCvEmails($cvConditionsEmails, $cvId){
        EmployeeCvEmail::where('cv_id', $cvId)->delete();
        if ($cvConditionsEmails) {
            $cvEmails = collect($cvConditionsEmails)->map(function ($idEmail) use ($cvId) {
                return new EmployeeCvEmail([
                    'cv_id' => $cvId,
                    'email' => $idEmail,
                ]);
            });
            EmployeeCvEmail::insert($cvEmails->toArray());
        }
    }


    public function cvFiles(){
        return $this->hasMany(EmployeeCvFile::class, 'cv_id');
    }
    public function addCvFiles($fileName, $fileSize, $cvId){
        $cvFile = new EmployeeCvFile();
        $cvFile->cv_id = $cvId;
        $cvFile->name = $fileName;
        $cvFile->size = $fileSize;
        $cvFile->save();
    }
}
