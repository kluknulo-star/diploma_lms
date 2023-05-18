@component('components.header')
@endcomponent

<div class="welcome">
    <div class="welcome__container">
        <div class="welcome__logo logo h2">
            CourseArea
        </div>
        <div class="welcome__title h2">
            Вход
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('authenticate') }}" class="welcome__form form">
            @csrf
            <input name="email" type="email" placeholder="Почта" class="welcome__input input" required>
            <input name="password" type="password" placeholder="Пароль" class="welcome__input input" required>
            <p class="welcome__text">Не зарегистрированы?&nbsp<a href="{{ route('register') }}">Регистрация</a></p>
{{--            <p class="welcome__text" style="text-align: center;">Forgot your password? <a href="{{ route('request.password.reset') }}">Reset</a></p>--}}
            <button type="submit" class="welcome__button rounded-red-button button w100p">Войти</button>
        </form>

    </div>
</div>

@component('components.footer')
@endcomponent
