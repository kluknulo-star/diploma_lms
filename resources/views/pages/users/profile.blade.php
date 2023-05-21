@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent

<div class="container">
    <div class="profile">
        <div class="profile__container classic-box flex flex-just-start">

            <div class="profile__column mb30">
                <div class="profile__row mb20">
                    @if(mb_substr($user->avatar_filename,0,4) == 'http')
                        <img src="{{ URL::asset($user->avatar_filename) }}" alt="" class="profile__img">
                    @elseif($user->avatar_filename && file_exists('images/avatars/'.$user->user_id."/".$user->avatar_filename))
                        <img src="{{ URL::asset('images/avatars/'.$user->user_id."/".$user->avatar_filename) }}" alt="" class="profile__img">
                    @else
                        <img src="{{ URL::asset('images/default-avatar.png') }}" alt="" class="profile__img">
                    @endif
                    <div class="profile__name-email-col">
                        <div class="profile__name h2 mb15">{{ $user->surname }} {{ $user->name }}</div>
                        <div class="text">{{ $user->email }}</div>
                    </div>
                </div>
                @if (auth()->id() == $user->user_id)
                    <a href="{{ route('users.edit', ['id' => $user->user_id]) }}"
                       class="profile__edit-button button mb20">Редактировать профиль</a>
                    <a href="{{ route('users.edit.avatar', ['id' => $user->user_id]) }}"
                       class="profile__edit-button button mb20">Обновить аватар</a>
                @elseif (auth()->user()->is_teacher == 1 && $user->is_teacher != 1)
                    <form method="post" action="{{ route('users.assign.teacher', ['id' => $user->user_id]) }}">
                        @csrf
                        @method('patch')
                        <button type="submit" class="rounded-black-button button mb15">Назначить учителем</button>
                    </form>
                @endif
                <div class="text">LMS роль:
                    @if ($user->is_teacher == 1)
                        Учитель
                    @else
                        Студент
                    @endif</div>
            </div>

{{--            @if(auth()->id() == $user->user_id && auth()->user()->is_teacher == 1)--}}
{{--            <div class="profile__column_courses">--}}
{{--                <p class="h3 mb30">Экспортировать в Excel</p>--}}
{{--                <div class="mb30">--}}
{{--                    <a class="rounded-black-button" href="{{ route('courses.export', ['type' => 'all']) }}">Экспортировать все курсы</a>--}}
{{--                    <a class="rounded-black-button" href="{{ route('courses.export', ['type' => 'own']) }}">Экспортировать только мои курсы</a>--}}
{{--                </div>--}}
{{--                @foreach($exports as $export)--}}
{{--                    <form class="mb15" method="post" action="{{ route('courses.export.download', ['id' => $export->export_id]) }}">--}}
{{--                        @csrf--}}
{{--                        <button class="button rounded-red-button">Скачать {{ $export->export_file_path }}</button>--}}
{{--                    </form>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--            @endif--}}
        </div>
    </div>
</div>

@component('components.footer')
@endcomponent
