<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('css/quizzes/style.css') }}">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <title>Edit quiz</title>
</head>
<body>

@component('components.aside')
@endcomponent
<p style="text-align: center; padding-top: 20px;">
    <a href="{{ route('courses.edit.section', ['id' => $id, 'section_id' => $section_id]) }}">Назад к курсу→</a>
</p>
<div class="container">
    <div class="list list-none">
        @forelse($questions as $question)
            <div class="list-item">
                <div class="list-item-question">{{ $question->question_body }}</div>
                <div class="list-item-question-id" hidden>{{ $question->question_id }}</div>
                <a href="{{ route('quiz.options.show', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz, 'question' => $question->getKey()]) }}">Редактировать</a>
            </div>
        @empty

        @endforelse
    </div>

    <div class="form">
        <textarea class="question"></textarea>
        <div class="flex">
            <button class="add-question bg-gray-900 text-white p-3 m-2">Добавить</button>
            <button class="cancel-question bg-red-600 text-white p-3 m-2">Отменить</button>
        </div>
    </div>
    <div class="flex">
        <button class="add-btn bg-gray-900 text-white p-3 m-2">Добавить вопрос</button>
        <button type="button" class="save-changes bg-green-700 text-white p-3 m-2" onclick="saveChanges()">Сохранить</button>
    </div>

</div>
<script>
    let quizList = document.querySelectorAll('.list');
    let items = document.querySelectorAll('.list-item');

    function addQuestion() {
        const btn = document.querySelector('.add-btn');
        const addBtn = document.querySelector('.add-question');
        const cancelBtn = document.querySelector('.cancel-question');
        const textarea = document.querySelector('.question');
        const form = document.querySelector('.form');
        let value;

        btn.addEventListener('click', () => {
            form.style.display = 'block';
            btn.style.display = 'none';
            addBtn.style.display = 'none';

            textarea.addEventListener('input', e => {
                value = e.target.value;

                if (value) {
                    addBtn.style.display = 'block';
                } else {
                    addBtn.style.display = 'none';
                }
            });
        });

        cancelBtn.addEventListener('click', () => {
            value = '';
            clear();
        });

        addBtn.addEventListener('click', () => {
            const newItem = document.createElement('div');
            newItem.classList.add('list-item');


            const newQuestion = document.createElement('div');
            newQuestion.classList.add('list-item-question');
            newQuestion.textContent = value;
            newItem.append(newQuestion);

            quizList[0].append(newItem);
            value = '';
            clear();

            newItem.addEventListener('dblclick', e => {
                newItem.remove();
            });
        });
    }

    function clear() {
        const btn = document.querySelector('.add-btn');
        const textarea = document.querySelector('.question');
        const form = document.querySelector('.form');

        textarea.value = '';
        form.style.display = 'none';
        btn.style.display = 'block';
    }

    function saveChanges() {
        let obj = [];
        const list = document.querySelectorAll('.list-item');
        list.forEach(el => {
            let question = el.querySelector('.list-item-question').textContent;
            obj.push(question);
        });
        fetch("{{ route('quiz.questions.store', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'url': "{{ route('quiz.questions.store', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}",
                "X-CSRF-Token": document.head.querySelector("[name=csrf-token]").content
            },
            body: JSON.stringify(obj),
        }).then(response => {
            if (response.status === 302) {
                window.location.replace("{{ route('quiz.questions.show', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}");
            }
        });
    }

    clear();
    addQuestion();

    items.forEach(item => {
        item.addEventListener('dblclick', e => {
            let obj = {
                "questionId": item.querySelector('.list-item-question-id').textContent,
            };
            item.remove();

            fetch("{{ route('quiz.questions.delete', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}", {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'url': "{{ route('quiz.questions.delete', ['id' => $id, 'section_id' => $section_id, 'quiz' => $quiz]) }}",
                    "X-CSRF-Token": document.head.querySelector("[name=csrf-token]").content
                },
                body: JSON.stringify(obj),
            }).then(response => {
                if (response.status === 200) {
                    response.text().then(text => {
                        alert(text);
                    });
                }
            });
        });
    });
</script>
</body>
</html>
