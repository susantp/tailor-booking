<?php

namespace Modules\Measurement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Measurement\Services\PageService;

class MeasurementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(PageService $pageService)
    {
       return $pageService->getRules();
    }
}
