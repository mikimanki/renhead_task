@extends('welcome')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="email">Email</label>
        <input type="text" name="email">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password">
        <br>
        <button type="submit">Submit</button>
    </form>
@endsection
