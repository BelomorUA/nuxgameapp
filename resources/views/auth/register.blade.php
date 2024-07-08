@extends('layouts.app')

@section('content')
    <div class="register-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required>
            </div>
            <div>
                <label for="phonenumber">Phone Number</label>
                <input id="phonenumber" type="text" name="phonenumber" value="{{ old('phonenumber') }}" required>
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
@endsection
