@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container">
        <h2 class="title  pt-4 text-center" style="margin-top:10rem;">
            Welcome to Jareer
        </h2>
        @auth
        <div class="main text-center">
            <a href="{{ url('/home') }}" >Go to dashboard</a>


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