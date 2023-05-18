@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent

<div class="container">
    <div class="edit">
        <div class="edit__container classic-box mrauto">
            <div class="edit__title h2 mb30">Обновление аватарки</div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form enctype="multipart/form-data" method="post" action="{{ route('users.update.avatar', ['id' => $user->user_id]) }}" class="edit__form form">
                @csrf
                @method('patch')

                <input class="imageuploader" type="file" name="avatar" id="avatar" accept=".jpg, .jpeg, .png" placeholder="Загрузить фото">
                <button type="submit" class="edit__button rounded-red-button button mb20">Сохранить</button>
            </form>
            <a href="{{ url()->previous() }}" class="back-button"><i class="fas fa-arrow-left"></i> Вернуться</a>
        </div>
    </div>
</div>

@component('components.footer')
@endcomponent
