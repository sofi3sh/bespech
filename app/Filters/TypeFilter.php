<?php


namespace App\Filters;

class TypeFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('id_city', $value);
    }
}