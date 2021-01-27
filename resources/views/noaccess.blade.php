@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container">
        <h2 class="title  pt-4 text-center" style="margin-top:10rem;">
            Welcome to Jareer
        </h2>
        @auth
        <div class="main text-center">

            <h3>You dont have access for this! Contact administrator</h3>

            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @endauth

    </div>

</div>

@endsection