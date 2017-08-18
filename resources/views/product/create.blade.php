@extends('adminlte::page')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
		            <div class="box-header with-border">
		              <h3 class="box-title">New Product</h3>
		              </div>

		<form class="" action="/product" method="POST"  enctype="multipart/form-data">
			 <div class="box-body">
		        <div class="form-group">
		        	<label for="name">Name</label>
				    <input type="text" name="name" id="name" value="" placeholder="Product X" class="form-control">
				    {{ ($errors->has('name')) ? $errors->first('name') : '' }}<br>
			    </div>
			    <div class="form-group">
			    	<label for="description">Description</label>
				    <textarea name="description" id="description" rows="8" cols="40" placeholder="An amazing botle water " class="form-control"></textarea>
				    {{ ($errors->has('description')) ? $errors->first('description') : '' }}<br>
				</div>

				<div class="form-group">
					<label for="price">Price</label>
				    <input type="text" id="price" name="price" value="" placeholder="18.22" class="form-control">
				    {{ ($errors->has('price')) ? $errors->first('price') : '' }}<br>
				</div>

				<div class="form-group">
					<label for="quantity">Quantity</label>
				      <input type="text" id="quantity" name="quantity" value="" placeholder="quantity" class="form-control">
				    {{ ($errors->has('quantity')) ? $errors->first('quantity') : '' }}<br>
				</div>

				<div class="form-group">
					<label for="exampleInputFile">File input</label>
					<input type="file" name="file_product" id="exampleInputFile">
		        </div>
		        <div class="form-group">
		        Cateogories : 
		        @foreach ($categories as $category)
				    <label> {{$category["name"]}}
				    	<input type="checkbox" name="categories[]" value="{{$category["id"]}}">
				    </label> 
				@endforeach
				</div>
		        

		    <input type="hidden" name="_token" value="{{ csrf_token() }}">
		    <input type="submit" name="name" value="Salvar">
		    </div>
		</form>
		</div>
	</div>
</div>
@endsection