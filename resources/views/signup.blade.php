@extends('layouts/app')
@section('title', 'Signup')

@section('content')

@if($errors->any())
    @component('components/alert')
        @slot('type') danger @endslot
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endcomponent
@endif

<div class="form__container">
    
    <img class="form__img"  src="{{ url('assets/atria_logo.svg') }}" alt="Logo Atria">
    
<form action="{{ url('/users/signup') }}" method="POST" class="form">
    @csrf
    
    <input value="{{ old('firstname') }}" class="input input--light" type="text" placeholder="Firstname" name="firstname" id="firstname">

    
    <input value="{{ old('lastname') }}" class="input input--light" type="text" placeholder="Lastname" name="lastname" id="lastname">


    <input value="{{ old('email') }}" class="input input--light" type="text" placeholder="Email" name="email" id="email">

    
    <input class="input input--light" type="password" placeholder="Password" name="password" id="password">

    
    <input class="input input--light" type="password" placeholder="Confirm Password" name="password_confirmation" id="confirmPassword">


    <input class="btn--login" type="submit"  value="Signup">

    <a class="form__link" href="/login">Already have an account?</a>

    

</form>
</div>
@endsection