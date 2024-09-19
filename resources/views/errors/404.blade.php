{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<style>
    .error-page {
        text-align: center;
        padding: 50px;
        font-family: 'Arial', sans-serif;
    }

    .error-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .error-title {
        font-size: 72px;
        font-weight: bold;
        color: #333;
    }

    .error-message {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .error-details p {
        color: #555;
    }

    .error-link {
        display: inline-block;
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .error-link:hover {
        background-color: #0056b3;
    }

    .error-character {
        /* Add styles for your character illustration */
    }
    </style>
<div class="error-page">
    <div class="error-content">
        <h1 class="error-title">404</h1>

        <div class="error-details">
            @if(isset($message))
                {{-- <p></p> --}}
                <p class="error-message">{{ $message }}</p>
            @else
            <p>The requested resource was not found on this server.</p>
            @endif
            {{-- <a href="{{ url('/home') }}" class="error-link">Go to Homepage</a> --}}
        </div>
        <div class="error-character">
            <!-- Your character illustration would go here -->
        </div>
    </div>
</div>
@endsection

