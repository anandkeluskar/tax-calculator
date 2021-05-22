@extends('layouts.app')

@section('content')

<div class="container">
    <center><h3 class="display-6">Dashboard</h3></center>

    @if (session()->has('status'))
        <h4 class="text-danger">{{ session('status') }}</h4>
    @endif

    @if(count($payer_requests))
        <table class="table">
            <tr>
                <th scope="col">Sr. No.</th>
                <th scope="col">Request Reference No.</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>

            <?php $i=0; ?>
            @foreach($payer_requests as $req)
                <tr>
                    <th scope="row">{{ ++$i }}</th>
                    <td>#{{ $req->reference_no }}</td>
                    <td>{{ $req->created_at }}</td>
                    <td><a href="/dashboard/request/{{ $req->reference_no }}" class="btn btn-primary btn-md">View</a></td>
                </tr>
            @endforeach
            
        </table>
    @else
        <div>You haven't done any tax calculations.</div>
        <a href="{{ route('calculate-tax') }}" class="btn btn-primary btn-md">Start Calculating</a>
    @endif
</div>

@endsection