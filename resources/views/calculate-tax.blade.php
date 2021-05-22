@extends('layouts.app')

@section('content')

<div class="container">
    <center><h3 class="display-6">Income Tax Calculator</h3></center>

    @if (session()->has('status'))
        <h4 class="text-danger">{{ session('status') }}</h4>
    @endif

    <form action="{{ Route('calculate-tax-submit') }}" method="post">
        @csrf

        @if(count($general_parameters))
            <h4 class="display-8 mt-3"><u>General Details</u></h4>
            
            @foreach($general_parameters as $param)
                <div class="form-group mt-3">
                    <div class="row">
                        <?php $param_key = "general_".$param['id']; ?>
                        <div class="col-md-6">
                            <label for="{{ $param_key }}">{{ $param['param_name'] }}</label>
                        </div>
                        <div class="col-md-6">
                            <select name="{{ $param_key }}" class="form-control">
                                @foreach($param['options'] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @error($param_key)
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @if(count($income_parameters))
            <h4 class="display-8 mt-3"><u>Income Details</u></h4>
            
            @foreach($income_parameters as $param)
                <div class="form-group mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="income_{{ $param->id }}">{{ $param->param_name }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="income_{{ $param->id }}" class="form-control" value="0">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @if(count($deduction_parameters))
            <h4 class="display-8 mt-3"><u>Deductions Details</u></h4>
            
            @foreach($deduction_parameters as $param)
                <div class="form-group mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="deduction_{{ $param->id }}">{{ $param->param_name }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="deduction_{{ $param->id }}" class="form-control" value="0">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <button type="submit" class="btn btn-primary mt-3">Calculate Tax</button>
        <button type="reset" class="btn btn-danger mt-3 ml-3">Reset</button>
    </form>
</div>

@endsection