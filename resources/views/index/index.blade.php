@extends('layouts.baseIndex')

@section('content')
    <main class="containerMain">
        <div class="panel">
            @if (!isset($user))
                <form method="post" method="POST" action="{{ route('login') }}" accept-charset="utf-8">
                    @csrf
                    <label class="conf-step__label" for="mail">
                        <h4>{{ __('Введите e-mail клиента') }}</h4>
                        <input id="email" type="email" class="conf-step__input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                    <label for="password" type="password" class="conf-step__label">
                        <h4>{{ __('Введите пароль клиента') }}</h4>
                        <input id="password" type="password"
                            class="conf-step__input @error('password') is-invalid @enderror" placeholder="" name="password"
                            required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                    <div class="conf-step__buttons">
                        <input type="submit" value="Войти"
                            class="conf-step__button-accent
                       conf-step__button"
                            data-bs-dismiss="modal">

                    </div>
                </form>
            @else
                <div class="conf-step__label">
                    <h4>Активный клиент</h4>
                    <h4 class="active_client">{{ $user->name }}<h4>
                            <h4> Баланс клиента {{ $user->balance }} руб.<h4>
                                    <div>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                            {{ __('Выйти') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </div>
                </div>
                <form action="{{ route('transfer') }}" method="POST" accept-charset="utf-8">
                    @csrf
                    <label class="conf-step__label for="name">
                        <h4>Введите ID клиента для перевода</h4>
                        <input class="conf-step__input" type="text" name="id" value="{{ old('id') }}">
                    </label>
                    @error('id')
                        <div class="errors">{{ $message }}</div>
                    @enderror
                    <label class="conf-step__label for="sum">
                        <h4>Введите сумму для перевода, руб.</h4>
                        <input class="conf-step__input" type="text" name="sum" value="{{ old('sum') }}">
                    </label>
                    @error('sum')
                        <div class="errors">{{ $message }}</div>
                    @enderror
                    <label class="conf-step__label for="date">
                        <h4>Введите дату, когда нужно произвести платеж</h4>
                        <input class="conf-step__input" type="datetime-local" name="date" value="{{ old('date') }}">
                    </label>
                    @error('date')
                        <div class="errors">{{ $message }}</div>
                    @enderror
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value='OK'
                            class="conf-step__button-accent
                                   conf-step__button">
                    </div>
                </form>
            @endif
        </div>
        <div class="table">
            <div class="header_table">
                <div class="info_transfer">
                    <div class="name_transfer">Инф. о последнем переводе</div>
                    <div class="info">
                        <div class="item_info">Клиент</div>
                        <div class="sum item_info">Сумма</div>
                        <div class="recipient item_info">Получатель</div>
                        <div class="date item_info">Дата и время поступления денежных средств</div>
                        <div class="item_info client-id">Id клиента</div>
                    </div>
                    @foreach ($users as $user)
                        @if (isset($user->transfers->last()->name_recipient))
                            <div class="info">
                                <div class="client_name item">{{ $user->name }}</div>
                                <div class="sum item">{{ $user->transfers->last()->summa }}</div>
                                <div class="recipient item">{{ $user->transfers->last()->name_recipient }}</div>
                                <div class="date item">{{ $user->transfers->last()->date_transfer }}</div>
                                <div class="id item">{{ $user->id }}</div>
                            </div>
                        @else
                            <div class="info">
                                <div class="client_name item">{{ $user->name }}</div>
                                <div class="sum item">-</div>
                                <div class="recipient item">-</div>
                                <div class="date item">-</div>
                                <div class="id item">{{ $user->id }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection()
