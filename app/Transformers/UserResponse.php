<?php

namespace App\Transformers;

class UserResponse extends Response
{
    public function transform($item)
    {
//        $item->desc = is_null($item->desc) ? '' : $item->desc;
        return parent::transform($item);
    }
}