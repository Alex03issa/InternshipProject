<link href="css/signup.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />


<form class="signup" action="{{ route('login.submit') }}" method="POST" autocomplete="off">
  @csrf
  <h1>Sign In</h1>

  <!-- Display error messages -->
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="signup__field">
    <input class="signup__input" type="email" name="email" id="email" required />
    <label class="signup__label" for="email">Email</label>
  </div>

  <div class="signup__field">
    <input class="signup__input" type="password" name="password" id="password" required />
    <label class="signup__label" for="password">Password</label>
  </div>

  <button type="submit">Sign in</button>

  <!-- Google Sign-In Button -->
  <a href="{{ route('google.login') }}" class="btn-google">
    <i class="fab fa-google"></i> Continue with Google
  </a>
</form>
