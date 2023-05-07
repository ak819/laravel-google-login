@extends('auth.app')
@section('content')
@section('formclass'){{ "show-signup" }} @endsection
<div class="form signup">
    <div class="form-content">
        <header>Signup</header>
        <form action="{{ route('register.perform') }}" method="post">
            @csrf

            <div class="field input-field">
                <input type="text" name="name" placeholder="Name" class="input"  value="{{old('name')}}">
                 @error('name')
                <span class="text-danger">{{ $message }}</span>
                 @enderror
            </div>

            <div class="field input-field">
                <input type="email" name="email" placeholder="Email" class="input"  value="{{old('email')}}">
                 @error('email')
                <span class="text-danger">{{ $message }}</span>
                 @enderror
            </div>

            <div class="field input-field">
                <input type="password" name="password" placeholder="Create password" class="password">
                
            </div>

            <div class="field input-field">
                <input type="password" name="password_confirmation" placeholder="Confirm password" class="password">
                <i class='bx bx-hide eye-icon'></i>
            </div>
            @error('password')
            <span class="text-danger">{{ $message }}</span>
             @enderror

            @if ($message = Session::get('error'))
                <span class="text-danger"><strong>{{ $message }}</strong></span>  
            @endif

            <div class="field button-field">
                <button type="submit">Signup</button>
            </div>
        </form>

        <div class="form-link">
            <span>Already have an account? <a href="{{ route('login.show') }}" class="link login-link">Login</a></span>
        </div>
    </div>

    <div class="line"></div>

    <div class="media-options">
        <a href="#" class="field google">
            <img src="{{asset('assets/images/google.png')}}" alt="" class="google-img">
            <span>Login with Google</span>
        </a>
    </div>

</div>



@endsection()