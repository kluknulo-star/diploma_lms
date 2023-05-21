@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent

<div class="container">
    <div class="classic-box">
        <p class="h2 mb15">Статистика курса</p>
        <p class="h3 mb30">"{{ $course->title }}"</p>
        <p class="mb15">Курс запущен: {{ $count['CourseLaunched'].'/'.$count['CourseAssigned']}} ({{(int)($count['CourseLaunched'] / $count['CourseAssigned'] * 100)}}%)</p>
{{--        <p class="mb15">Курс пройден: {{ $count['CoursePassed'].'/'.$count['CourseAssigned']}} ({{(int)($count['CoursePassed'] / $count['CourseAssigned'] * 100)}}%)</p>--}}
        <p class="mb15">Курс запущен и пройден хотя бы один материал: {{ $count['SectionPassed'].'/'.$count['CourseAssigned'] }} ({{(int)($count['SectionPassed'] / $count['CourseAssigned'] * 100)}}%)</p>
        <p class="mb30">Тест 1. Сложность: 15%</p>

        <a href="{{ route('courses.edit', ['id' => $courseId]) }}" class="back-button"><i class="fas fa-arrow-left"></i> Вернуться</a>
    </div>
</div>

@component('components.footer')
@endcomponent
