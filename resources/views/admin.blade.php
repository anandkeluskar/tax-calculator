@extends('layouts.app')

@section('content')

<center><h3 class="display-6">Admin Panel</h3></center>

<section id="tabs" class="project-tab">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General Inputs</a>
                        <a class="nav-item nav-link" id="nav-income-tab" data-toggle="tab" href="#nav-income" role="tab" aria-controls="nav-income" aria-selected="false">Income Inputs</a>
                        <a class="nav-item nav-link" id="nav-deduction-tab" data-toggle="tab" href="#nav-deduction" role="tab" aria-controls="nav-deduction" aria-selected="false">Deduction Inputs</a>
                        <a class="nav-item nav-link" id="nav-slabs-tab" data-toggle="tab" href="#nav-slabs" role="tab" aria-controls="nav-slabs" aria-selected="false">Tax Slabs</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                        <div class="jumbotron">
                            <form method="post" action="{{ route('admin_add_params') }}">
                                <div class="form-group mt-3">
                                    @csrf
                                    <input type="hidden" name="param_type" value="general">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="general_param_name">Add Parameter</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="general_param_name" placeholder="Enter parameter name" class="form-control" value="{{ old('deduction_param_name') }}">
                                            @error('general_param_name')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-md" type="submit">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
    
                            <div class="form-group mt-3">
                                <div class="font-weight-bold">Parameters</div>
                                @foreach($parameters as $param)
                                    @if($param->type == 'general')
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label>{{ $param->param_name }}
                                                    @if($parameter_options->count())
                                                        <br><small>Already Added: 
                                                        @foreach($parameter_options as $option)
                                                            @if($option->param_id == $param->id)
                                                                {{ $option->option_value }},
                                                            @endif
                                                        @endforeach
                                                        </small>
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="param_{{ $param->id }}" placeholder="Enter value">
                                            </div>
                                            <div class="col-md-2">
                                                <button param_id="{{ $param->id }}" class="btn btn-primary btn-md btn-general-param-value">Add Value</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                        <div class="jumbotron">
                            <form method="post" action="{{ route('admin_add_params') }}">
                                <div class="form-group mt-3">
                                    @csrf
                                    <input type="hidden" name="param_type" value="income">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="income_param_name">Add Parameter</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="income_param_name" placeholder="Enter parameter name" class="form-control" value="{{ old('income_param_name') }}">
                                            @error('income_param_name')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-md" type="submit">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="form-group mt-3">
                                <div class="font-weight-bold">Parameters</div>
                                @foreach($parameters as $param)
                                    @if($param->type == 'income')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="edit_income_param_name" id="param_name_{{ $param->id }}" placeholder="Enter parameter name" class="form-control mt-3" value="{{ $param->param_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <button param_id="{{ $param->id }}" class="btn btn-primary btn-md mt-3 btn-update-income-param">Update</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-deduction" role="tabpanel" aria-labelledby="nav-deduction-tab">
                        <div class="jumbotron">
                            <form method="post" action="{{ route('admin_add_params') }}">
                                <div class="form-group mt-3">
                                    @csrf
                                    <input type="hidden" name="param_type" value="deduction">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="deduction_param_name">Add Parameter</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="deduction_param_name" placeholder="Enter parameter name" class="form-control mt-3" value="{{ old('deduction_param_name') }}">
                                            @error('deduction_param_name')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="max_deduction_amount" placeholder="Enter maximum deduction amount" class="form-control mt-3" value="{{ old('max_deduction_amount') }}">
                                            @error('max_deduction_amount')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-md mt-3" type="submit">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="form-group mt-3">
                                <div class="font-weight-bold">Parameters</div>
                                @foreach($parameters as $param)
                                    @if($param->type == 'deduction')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="edit_deduction_param_name" id="param_name_{{ $param->id }}" placeholder="Enter parameter name" class="form-control mt-3" value="{{ $param->param_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="max_deduction_amount"  id="deduct_amt_{{ $param->id }}" placeholder="Enter maximum deduction amount" class="form-control mt-3" value="{{ $param->max_deduct_amt }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button param_id="{{ $param->id }}" class="btn btn-primary btn-md mt-3 btn-update-deduct-param">Update</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-slabs" role="tabpanel" aria-labelledby="nav-slabs-tab">
                        <div class="jumbotron">
                            <form method="post" action="{{ route('admin_add_tax_slabs') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="min_amount">Minimum Amount</label>
                                            <input type="number" name="min_amount" placeholder="Enter minimum amount" class="form-control" value="{{ old('min_amount') }}">
                                            @error('min_amount')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="max_amount">Maximum Amount</label>
                                            <input type="number" name="max_amount" placeholder="Enter maximum amount" class="form-control" value="{{ old('max_amount') }}">
                                            @error('max_amount')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tax_percent">Tax Percent</label>
                                            <input type="number" name="tax_percent" placeholder="Enter tax percent" class="form-control" value="{{ old('tax_percent') }}">
                                            @error('tax_percent')
                                                <span class="form-text text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary btn-sx mt-3 w-50 pull-right" type="submit">Add Tax Slab</button>
                                </div>
                            </form>

                            <div class="form-group mt-3">
                                @if($tax_slabs->count())
                                    <div class="font-weight-bold">Slabs</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="font-weight-bold">Min Amount</span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="font-weight-bold">Max Amount</span>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="font-weight-bold">Tax Percent</span>
                                        </div>
                                        <div class="col-md-2">
                                            Action
                                        </div>
                                    </div>
                                    @foreach($tax_slabs as $slab)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="number" name="edit_slab_min_amount" id="slab_min_{{ $slab->id }}" placeholder="Enter minimum amount" class="form-control mt-3" value="{{ $slab->min_amount }}">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="edit_slab_max_amount" id="slab_max_{{ $slab->id }}" placeholder="Enter maximum amount" class="form-control mt-3" value="{{ $slab->max_amount }}">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="edit_slab_tax_percent" id="slab_percent_{{ $slab->id }}" placeholder="Enter tax percent" class="form-control mt-3" value="{{ $slab->tax_percent }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button slab_id="{{ $slab->id }}" class="btn btn-primary btn-md mt-3 btn-update-tax-slab">Update</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection