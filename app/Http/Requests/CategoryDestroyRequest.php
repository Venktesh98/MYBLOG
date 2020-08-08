<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allows to delete only when id's are not same else denies
        return !($this->route('category') == config('cms.default_category_id'));
    }

    public function forbiddenResponse()
    {
        return redirect()->back()->with('error-message','Unauthorised Action,cannot delete default Category!');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
