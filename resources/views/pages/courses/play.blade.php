@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent

<div class="container">
    <img src="" alt="" class="courses__img">
    <div class="h1 mb20">{{ $course->title }}
        @if ($course->author->user_id == auth()->id())
            <a class="ml20 h1" href="{{ route('courses.edit', ['id' => $course->course_id]) }}"><i
                    class="fa-solid fa-pen"></i></a>
        @endif
    </div>
    <div class="margin5">
        Автор: <a
            href="{{ route('users.show', ['id' => $course->author->user_id]) }}">
            {{ $course->author->email }}
        </a>
    </div>
    <div class="courses__course-description mb30">Описание: {{ Str::limit($course->description, 200, '...') }}</div>

    <p style="color: black; margin-bottom: 20px;" allContent="{{ count($course->content) }}"
       passedContent="{{ round(count($myCourseProgress['passed'])) }}"
       class="progress h3">{{ $myCourseProgress['progress'] }}</p>
    <br><br>
    <b class="h2 mb20">Содержание:</b>
    @foreach($course->content as $element)
        @if ($element->deleted_at === null)
            <div class="margin20-0 courses__course-content">
                <b class="h3" style="font-weight: 400;">{{$element->title}}</b><br><br>
                ❮{{$element->type->type}}❯

                <button class="send-stmt-button"
                        id="{{$element->item_id}}launched"
                        verb="launched"
                        sectionId="{{$element->item_id}}"
                        courseId="{{$course->course_id}}"
                        @if(in_array($element->item_id, $myCourseProgress['launched']))
                            disabled
                        style="padding: 5px; background: rgba(0,0,0,0); color: #15803D !important;"
                        @else
                            style="padding: 5px; background: rgba(0,0,0,0); color: #eb4432;"
                    @endif>
                    <i class="fas fa-check"></i>
                </button>

                <button class="send-stmt-button"
                        id="{{$element->item_id}}passed"
                        verb="passed"
                        sectionId="{{$element->item_id}}"
                        courseId="{{$course->course_id}}"
                        @if(in_array($element->item_id, $myCourseProgress['passed']))
                        disabled
                        style="padding: 5px; background: rgba(0,0,0,0); color: #15803D !important;"
                        @else
                            {{($element->type->type == 'Тест') ? 'disabled' : ''}}
                            style="padding: 5px; background: rgba(0,0,0,0); color: #eb4432;"
                    @endif>
                    <i class="fas fa-check-double"></i>
                </button>

                @if($element->type->type == 'Тест')
                    @if(in_array($element->item_id, $myCourseProgress['passed']))
                        <a class="rounded-green-button" href="{{ route('quiz.play', ['id' => $course->getKey(), 'section_id' => $element->getKey(), 'quiz' => json_decode($element->item_content, true)['quiz_id']]) }}">Пройти заново</a>
                    @else
                        <a class="rounded-red-button" href="{{ route('quiz.play', ['id' => $course->getKey(), 'section_id' => $element->getKey(), 'quiz' => json_decode($element->item_content, true)['quiz_id']]) }}">Пройти тест</a>
                    @endif
                @endif

                <form>
                    @csrf
                    @method('post')
                </form>
                <br>


                @if($element->type->type == 'Текст')
{{--                    {{$element->item_content}}--}}
                @foreach(explode("\r\n", json_decode($element->item_content)) as $line )
{{--                    <p>{!!  str_replace("\r\n", "<br><br>",json_decode($element->item_content)) ?? ""!!}</p>--}}
                    <p class="h4">{{$line}}</p> <br>
                @endforeach
                @elseif($element->type->type == 'Изображение')
                    <img src="{{url(json_decode($element->item_content))}}" alt="img" width="600" style="border-radius: 10px">
                @elseif($element->type->type == 'Видео')
                    <video style="border-radius: 10px" width="600" controls="controls">
                        <source src="{{url(json_decode($element->item_content))}}">
                    </video>
                @endif
            </div>
        @endif
    @endforeach

    <button id="send-stmt-passed-button"
            class="rounded-black-button mb30"
            courseId="{{ $course->course_id }}">
        Завершить курс
    </button>

</div>

<script>
    var passedContent = $('.progress').attr('passedContent');
    var allContent = $('.progress').attr('allContent');
    if (allContent == 0) {
        $('.progress').text('Прогресс: 0%');
    } else {
        $('.progress').text('Прогресс: ' + Math.round((passedContent) / allContent * 100) + '%');
    }

    var myCourseProgressPassed = {{ json_encode($myCourseProgress['passed']) }};
    var myCourseProgressLaunched = {{ json_encode($myCourseProgress['launched']) }};

    $(".send-stmt-button").click(function () {
        var sectionId = $(this).attr('sectionId');
        var courseId = $(this).attr('courseId');
        var verb = $(this).attr('verb');

        $.ajax({
            headers: {
                'X-Csrf-Token': $('input[name="_token"]').val()
            },
            type: 'POST',
            dataType: 'html',
            url: '/send-' + verb + '/' + courseId + '/' + sectionId,
            data: {
                'myCourseProgressPassed': myCourseProgressPassed,
                'myCourseProgressLaunched': myCourseProgressLaunched
            },
            timeout: 500,
            success: function (html) {
                if (verb === 'passed') {
                    $('#' + sectionId + 'passed').text(html).prop('disabled', true).css('color', '#15803D');
                    setTimeout(() => {
                        $('#' + sectionId + 'passed').html('<i class="fas fa-check-double"></i>');
                    }, 3000);
                    $('.progress').text('Прогресс: ' + Math.round(++passedContent / allContent * 100) + '%');
                    myCourseProgressPassed.push(sectionId);
                }
                if (verb === 'launched') {
                    $('#' + sectionId + 'launched').text(html).prop('disabled', true).css('color', '#15803D');
                    setTimeout(() => {
                        $('#' + sectionId + 'launched').html('<i class="fas fa-check"></i>');
                    }, 3000);
                    myCourseProgressLaunched.push(sectionId);
                }
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log('Error' + errorMessage);
            }
        });
    });

    $("#send-stmt-passed-button").click(function () {
        var courseId = $(this).attr('courseId');

        $.ajax({
            headers: {
                'X-Csrf-Token': $('input[name="_token"]').val()
            },
            type: 'POST',
            dataType: 'html',
            url: '/send-passed/' + courseId,
            data: {
                'myCourseProgressPassed': myCourseProgressPassed,
                'myCourseProgressLaunched': myCourseProgressLaunched
            },
            timeout: 500,
            success: function (html) {
                $('#send-stmt-passed-button').text(html).prop('disabled', true).css('background', '#15803D');
                setTimeout(() => {
                    $('#send-stmt-passed-button').text('Курс завершен');
                }, 1500);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                $(this).text('Error' + errorMessage);
            }
        });
    });
</script>

@component('components.footer')
@endcomponent
