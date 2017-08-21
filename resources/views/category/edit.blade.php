@extends('adminlte::page')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
		            <div class="box-header with-border">
		              <h3 class="box-title">New Category</h3>
		              </div>

		<form class="" action="/category/{{ $category->id }}" method="POST"  enctype="multipart/form-data">
			 <div class="box-body">
		        <div class="form-group">
		        	<label for="name">Name</label>
				    <input type="text" name="name" id="name" value="{{ $category->name }}" placeholder="Category X" class="form-control">
				    {{ ($errors->has('name')) ? $errors->first('name') : '' }}<br>
			    </div>
			    <div class="form-group">
			    	<label for="description">Description</label>
				    <textarea name="description" id="description" rows="8" cols="40" placeholder="" class="form-control">{{ $category->description }}</textarea>
				    {{ ($errors->has('description')) ? $errors->first('description') : '' }}<br>
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
						    <input type="file" name="file_category"> 
						</span>
					    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
					  </div>
					</div>
		        </div>
		      {{ method_field('PUT') }}  
		       
		    <input type="hidden" name="_token" value="{{ csrf_token() }}">
		    <input type="submit" name="action" value="Salvar">
		    </div>
		</form>
		</div>
	</div>
</div>
@endsection