<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('css/quizzes/style.css') }}">
    <title>Quiz results</title>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">


</head>
<body>
@component('components.aside')
@endcomponent
    <div class="container">
        <div id="result-bar" class="justify-start flex-column">
            <div class="result-container">
            </div>
        </div>
    </div>
<script>
    async function start() {
        let response = await fetch("{{ route('quiz.results.retrieve', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'url': "{{ route('quiz.results.retrieve', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}",
                "X-CSRF-Token": document.head.querySelector("[name=csrf-token]").content
            },
        });

        let result = await response.json();
        let resultContainer = document.querySelector('.result-container');
        resultContainer.innerHTML += `<p class="result-text">
                        Вы ответили правильно на ${result.count_correct_questions} вопрос(-а)(-ов) из ${result.count_questions}
                    </p>
                    <p class="result-text">
                        Для успешного прохождения необходимо ответить правильно на ${result.count_questions_to_pass} вопрос(-а)(-ов)
                    </p>`;

        if (result.count_correct_questions < result.count_questions_to_pass) {
            resultContainer.innerHTML += `<p class="result-text incorrect-text">
                        Провалено
                    </p> <p style="text-align:center; "> <a href="{{ route('courses.play', ['id' => $id]) }}">Вернуться к курсу→</a> <p>`;
        } else {
            resultContainer.innerHTML += `<p class="result-text correct-text">
                        Пройдено
                    </p> <p style="text-align:center; "> <a href="{{ route('courses.play', ['id' => $id]) }}">Вернуться к курсу→</a> <p>`;
        }
    }

    start();
</script>
</body>
</html>
