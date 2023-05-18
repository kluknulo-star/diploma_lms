@component('components.header')
@endcomponent

<div class="welcome">
    <div class="welcome__container">
        <div class="welcome__logo logo h2">
            CourseArea
        </div>
        <div class="welcome__title h2">
            Регистрация
        </div>
        <form method="post" action="{{ route('users') }}" class="welcome__form form">
            @csrf

            @if ($errors->has('surname'))
                <div class="alert alert-danger">
                    <ul>@foreach($errors->get('surname') as $message)<li>{{$message}}</li>@endforeach</ul>
                </div>
            @endif
            <input value="{{ old('surname') }}" name="surname" type="text" placeholder="Фамилия" class="welcome__input input @error('surname') is-invalid @enderror" required>

            @if ($errors->has('name'))
                <div class="alert alert-danger">
                    <ul>@foreach($errors->get('name') as $message)<li>{{$message}}</li>@endforeach</ul>
                </div>
            @endif
            <input value="{{ old('name') }}" name="name" type="text" placeholder="Имя" class="welcome__input input" required>

            @if ($errors->has('patronymic'))
                <div class="alert alert-danger">
                    <ul>@foreach($errors->get('patronymic') as $message)<li>{{$message}}</li>@endforeach</ul>
                </div>
            @endif
            <input value="{{ old('patronymic') }}" name="patronymic" type="text" placeholder="Отчество (необязательно)" class="welcome__input input">

            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    <ul>@foreach($errors->get('email') as $message)<li>{{$message}}</li>@endforeach</ul>
                </div>
            @endif
            <input value="{{ old('email') }}" name="email" type="email" placeholder="Почта" class="welcome__input input" required>

            @if ($errors->has('password'))
                <div class="alert alert-danger">
                    <ul>@foreach($errors->get('password') as $message)<li>{{$message}}</li>@endforeach</ul>
                </div>
            @endif
            <input name="password" type="password" placeholder="Пароль" class="welcome__input input" required>
            <input name="password_confirmation" type="password" placeholder="Повторите пароль" class="welcome__input input" required>
            <p class="welcome__text">Зарегестрированы? <a href="{{ route('login') }}">Войти</a></p>
            <button type="submit" class="welcome__button rounded-red-button button w100p">Зарегистрироваться</button>
        </form>

    </div>
</div>

@component('components.footer')
@endcomponent
