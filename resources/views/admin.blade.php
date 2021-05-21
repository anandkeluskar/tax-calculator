@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="display-4"><u>Admin Panel</u></h2>

    <div class="jumbotron">
        <h4 class="display-6">General Inputs</h4>
        <form method="post" action="{{ route('admin_add_params') }}">
            <div class="form-group mt-3">
                @csrf
                <input type="hidden" name="param_type" value="general">
                <label for="general_param_name">Add Parameter</label>
                <input type="text" name="general_param_name" placeholder="Enter parameter name" class="form-control mt-3" value="{{ old('deduction_param_name') }}">
                @error('general_param_name')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-primary btn-md mt-3" type="submit">Add</button>
        </form>
        
        <div class="form-group mt-3">
            <div class="font-weight-bold">Parameters</div>
            <div class="col-md-8">
                @foreach($parameters as $param)
                    @if($param->type == 'general')
                        <div class="row mt-3">
                            <label>{{ $param->param_name }}
                                @if($parameter_options->count())
                                    ( Already Added: 
                                        @foreach($parameter_options as $option)
                                            @if($option->param_id == $param->id)
                                                {{ $option->option_value }},
                                            @endif
                                        @endforeach
                                    )
                                @endif
                            </label>
                            <input type="text" class="form-control" id="param_{{ $param->id }}" placeholder="Enter value">
                            <button param_id="{{ $param->id }}" class="btn btn-primary btn-md mt-3 btn-general-param-value">Add Value</button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <hr class="my-4">

    <div class="jumbotron">
        <h4 class="display-6">Income Inputs</h4>
        <form method="post" action="{{ route('admin_add_params') }}">
            <div class="form-group mt-3">
                @csrf
                <input type="hidden" name="param_type" value="income">
                <label for="income_param_name">Add Parameter</label>
                <input type="text" name="income_param_name" placeholder="Enter parameter name" class="form-control mt-3" value="{{ old('income_param_name') }}">
                @error('income_param_name')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-primary btn-md mt-3" type="submit">Add</button>
        </form>

        <div class="form-group mt-3">
            <div class="font-weight-bold">Parameters</div>
            <div class="col-md-8">
                @foreach($parameters as $param)
                    @if($param->type == 'income')
                        <div class="row">
                            <label>{{ $param->param_name }}</label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <hr class="my-4">

    <div class="jumbotron">
        <h4 class="display-6">Deduction Inputs</h4>
        <form method="post" action="{{ route('admin_add_params') }}">
            <div class="form-group mt-3">
                @csrf
                <input type="hidden" name="param_type" value="deduction">
                <label for="deduction_param_name">Add Parameter</label>
                <input type="text" name="deduction_param_name" placeholder="Enter parameter name" class="form-control mt-3" value="{{ old('deduction_param_name') }}">
                @error('deduction_param_name')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror

                <input type="number" name="max_deduction_amount" placeholder="Enter maximum deduction amount" class="form-control mt-3" value="{{ old('max_deduction_amount') }}">
                @error('max_deduction_amount')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-primary btn-md mt-3" type="submit">Add</button>
        </form>

        <div class="form-group mt-3">
            <div class="font-weight-bold">Parameters</div>
            <div class="col-md-8">
                @foreach($parameters as $param)
                    @if($param->type == 'deduction')
                        <div class="row">
                            <input type="text" name="edit_deduction_param_name" id="param_name_{{ $param->id }}" placeholder="Enter parameter name" class="form-control mt-3" value="{{ $param->param_name }}">
                            <input type="number" name="max_deduction_amount"  id="deduct_amt_{{ $param->id }}" placeholder="Enter maximum deduction amount" class="form-control mt-3" value="{{ $param->max_deduct_amt }}">
                            <button param_id="{{ $param->id }}" class="btn btn-primary btn-md mt-3 btn-update-deduct-param">Update</button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <hr class="my-4">

    <div class="jumbotron">
        <h4 class="display-6">Tax Slabs</h4>
        <form method="post" action="{{ route('admin_add_tax_slabs') }}">
            @csrf
            <div class="form-group mt-3">
                <label for="min_amount">Minimum Amount</label>
                <input type="number" name="min_amount" placeholder="Enter minimum amount" class="form-control mt-3" value="{{ old('min_amount') }}">
                @error('min_amount')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="max_amount">Maximum Amount</label>
                <input type="number" name="max_amount" placeholder="Enter maximum amount" class="form-control mt-3" value="{{ old('max_amount') }}">
                @error('max_amount')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="tax_percent">Tax Percent</label>
                <input type="number" name="tax_percent" placeholder="Enter tax percent" class="form-control mt-3" value="{{ old('tax_percent') }}">
                @error('tax_percent')
                    <span class="form-text text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="btn btn-primary btn-md mt-3" type="submit">Add Tax Slab</button>
        </form>

        <div class="form-group mt-3">
            <div class="font-weight-bold">Slabs</div>
            <div class="col-md-8">
                @foreach($tax_slabs as $slab)
                    <div class="row">
                        <span>{{ $slab->min_amount }} to {{ $slab->max_amount }} : {{ $slab->tax_percent }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection