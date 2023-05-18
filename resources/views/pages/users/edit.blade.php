@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent

<div class="container">
    <div class="edit">
        <div class="edit__container classic-box mrauto">
            <div class="edit__title h2 mb30">Редактирование пользователя</div>
            <form method="post" action="{{ route('users.update', ['id' => $user->user_id]) }}" class="edit__form form">
                @csrf
                @method('patch')

                <input name="user_id" value="{{ old('user_id') ?? $user->user_id }}" type="hidden" class="edit__input col-input input">

                @if ($errors->has('surname'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('surname') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="surname" value="{{ old('surname') ?? $user->surname }}" type="text" placeholder="Фамилия" class="edit__input col-input input">

                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('name') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="name" value="{{  old('name') ?? $user->name }}" type="text" placeholder="Имя" class="edit__input col-input input">

                @if ($errors->has('patronymic'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('patronymic') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="patronymic" value="{{  old('patronymic') ?? $user->patronymic }}" type="text" placeholder="Отчество (необязательно)" class="edit__input col-input input">

                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('email') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="email" value="{{  old('email') ?? $user->email }}" type="email" placeholder="Почта" class="edit__input col-input input">

                @if ($errors->has('password'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('password') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="password" type="password" placeholder="Пароль" class="edit__input col-input input">
                <input name="password_confirmation" type="password" placeholder="Повторите пароль" class="edit__input input mb30">
                <button type="submit" class="edit__button rounded-red-button button mb20">Сохранить изменения</button>
                <a href="{{ url()->previous() }}" class="back-button"><i class="fas fa-arrow-left"></i>Вернуться</a>
            </form>
        </div>
    </div>
</div>

@component('components.footer')
@endcomponent
