@extends('adminlte::page')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
		            <div class="box-header with-border">
		              <h3 class="box-title">New Product</h3>
		              </div>

		<form class="" action="/product/{{ $product->id }}" method="POST"  enctype="multipart/form-data">
			 <div class="box-body">
		        <div class="form-group">
		        	<label for="name">Name</label>
				    <input type="text" name="name" id="name" value="{{ $product->name }}" placeholder="Product X" class="form-control" >
				    {{ ($errors->has('name')) ? $errors->first('name') : '' }}<br>
			    </div>
			    <div class="form-group">
			    	<label for="description">Description</label>
				    <textarea name="description" id="description" rows="8" cols="40" placeholder="An amazing botle water " class="form-control">
				    	{{ $product->description }}
				    </textarea>
				    {{ ($errors->has('description')) ? $errors->first('description') : '' }}<br>
				</div>

				<div class="form-group">
					<label for="price">Price</label>
				    <input type="text" id="price" name="price" value="{{ $product->price }}" placeholder="18.22" class="form-control">
				    {{ ($errors->has('price')) ? $errors->first('price') : '' }}<br>
				</div>

				<div class="form-group">
					<label for="quantity">Quantity</label>
				      <input type="text" id="quantity" name="quantity" value="{{ $product->quantity }}" placeholder="quantity" class="form-control">
				    {{ ($errors->has('quantity')) ? $errors->first('quantity') : '' }}<br>
				</div>

				<div class="form-group">
					<div class="fileinput fileinput-new" data-provides="fileinput">
					  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
					  	 @foreach($files as $file)
				        <img src="{{ Storage::url($file)}}"/>
				        @endforeach
					  </div>
					  <div>
					    <span class="btn btn-default btn-file">
						    <span class="fileinput-new">Select image</span>
						    <span class="fileinput-exists">Change</span>
						    <input type="file" name="file_product"> 
						</span>
					    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
					  </div>
					  {{ ($errors->has('file_product')) ? $errors->first('file_product') : '' }}<br>
					</div>
		        </div>
		        <div class="form-group">
		        Cateogories : 
		       
		        @foreach ($categories as $category)
				    <label> {{$category->name}}
				    </label> 
				    	{{ Form::checkbox("categories[]", $category->id,in_array($category->id, $categories_product)) }}		    
				@endforeach
				</div>

		    <input type="hidden" name="_token" value="{{ csrf_token() }}">
		    {{ method_field('PUT') }}
		    <input type="submit" name="action" value="Salvar">
		    </div>
		</form>
		</div>
	</div>
</div>
@endsection

@section('js')
   <script src="/js/jasny-bootstrap.min.js"></script>
@stop


@section('css')
    <link rel="stylesheet" href="/css/jasny-bootstrap.min.css">
@stop
