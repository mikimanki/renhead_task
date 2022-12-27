@extends('welcome')

@section('content')
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label for="first_name">First Name</label>
        <input type="text" name="first_name">
        <br>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name">
        <br>
        <label for="email">Email</label>
        <input type="text" name="email">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password">
        <br>
        <label for="type">Type</label>
        <select name="type" id="type">
            <option value="APPROVER">APPROVER</option>
            <option value="NONAPPROVER">NONAPPROVER</option>
        </select>
        <br>
        <button type="submit">Submit</button>
    </form>
@endsection
