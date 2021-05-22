@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="display-6">Income Tax Details (#{{ $ref_no }})</h3>

    @if(count($tax_details))
        @foreach($tax_details as $detail)
            <div class="row mt-3">
                <div class="col-md-6">
                    {{ $detail->parameter }}
                </div>
                <div class="col-md-6">
                    {{ $detail->value }}
                </div>
            </div>
        @endforeach

        <div class="row mt-3">
            <center><a href="{{ route('dashboard') }}" class="btn btn-primary btn-md">Back</a></center>
        </div>
    @else
        <h6>No Tax Details Available</h6>
    @endif
</div>
@endsection