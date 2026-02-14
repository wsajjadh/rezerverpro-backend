<h1>Welcome, {{ $user->name }}!</h1>
<p>Your verification code is:</p>
<h2 style="font-size: 32px; letter-spacing: 5px;">{{ $user->verification_code }}</h2>
<p>This code will expire in 15 minutes.</p>