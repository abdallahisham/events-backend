<?php namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

/**
 * Class ResponseWithCode
 * @package App\Http\Responses
 * Response with just http code
 */
class ResponseWithCode implements Responsable
{
    /**
     * @var int -> Status code of reponse
     */
    private $statusCode;

    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function toResponse($request)
    {
        return [
            'response' => [
                'httpCode' => $this->statusCode ?? 200
            ]
        ];
    }
}