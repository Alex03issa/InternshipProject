<link href="css/signup.css" rel="stylesheet" />

<form class="signup" action="{{ route('signup.submit') }}" method="POST" autocomplete="off">
  @csrf
  <h1>Create account</h1>
  <h2>Already have an account? <a href="{{ route('login') }}">Sign in</a></h2>

  <div class="signup__field">
    <input class="signup__input" type="text" name="username" id="username" required />
    <label class="signup__label" for="username">Username</label>
  </div>

  <div class="signup__field">
    <input class="signup__input" type="text" name="email" id="email" required />
    <label class="signup__label" for="email">Email</label>
  </div>

  <div class="signup__field">
    <input class="signup__input" type="password" name="password" id="password" required />
    <label class="signup__label" for="password">Password</label>
  </div>

  <button type="submit">Sign up</button>
</form>
