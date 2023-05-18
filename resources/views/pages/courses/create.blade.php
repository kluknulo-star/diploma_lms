@component('components.header')
@endcomponent

@component('components.aside')
@endcomponent


<div class="container">
    <div class="create">
        <div class="create__container classic-box mrauto">
            <div class="create__title h2 mb30">Создать курс</div>
            <form method="post" action="{{ route('courses.store') }}" class="create__form form">
                @csrf
                @method('post')

                @if ($errors->has('title'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('title') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <input name="title" value="{{ old('title') }}" type="text" placeholder="Название" class="create__input col-input input" required>

                @if ($errors->has('description'))
                    <div class="alert alert-danger">
                        <ul>@foreach($errors->get('description') as $message)<li>{{$message}}</li>@endforeach</ul>
                    </div>
                @endif
                <textarea name="description" placeholder="Описание" class="create__input col-input input">{{ old('description') }}</textarea>
                <button type="submit" class="create__button rounded-red-button button">Создать</button>
            </form>

        </div>
    </div>
</div>
@component('components.footer')
@endcomponent
