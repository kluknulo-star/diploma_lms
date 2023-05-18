<?php

namespace App\Courses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateCourseContentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
//            'sectionType' => 'required',
            'sectionTitle' => 'required|max:70',
            'sectionContent' => 'nullable|max:2048',
            'video' => [
                'nullable',
//                File::default()->max(50480),
//                'mimes:mp4,avi,mov,webm,mkv',
//                'max:50840'
            ],
            'image' => [
                'nullable',
//                File::default()->max(2480),
//                'image',
            ],
            'count_questions_to_pass' => 'nullable|int',
        ];
    }
}
