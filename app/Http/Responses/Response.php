<?php namespace App\Http\Responses;

use App\Transformers\BaseTransformer;
use App\Transformers\EventTransformer;
use App\Transformers\NullTransformer;
use Illuminate\Contracts\Support\Responsable;
use Spatie\Fractalistic\ArraySerializer;

class Response implements Responsable
{
    /**
     * Response original content
     * @var mixed
     */
    private $content;
    /**
     * Transformer that used to transform content
     * @var BaseTransformer
     */
    private $transformer;
    /**
     * Status code of response
     * @var int
     */
    private $status;

    public function __construct($content = [], BaseTransformer $transformer = null, int $status = 200)
    {
        $this->content = $content;
        $this->transformer = $transformer ?? new NullTransformer();
        $this->status = $status;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function toResponse($request)
    {
        $response = [];

        // Check if content has pagination
        if ($this->hasPagination()) {
            $response = [
                'current_page' => $this->content->currentPage(),
                'next_page_url' => $this->content->nextPageUrl(),
                'previous_page_url' => $this->content->previousPageUrl(),
            ];
        } else {
            $response['next_page_url'] = null;
        }
        // Set the http code
        $response['httpCode'] = $this->status;
        // Check if content is not empty (In some case response is just httpCode)
        if (!empty($this->content)) {
            $this->content = fractal($this->content, $this->transformer)->toArray();
            $response += $this->content;
        }
        return ['response' => $response];
    }

    private function hasPagination()
    {
        return method_exists($this->content, 'currentPage');
    }
}