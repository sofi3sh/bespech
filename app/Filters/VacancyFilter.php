<?php


namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class VacancyFilter extends AbstractFilter
{
    protected $filters = [
        'type' => TypeFilter::class
    ];
}