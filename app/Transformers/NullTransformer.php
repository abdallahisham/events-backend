<?php namespace App\Transformers;

class NullTransformer extends BaseTransformer
{

    public function transform($model)
    {
        return [];
    }
}