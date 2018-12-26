<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    abstract public function transform($model);
}