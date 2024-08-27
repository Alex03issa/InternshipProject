<link href="{{ asset('css/password.css') }}" rel="stylesheet" />


<form class="password__form" action="{{ route('password.store') }}" method="POST">
        @csrf
    <div class="password">
        <h1>Create Your Password</h1>
        <h2>You'll need this to log in without Google</h2>

        <div class="password__field">
            <input class="password__input" type="password" name="password" id="password" required />
            <label class="password__label" for="password">Password</label>
        </div>

        <div class="password__field">
            <input class="password__input" type="password" name="password_confirmation" id="password_confirmation" required />
            <label class="password__label" for="password_confirmation">Confirm Password</label>
        </div>

        <button type="submit" class="password__button">Set Password</button>
    </div>
</form>
