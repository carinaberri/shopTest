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

<div class="col-sm-3">
<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Filter By</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <div class="box-body">
    <div class="row">
        
        <form action="/product/search" method="post" role="form">
            
            <div class="form-group">
                <div id="product_filter" class="col-sm-12"  >
                    <label>Search:<input type="text" name="search" class="form-control input-sm" placeholder="" aria-controls="product"></label>
                </div>
            </div>
            

           
           <div class="form-group">
                <div id="product_filter" class="col-sm-12"  >
                
                    <label> Cateogories : </label>
                    @foreach ($categories as $category)
                    <div class="checkbox" >
                        <label> {{$category->name}}
                            {{ Form::checkbox("categories[]",$category->id) }}                
                        </label> 
                    </div>
                    @endforeach
                
                </div>
            </div>            
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <div class="form-group">
                <div id="product_filter" class="col-sm-12"  >
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
        </div>
        </div>
</div>
</div>
<div class="col-sm-9">
<div class="box box-info">
	<div class="box-header">
    	<h3 class="box-title"Products</h3>
        <a href="/product/create" class="btn btn-danger">New Product</a>
    </div>
    <div class="box-body">
    	
    		<table id="product" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                <tr role="row">
                	<th style="width: 100px;"></th>
                	<th style="width: 288px;">Name</th>
                	<th style="width: 350px;">Description</th>
                	<th style="width: 312px;">Quantity</th>
                	<th style="width: 248px;">Price</th>
                	<th style="width: 184px;">Action</th>
                </tr>
                </thead>
                <tbody>
    @foreach($products as $product)         
                <tr role="row" class="odd">
                  <td >@isset($product->img[0]) <img src="{{ Storage::url($product->img[0])}}"/> @endisset</td>
                  <td class="sorting_1"><a href="/product/{{ $product->id }}/edit">{{ $product->name }}</a></td>
                  <td>{{ $product->description}}</td>
                  <td>{{ $product->quantity}}</td>
                  <td>{{ $product->price}}</td>
                  <td> 
                  	<a href="/product/{{ $product->id }}/edit">Edit</a>
			        <form action="/product/{{ $product->id }}" method="POST">
			            <input type="hidden" name="_method" value="delete">
			            <input type="hidden" name="_token" value="{{ csrf_token() }}">
			            <input type="submit" name="name" value="Delete">
			        </form>
			       </td>
                </tr>
    @endforeach
    		</tbody>
	      </table>
	    <div class="form-group">
            <div id="product_filter" class="col-sm-12"  >
                {{ $product_model->links() }}
            </div>
        </div>
	</div>

</div>
</div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/plugins/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/css/product.css">
@stop

@section('js')
   <script src="/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
   <script src="/vendor/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
@stop


@push('scripts')

@endpush