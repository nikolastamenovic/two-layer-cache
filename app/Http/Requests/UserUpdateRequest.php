<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'date_of_birth' => 'required|date|before_or_equal:' . Carbon::now()->subYears(18),
            'address'       => 'required|string|max:75',
        ];
    }
}
