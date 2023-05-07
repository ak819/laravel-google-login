@extends('auth.app')
@section('content')
<div class="form login">
    <div class="form-content">
        <header>Login</header>

        @if ($message = Session::get('success'))
        <span class="text-success"><strong>{{ $message }}</strong></span>
        @endif
        <form action="{{ route('login.perform') }}" method="post">
            @csrf
            <div class="field input-field">
                <input type="email" placeholder="Email" name="email" class="input" value="{{old('name')}}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                 @enderror
            </div>

            <div class="field input-field">
                <input type="password" placeholder="Password" name="password" class="password">
                <i class='bx bx-hide eye-icon'></i>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                 @enderror
            </div>

            @if ($message = Session::get('error'))
            <span class="text-danger"><strong>{{ $message }}</strong></span>  
            @endif

            <div class="field button-field">
                <button type="submit">Login</button>
            </div>
        </form>
        
        <div class="form-link">
            <span>Don't have an account? <a href="{{ route('register.show') }}" class="link signup-link">Signup</a></span>
        </div>
    </div>

    <div class="line"></div>

    <div class="media-options">
        <a href="{{ route('auth.google') }}" class="field google">
            <img src="{{asset('assets/images/google.png')}}" alt="" class="google-img">
            <span>Login with Google</span>
        </a>
    </div>

</div>

@endsection()