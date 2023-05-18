<?php

namespace App\Courses\Services;

use App\Courses\Models\CourseItems;
use App\Courses\Quizzes\Models\Quiz;
use App\Courses\Repositories\CourseContentRepository;
use Illuminate\Support\Facades\Storage;

class CourseContentService
{
    public function __construct(
        private CourseContentRepository $courseContentRepository,
        private QuizService $quizService
    )
    {
    }

    public function update($validated, $sectionId, $courseId): bool
    {
        $courseContent['title'] = $validated['sectionTitle'];
        if (isset($validated['sectionContent'])){
            $courseContent['item_content'] = json_encode($validated['sectionContent']);
        }

        if (isset($validated['count_questions_to_pass'])){
            $quizId = json_decode(CourseItems::find($sectionId)->item_content, true)['quiz_id'];
            $quiz = Quiz::find($quizId);
            $quiz->update(['count_questions_to_pass' => $validated['count_questions_to_pass']]);
            unset($validated['count_questions_to_pass']);
        }

        if (isset($validated['video'])){
            $courseContent['item_content'] = json_encode('storage/' .Storage::disk('public')->put("video/$courseId", $validated['video']));
        }
        if (isset($validated['image'])){
            $courseContent['item_content'] = json_encode('storage/' . Storage::disk('public')->put("image/$courseId", $validated['image']));
        }

        return $this->courseContentRepository->update($sectionId, $courseContent);
    }

    public function store($validated, $courseId): CourseItems
    {
        $courseContent['course_id'] = $courseId;
        $courseContent['title'] = $validated['sectionTitle'] ?? '';
        $courseContent['type_id'] = $validated['sectionType'];

        if ($courseContent['type_id'] == 4) {
            $quizId = ($this->quizService->createQuiz())->getKey();
            $courseContent['item_content'] = json_encode(['quiz_id' => $quizId]);
        }
        else{
            $courseContent['item_content'] = json_encode('');
        }

        return $this->courseContentRepository->create($courseContent);
    }

    public function destroy($sectionId): bool
    {
        return $this->courseContentRepository->destroy($sectionId);
    }

    public function restore($sectionId): bool
    {
        return $this->courseContentRepository->restore($sectionId);
    }
}
