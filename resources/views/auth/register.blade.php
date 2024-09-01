<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>


<form action="{{ route('register') }}" method="POST">
  @csrf
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="Name"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror


    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
    @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <label for="password-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" class="form-control"  name="password_confirmation">
    <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button class="btn btn-primary" type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="#">Sign in</a>.</p>
  </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
