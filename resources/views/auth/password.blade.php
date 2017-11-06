<!-- resources/views/auth/password.blade.php -->
<form method="POST" action="/password/email"  style="background-color: #265a88">
    {!! csrf_field() !!}

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <button type="submit">
            Send Password Reset Link
        </button>
    </div>
</form>
