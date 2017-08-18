@extends('adminlte::page')

@section('content')
	{{ Session::get('message') }}


<div class="box">
	<div class="box-header">
    	<h3 class="box-title"Products</h3>
        <a href="/category/create">New</a>
    </div>
    <div class="box-body">
 	<div class="row">
    	<div class="col-sm-6">
    		<div class="dataTables_length" id="product_length">
    			<label>Show 
    				<select name="product_length" aria-controls="product" class="input-sm" style="background-color: #FFF">
    				<option value="10">10</option>
    				<option value="25">25</option>
    				<option value="50">50</option>
    				<option value="100">100</option>
    			</select> entries</label>
    		</div>
    	</div>
    	<div class="col-sm-6">
    		<div id="category_filter" class="dataTables_filter col-sm-6" style="float:right" >
    			<label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="category"></label>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
    		<table id="product" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                <tr role="row">
                	<th  tabindex="0" aria-controls="product" rowspan="1" colspan="1" style="width: 100px;"></th>
                	<th class="sorting_asc" tabindex="0" aria-controls="product" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 288px;">Name</th>
                	<th class="sorting" tabindex="0" aria-controls="product" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 350px;">Description</th>
                	<th  tabindex="0" aria-controls="product" rowspan="1" colspan="1"  style="width: 184px;">Action</th>
                </tr>
                </thead>
                <tbody>
    @foreach($categories as $category)         
                <tr role="row" class="odd">
                  <td >
                  		</td>
                  <td class="sorting_1"><a href="/category/{{ $category->id }}">{{ $category->name }}</a></td>
                  <td class="sorting_1"><a href="/category/{{ $category->id }}">{{ $category->description }}</a></td>
                  
                  <td> 
                  	<a href="/category/{{ $category->id }}/edit">Edit</a>
			        <form action="/category/{{ $category->id }}" method="POST">
			            <input type="hidden" name="_method" value="delete">
			            <input type="hidden" name="_token" value="{{ csrf_token() }}">
			            <input type="submit" name="name" value="Delete">
			        </form>
			       </td>
                </tr>
    @endforeach
    		</tbody>
	      </table>
	    </div>
	</div>
</div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/plugins/datatables/jquery.dataTables.min.css">
@stop

@section('js')
   <script src="/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
   <script src="/vendor/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
@stop


@push('scripts')

@endpush