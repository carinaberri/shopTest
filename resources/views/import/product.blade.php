@extends('adminlte::page')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
		            <div class="box-header with-border">
		              <h3 class="box-title">Import Product</h3>
		              </div>

		<form class="" action="/import/product" method="POST"  enctype="multipart/form-data">
			 <div class="box-body">
		        
			<div class="form-group">
				<label for="fileProduct">File input</label>
				<input type="file" name="file_product" id="fileProduct">
				 {{ ($errors->has('file_product')) ? $errors->first('file_product') : '' }}<br>
	        </div>
		       
		    <input type="hidden" name="_token" value="{{ csrf_token() }}">
		    <input type="submit" name="action" value="Salvar">
		    </div>
		</form>
		</div>
	</div>
</div>
@endsection