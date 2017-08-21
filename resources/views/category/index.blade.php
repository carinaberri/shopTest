@extends('adminlte::page')

@section('content')
@if(null !== Session::get('message') )
<div class="col-sm-12">
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Alert!</h4>
        {{ Session::get('message') }}
    </div>    
</div>
@endif

<div class="col-sm-9">
<div class="box box-info">
	<div class="box-header">
    	<h3 class="box-title"Products</h3>
        <a href="/category/create"  class="btn btn-danger">New</a>
    </div>
    <div class="box-body">
 	
    <div class="row">
    	<div class="col-sm-12">
    		<table id="category" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                <tr role="row">
                	<th  style="width: 100px;"></th>
                	<th  style="width: 288px;">Name</th>
                	<th  style="width: 350px;">Description</th>
                	<th  style="width: 184px;">Action</th>
                </tr>
                </thead>
                <tbody>
    @foreach($categories as $category)         
                <tr role="row" class="odd">
                  <td >@isset($category->img[0]) <img src="{{ Storage::url($category->img[0])}}"/> @endisset</td>
                  <td class="sorting_1"><a href="/product/categories/{{ $category->id }}">{{ $category->name }}</a></td>
                  <td class="sorting_1"><a href="/product/categories/{{ $category->id }}">{{ $category->description }}</a></td>
                  
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
    <div class="row">
    {{ $categories_model->links() }}
    </div>
</div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/plugins/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/css/category.css">
@stop

@section('js')
   <script src="/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
   <script src="/vendor/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
@stop


@push('scripts')

@endpush