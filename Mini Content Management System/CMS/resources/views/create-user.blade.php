@extends('layouts.primary')
    @section('content')
    
    <form action="/createUser" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Create User</button>
    </form>
    @endsection