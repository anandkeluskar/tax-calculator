@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Income Tax Calculator</h3>

    <form action="{{ Route('calculate-tax-submit') }}" method="post">
        @csrf

        
    </form>
</div>

@endsection