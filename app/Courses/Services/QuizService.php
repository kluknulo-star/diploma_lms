<?php

namespace App\Courses\Services;

use App\Courses\Helpers\ClientLRS;
use App\Courses\Helpers\LocalStatements;
use App\Courses\Quizzes\Models\Option;
use App\Courses\Quizzes\Models\Question;
use App\Courses\Quizzes\Models\Quiz;
use App\Users\Models\User;
use Illuminate\Support\Facades\DB;

class QuizService
{
    public function __construct(private CourseService $courseService, private StatementService $statementService)
    {
    }
    public function getQuiz(int $id, array $relations=[])
    {
        return Quiz::with($relations)->find($id);
    }

    public function createQuiz(int $countQuestionsToPass=0) : Quiz
    {
        return Quiz::create(['count_questions_to_pass' => $countQuestionsToPass]);
    }

    public function updateQuiz(int $countQuestionsToPass=0) : Quiz
    {
        return Quiz::update(['count_questions_to_pass' => $countQuestionsToPass]);
    }

    public function createQuestion(Quiz $quiz, string $question) : Question
    {
        return Question::firstOrcreate([
            'question_body' => $question,
            'quiz_id' => $quiz->getKey(),
        ]);
    }

    public function deleteAllQuestionOptions(Quiz $quiz, int $questionId) : void
    {
        $quiz->questions->where('question_id', $questionId)->first()->options()->delete();
    }

    public function addQuestionOption(int $questionId, array $option) : void
    {
        $opt = Option::firstOrNew(
            [
                'question_id' => $questionId,
                'option_body' => $option['optionBody'],
            ],
            [
                'option_body' => $option['optionBody'],
                'is_correct' => $option['isCorrect']
            ]
        );

        $opt->option_body = $option['optionBody'];
        $opt->is_correct = $option['isCorrect'];
        $opt->save();
    }

    public function deleteQuestion(Quiz $quiz, int $questionId) : void
    {
        Question::where([
            'question_id' => $questionId,
            'quiz_id' => $quiz->getKey(),
        ])->delete();
    }

    public function storeResults(Quiz $quiz, int $correctAnswersCount)
    {

        DB::table('quiz_results')->insert([
            'count_correct_questions' => $correctAnswersCount,
            'count_questions_to_pass' => $quiz->count_questions_to_pass,
            'count_questions'=> $quiz->questions->count(),
            'quiz_id' => $quiz->getKey(),
            'user_id' => auth()->id(),
        ]);
    }

    public function sendResultToLRS(Quiz $quiz, int $correctAnswersCount, int $courseId, int $sectionId)
    {
        $course = $this->courseService->getCourse($courseId);
        $allCourseContent = json_decode($course->content);
        $section = $this->statementService->getSection($allCourseContent, $sectionId);

        /** @var User $user */
        $user = auth()->user();

        $statementLocalSend = new LocalStatements();
        $verb = 'failed';
        if ($correctAnswersCount >= $quiz->count_questions_to_pass)
        {
            $verb = 'passed';
        }
        $statementLocalSend->sendLocalStatement($user->user_id, $sectionId, $verb);
        return ClientLRS::sendStatement($user, $verb, $course, $section);
    }

    public function retrieveResults(Quiz $quiz)
    {
        return DB::table('quiz_results')
            ->where([
            ['quiz_id', '=', $quiz->getKey()],
            ['user_id', '=', auth()->id()],
            ])
            ->orderByDesc('result_id')
            ->first();
    }

    public function isAnswerSelected(array $options)
    {
        foreach($options as $option) {
            if ($option['isCorrect']) {
                return true;
            }
        }
        return false;
    }
}
