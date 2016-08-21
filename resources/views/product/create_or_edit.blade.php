@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            @if (is_null($product))
                <div class="panel-heading">New product</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('product.store') }}">
            @else
                <div class="panel-heading">Edit product</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('product.update', ['id' => $product->id]) }}">
                        {{ method_field('PUT') }}
            @endif
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ is_null($product) ? old('name') : $product->name }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('SKU') ? ' has-error' : '' }}">
                            <label for="SKU" class="col-md-4 control-label">SKU (unique)</label>
                            <div class="col-md-6">
                                <input id="SKU" type="text" class="form-control" name="SKU" value="{{ is_null($product) ? old('SKU') : $product->SKU }}" required>
                                @if ($errors->has('SKU'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('SKU') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" required>{{ is_null($product) ? old('description') : $product->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Price</label>
                            <div class="col-md-6">
                                <input id="price" type="number" min="0" max="9999999" class="form-control" name="price" value="{{ is_null($product) ? old('price') : $product->price }}" required>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('stock') ? ' has-error' : '' }}">
                            <label for="stock" class="col-md-4 control-label">Stock</label>
                            <div class="col-md-6">
                                <input id="stock" type="number" min="0" max="9999999" class="form-control" name="stock" value="{{ is_null($product) ? old('stock') : $product->stock }}" required>
                                @if ($errors->has('stock'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stock') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="date" class="col-md-4 control-label">Date</label>
                            <div class="col-md-6">
                                <input id="date" type="date" min="0" max="9999999" class="form-control" name="date" value="{{ is_null($product) ? old('date') : $product->date }}" required>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label">Image URL (optional)</label>
                            <div class="col-md-6">
                                <input id="image" type="url" class="form-control" name="image" value="{{ is_null($product) ? old('image') : $product->image }}">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('meal_course_type') ? ' has-error' : '' }}">
                            <label for="meal_course_type" class="col-md-4 control-label">Meal course type</label>
                            <div class="col-md-6">
                                <select id="meal_course_type" type="url" class="form-control" name="meal_course_type">
                                    @foreach ($meal_course_type_options as $type => $representation)
                                        @if (is_null($product) ? old('meal_course_type') : $product->meal_course_type == $type)
                                            <option value="{{ $type }}" selected>{{ $representation }}</option>
                                        @else
                                            <option value="{{ $type }}">{{ $representation }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('meal_course_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('meal_course_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('serving_time') ? ' has-error' : '' }}">
                            <label for="serving_time" class="col-md-4 control-label">Serving time</label>
                            <div class="col-md-6">
                                <select id="serving_time" type="url" class="form-control" name="serving_time">
                                    @foreach ($serving_time_options as $type => $representation)
                                        @if (is_null($product) ? old('serving_time') : $product->serving_time == $type)
                                            <option value="{{ $type }}" selected>{{ $representation }}</option>
                                        @else
                                            <option value="{{ $type }}">{{ $representation }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('serving_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serving_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
