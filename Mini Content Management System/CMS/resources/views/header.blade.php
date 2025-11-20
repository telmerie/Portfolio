<header>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</header>

<div class="container">
    @auth
    <div class="navigation">
        <a href="{{ route('home') }}">Articles</a>
        <a href="{{ route('create.user') }}">Create User</a>
        <a href="{{ route('create.article') }}">Create Article</a>
    </div>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @else 

    <div class="navigation">
        <a href="{{ route('home') }}">Articles</a>
        <a href="{{ route('create.user') }}">Create User</a>
    </div>
    
    <form action="/login" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    @endauth
</div>



