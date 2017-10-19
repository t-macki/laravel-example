<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest用のBaseクラス
 * Class BaseFormRequest
 * @package App\Http\Requests
 */
abstract class BaseFormRequest extends FormRequest
{
    abstract protected function transform(array $attrs);

    /**
     *
     * @return mixed
     */
    public function attrs()
    {
        $attrs = array_filter($this->all(), function ($k) {
            return 0 !== strpos($k, '_');
        }, ARRAY_FILTER_USE_KEY);

        return $this->transform($attrs);
    }
}
