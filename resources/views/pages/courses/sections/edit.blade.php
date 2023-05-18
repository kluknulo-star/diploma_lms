@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent

<div class="container">
    @if (!empty(session()->get('success')))
        <div class="success">{{ session()->get('success') }}</div>
    @endif
    <div class="edit flex">
        <div class="edit__container edit__container-course classic-box mrauto">
            <div class="edit__title h2 mb30">Редактировнаие материала</div>
            <form method="post"
                  action="{{ route('courses.update.section', ['id' => $courseId, 'section_id' => $section->item_id]) }}"
                  enctype='multipart/form-data' class="edit__form form">
                @csrf
                @method('patch')
                @if ($errors->has('sectionTitle'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first('sectionTitle') }}</li>
                        </ul>
                    </div>
                @endif
                <input name="sectionTitle" value="{{ old('sectionTitle') ?? $section->title }}" placeholder="Название"
                       class="edit__input col-input input">
                @if ($section->type_id === 1)
                    @if ($errors->has('sectionContent'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ $errors->first('sectionContent') }}</li>
                            </ul>
                        </div>
                    @endif
                    <textarea oninput="countContent()"
                              id="section-content"
                              name="sectionContent"
                              placeholder="@if ($section->type_id != 4) Введите тест @else Введите количество правильных ответов для прохождения теста @endif "
                              style="width: 1298px; min-height: 300px; max-height: 300px;"
                              class="edit__input col-input input">@if ($section->type_id != 4){{ old('sectionContent') ?? json_decode($section->item_content) ?? '' }}@endif</textarea>
                    <p id="content-count"></p>/2048
                @endif

                @if ($section->type_id === 4)
                    <input name="count_questions_to_pass" type="number" min="1" placeholder="Количество правильных ответов для прохождения теста"
                           class="edit__input col-input input" value="{{ old('sectionTitle') ?? $quizCount }}">
                @endif

                @if($section->type_id === 2)
                    @if ($errors->has('image'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ $errors->first('image') }}</li>
                            </ul>
                        </div>
                    @endif
                    <input type="file" name="image" class="mb15" accept="image/*">
                @elseif($section->type_id === 3)
                    @if ($errors->has('video'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ $errors->first('video') }}</li>
                            </ul>
                        </div>
                    @endif
                    <input type="file" name="video" class="mb15" accept="video/*">
                @elseif($section->type_id === 4)
                    <a href="{{ route('quiz.questions.show', ['id' => $courseId, 'section_id' => $section->item_id, 'quiz' => json_decode($section->item_content, true)['quiz_id']]) }}"
                       class="text-al-cent rounded-red-button mb15 whitesmoke-text">Конструктор теста</a>
                @endif
                <button type="submit" class="rounded-black-button button mb15">Сохранить изменения</button>
                <a href="{{ route('courses.edit', ['id' => $courseId]) }}" class="back-button"><i
                        class="fas fa-arrow-left"></i> Назад</a>
            </form>
        </div>
    </div>
</div>

<script>
    function countContent() {
        var content = document.getElementById('section-content').value;
        document.getElementById('content-count').textContent = content.length;
    }

    countContent();
</script>

@component('components.footer')
@endcomponent
