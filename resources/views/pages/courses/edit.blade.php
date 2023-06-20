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
            <div class="edit__title h2 mb30 flex flex-just-spbtw"> Редактировать курс
                @can ('view', [$course])
                    <form method="get" class="w24p" action="{{ route('courses.play', ['id' => $course->course_id]) }}">
                        <button type="submit" class="edit__button rounded-yellow-button button w100p whitesmoke-text">Запустить курс</button>
                    </form>
                @endcan
            </div>
            <form id="edit-course-form" method="post" action="{{ route('courses.update', ['id' => $course->course_id]) }}" class="edit__form form">
                @csrf
                @method('patch')

                <input name="course_id" value="{{ old('course_id') ?? $course->course_id }}" type="hidden" class="edit__input col-input input">

                @if ($errors->has('title'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('title') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input placeholder="Название" name="title" value="{{ old('title') ?? $course->title }}" class="edit__input col-input input">

                @if ($errors->has('description'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('description') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <textarea placeholder="Описание" name="description" class="edit__input col-input input h150">{{ old('description') ?? $course->description }}</textarea>
            </form>

            <div class="flex flex-just-spbtw">
                <button form="edit-course-form" type="submit" class="w24p edit__button rounded-green-button button mb15">Сохранить изменения</button>

                <form method="get" class="w24p" action="{{ route('courses.edit.assignments', ['id' => $course->course_id, 'state' => 'already']) }}">
                    <button type="submit" class="edit__button rounded-black-button button w100p mb15 whitesmoke-text">Зачисленные студенты</button>
                </form>
{{--                <form method="get" class="w24p" action="{{ route('courses.statistics', ['id' => $course->course_id]) }}">--}}
{{--                    <button type="submit" class="edit__button rounded-blue-button button w100p mb15 whitesmoke-text">Статистика прохождения</button>--}}
{{--                </form>--}}
                <button class="edit__button rounded-red-button button w24p mb15" onclick="document.getElementById('delete-modal-<?= $course->course_id  ?>').style.display = 'flex'">
                    Удалить курс
                </button>
            </div>

        </div>
        <div class="edit__container edit__container-course classic-box">
            <div class="edit__title h2 mb30">Добавить материал</div>
            <form method="post" action="{{ route('courses.create.section', ['id' => $course->course_id]) }}" class="edit__form form">
                @csrf
                @method('post')
                @if ($errors->has('sectionTitle'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('sectionTitle') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="sectionTitle" placeholder="Название" value="{{ old('sectionTitle') }}" type="text" class="edit__input col-input input">

                @if ($errors->has('sectionType'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('sectionType') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <select class="select mb20" name="sectionType" id="">
                    <option value="1">Текст</option>
                    <option value="2">Изображение</option>
                    <option value="3">Видео</option>
                    <option value="4">Тест</option>
                </select>
                <button type="submit" class="edit__button rounded-black-button button mb15">Создать</button>
            </form>
        </div>
    </div>
    <div class="edit">
        <div class="edit__container edit__container-course classic-box mrauto">
            <div class="edit__title h2 mb30">
                Материалы курса
            </div>
            <table class="users__table">
                <thead>
                <tr class="users__tr users__tr_head">
                    <th class="users__td">Тип</th>
                    <th class="users__td">Название</th>
                    <th class="users__td">Действия</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($course->content as $element)
                        <tr class="users__tr">
                            <th class="users__td">
                                {{$element->type->type}}
                            </th>
                            <th class="users__td">{{ $element->title }}</th>
                            <th class="users__td">
                                @if (!$element->deleted_at)
                                <a class="table-action-button table-edit-button" href="{{ route('courses.edit.section', ['id' => $course->course_id, 'section_id' => $element->item_id]) }}"><i class="fas fa-pen"></i></a>
                                <button class="table-action-button table-delete-button" onclick="document.getElementById('delete-modal-<?= $element->item_id ?>').style.display = 'flex'">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @else
                                    <a class="courses__course-restore"
                                       onclick="document.getElementById('restore-modal-<?= $element->item_id  ?>').style.display = 'flex'">
                                        <i class="fa-solid fa-arrow-rotate-right yellow-text"></i>
                                    </a>
                                @endif
                            </th>
                        </tr>

                        <div class="modal" id="restore-modal-{{ $element->item_id }}">
                            <div class="modal-box">
                                <p class="modal-text modal-text-restore mb20 mr20">Вы уверены, что хотите <span>восстановить</span> материал:
                                    "{{ $element->title }}" ?</p>

                                <div class="modal-buttons">
                                    <form class="table-action-form"
                                          action="{{ route('courses.restore.section', ['id' => $course->course_id, 'section_id' => $element->item_id]) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="table-action-button confirm-button">Подвердить</button>
                                    </form>
                                    <button
                                        onclick="document.getElementById('restore-modal-<?= $element->item_id ?>').style.display = 'none'"
                                        class="table-action-button cancel-button">Отклонить
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="delete-modal-{{ $element->item_id }}">
                            <div class="modal-box">
                                <p class="modal-text modal-text-delete mb20 mr20">Вы уверены, что хотите <span>удалить</span> материал: {{ $element->title }}?</p>

                                <div class="modal-buttons">
                                    <form class="table-action-form" action="{{ route('courses.destroy.section', ['id' => $course->course_id, 'section_id' => $element->item_id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input name="user_id" type="hidden" value="{{ $course->course_id }}">
                                        <button type="submit" class="table-action-button confirm-button">Подтвердить</button>
                                    </form>
                                    <button onclick="document.getElementById('delete-modal-<?= $element->item_id ?>').style.display = 'none'" class="table-action-button cancel-button">Отклонить</button>
                                </div>

                            </div>
                        </div>
                    @empty
                        Материалы отсутствуют
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(!$course->content)
<div class="modal" id="delete-modal-{{ $element->item_id }}">
    <div class="modal-box">
        <p class="modal-text modal-text-delete mb20 mr20"> {{ $element->title }}?</p>

        <div class="modal-buttons">
            <form class="table-action-form" action="{{ route('courses.destroy.section', ['id' => $course->course_id, 'section_id' => $element->item_id]) }}" method="post">
                @csrf
                @method('delete')
                <input name="user_id" type="hidden" value="{{ $course->course_id }}">
                <button type="submit" class="table-action-button confirm-button">{{ __('main.confirm') }}</button>
            </form>
            <button onclick="document.getElementById('delete-modal-<?= $element->item_id ?>').style.display = 'none'" class="table-action-button cancel-button">{{ __('main.cancel') }}</button>
        </div>

    </div>
</div>
@endif

<div class="modal" id="delete-modal-{{ $course->course_id }}">
    <div class="modal-box">
        <p class="modal-text modal-text-delete mb20 mr20">{{ __('main.sureQuestion') }} <span>{{ __('main.delete') }}</span> {{ __('main.course') }}: "{{ $course->title }}"?</p>

        <div class="modal-buttons">
            <form class="table-action-form" action="{{ route('courses.delete', ['id' => $course->course_id]) }}" method="post">
                @csrf
                @method('delete')
                <input name="user_id" type="hidden" value="{{ $course->course_id }}">
                <button type="submit" class="table-action-button confirm-button">{{ __('main.confirm') }}</button>
            </form>
            <button onclick="document.getElementById('delete-modal-<?= $course->course_id ?>').style.display = 'none'" class="table-action-button cancel-button">{{ __('main.cancel') }}</button>
        </div>

    </div>
</div>

@component('components.footer')
@endcomponent
