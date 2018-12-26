<?php namespace App\Responses;

use App\Transformers\BaseTransformer;
use App\Transformers\EventTransformer;
use Illuminate\Contracts\Support\Responsable;

class Response implements Responsable
{
    /**
     * The response original content
     * @var mixed
     */
    private $content;
    /**
     * Status code of response
     * @var int
     */
    private $status;
    /**
     * Transformer that used to transform content
     * @var BaseTransformer
     */
    private $transformer;

    public function __construct($content, int $status, BaseTransformer $transformer)
    {
        $this->content = $content;
        $this->status = $status;
        $this->transformer = $transformer;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function toResponse($request)
    {
        $response = ['httpCode' => $this->status];
        //
        if ($this->hasPagination()) {
            $response = array_merge($response, [
                'current_page' => $this->content->currentPage(),
                'next_page_url' => $this->content->nextPageUrl(),
                'previous_page_url' => $this->content->previousPageUrl(),
                'is_first_page' => $this->content->onFirstPage()
            ]);
        }

        $response = array_merge($response, [
            'data' => $this->content->all()
        ]);

        return [
            'response' => $response
        ];
    }

    private function hasPagination()
    {
        return method_exists($this->content, 'currentPage');
    }
}