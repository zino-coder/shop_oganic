@extends('admin.layout.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product list</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                                <form action="{{ route('products.index') }}" method="get" id="form-filter">
                                    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>

                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item">
                                                    <select class="form-control select2 product-filter" name="cat_filter" style="width: 100%;" name="category">
                                                        <option value="0">Category</option>
                                                        @foreach($childrenCat as $cat)
                                                            <option value="{{ $cat->id }}" {{ $catSelected == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </li>
                                            </ul>
                                            <div class="form-inline my-2 my-lg-0">
                                                <input class="form-control mr-sm-2" type="search" name="text_search" value="{{ $textSearch ?? '' }}" placeholder="Search" aria-label="Search">
                                                <select class="form-control product-filter" name="sort_key">
                                                    <option value="0">Sort By</option>
                                                    @foreach($sortType as $key => $sort)
                                                        <option value="{{ $key }}" {{ $key == $sortKey ? 'selected' : '' }}>{{ $sort }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </nav>
                                </form>
                            @if(!$products->isEmpty())
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">Status</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Thumbnail</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Category</th>
                                        <th>Hot</th>
                                        <td>Featured</td>
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td><input type="checkbox" class="toggle-active" data-url="{{ route('products.update', $product->id) }}" name="is_active" {{ $product->is_active ? 'checked' : '' }}></td>
                                            <td><a href="{{ route('categories.show', $product->id) }}">{{ $product->name }}</a></td>
                                            <td>{{ $product->slug }}</td>
                                            <td>
                                                @if($product->thumbnail)
                                                    <img class="product-image-thumb" src="{{ asset('storage/thumbnail/' . $product->thumbnail->name) }}">
                                                @else
                                                    <img class="product-image-thumb" src="{{ asset('img/default/product-placeholder.webp') }}">
                                                @endif
                                            </td>
                                            <td>{{number_format($product->price) }}</td>
                                            <td>{{ number_format($product->stock) }}</td>
                                            <td>{{ $product->category->name ?? '' }}</td>
                                            <td><input type="checkbox" class="toggle-active" data-url="{{ route('products.update', $product->id) }}" name="is_hot" {{ $product->is_hot ? 'checked' : '' }}></td>
                                            <td><input type="checkbox" class="toggle-active" data-url="{{ route('products.update', $product->id) }}" name="is_featured" {{ $product->is_featured ? 'checked' : '' }}></td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="btn btn-outline-danger delete-button" data-title="{{ $product->name }}" data-link="{{ route('products.destroy',$product->id) }}" data-toggle="modal" data-target="#deleteForm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>No data found</h6>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix d-flex justify-content-end">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <!-- Modal delete -->
    <div class="modal fade" id="deleteForm" tabindex="-1" aria-labelledby="deleteFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="delete-form" method="post">
                    @method('delete')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteFormLabel">Delete Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete category: <b class="text-danger" id="title"></b>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-danger">Yes</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')
    <script>
        $('.select2').select2();
        $(document).ready(function () {
            $('.delete-button').on('click', (e) => {
                const title = $(e.target).data('title')
                const link = $(e.target).data('link')
                console.log(link)

                $('#title').html(title)
                $('#delete-form').attr('action', link)
            })
            $('.toggle-active').on('click', function () {
                const url = $(this).data('url');
                console.log($(this).is(':checked'));
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: $(this).is(':checked') ? 1 : 0,
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        toastr.success(data.success)
                    }
                });
            })
        })
        $('.product-filter').on('change', function () {
            $('#form-filter').trigger('submit');
        })
    </script>
@endpush
