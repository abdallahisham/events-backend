<?php

namespace App\Transformers;

use Illuminate\Http\JsonResponse;

abstract class Response extends JsonResponse
{
    public function __construct($content = '', $status = 200, array $headers = array())
    {
        $response = [
            'httpCode' => $status
        ];
        $response = $response + $this->transform($content);
        parent::__construct([
            'response' => $response
        ], $status, $headers);
    }

    /**
     * @param mixed $item
     * @return array
     */
    public function transform($item)
    {
        if (is_array($item)) {
            return $item;
        } else {
            return $item->toArray();
        }
    }
}