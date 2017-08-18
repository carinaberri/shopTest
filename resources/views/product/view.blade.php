
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

</div>