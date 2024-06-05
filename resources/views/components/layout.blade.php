<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title }}</title>
    <style>
        h1 {
            font-size: 2.5rem;
            line-height: 3.75rem;
            text-align: center;
        }

        p {
            line-height: 1.5rem;
            margin: 1.5rem 0;
            font-size: 1rem;
        }

        button {
            display: block;
            width: 12rem;
            height: 2.5rem;
            margin: 0 auto;
            padding: 0;
            border: 0;
            border-radius: 0.625rem;
            background-color: #E31221;
            text-align: center;
            color: white;
        }

        a {
            display: inline-block;
            width: 100%;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            line-height: 2.5rem;
        }

        a, a:visited, a:hover, a:active {
            color: inherit;
        }

        #main {
            height: 100vh;
            background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%);
        }

        #container {
            width: 30rem;
            margin: 0 auto;
            padding: 2.5rem 0;
        }

        #image-container {
            width: 4.5rem;
            height: 2.75rem;
            margin: 0 auto;
        }
    </style>
</head>
<div id="main">
    <div id="container">
        <div id="image-container">
            <img src="{{ asset('logo.png') }}" alt="Movie Quotes Logo"/>
        </div>

        <h1>{{ $subject }}</h1>

        <p>Hi {{ $recipient }},</p>

        <p>
            You're almost there! This link will expire in {{ $expiration }}.
            <br>
            {{ $description }}
        </p>

        <button>
            <a href="{{ $url }}" target="_blank">
                {{ $action }}
            </a>
        </button>

        <p>If you did not request password reset, no further action is required.</p>

        <p>
            Regards,
            <br>
            {{ config('app.name') }}
        </p>
    </div>
</div>
</html>
