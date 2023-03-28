@extends('admin.layout.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category Create</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
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
                    <div class="card">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="content-tab" data-toggle="tab" href="#content" role="tab" aria-controls="content" aria-selected="false">Content</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Product Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock" placeholder="100">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Product Price</label>
                                            <input type="number" class="form-control" id="price" name="price" placeholder="100000">
                                        </div>
                                        <div class="form-group">
                                            <label for="sale_price">Product Sale Price</label>
                                            <input type="number" class="form-control" id="sale_price" name="sale_price" placeholder="100000">
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control select2" style="width: 100%;" name="category_id">
                                                <option>-----</option>
                                                @foreach($childrenCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                                            <label class="form-check-label" for="is_active">Is Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_hot" class="form-check-input" id="is_hot">
                                            <label class="form-check-label" for="is_hot">Is Hot</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                                            <label class="form-check-label" for="is_featured">Is Featured</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="thumbnail">Example file input</label>
                                            <input type="file" name="thumbnail" class="form-control-file" id="thumbnail">
                                        </div>
                                        <div class="form-group">
                                            <label for="product_images">Example file input</label>
                                            <input type="file" name="images[]" class="form-control-file" id="product_images" multiple>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="content" role="tabpanel" aria-labelledby="content-tab">
                                        <div class="form-group">
                                            <label for="description">Short Description</label>
                                            <textarea name="description" class="form-control tinymce" id="description" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Product Content</label>
                                            <textarea name="content" class="form-control tinymce" id="content" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary">Save Product</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <a class="btn btn-warning" href="{{ route('categories.index') }}">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('custom-js')
    <script>
        $('.select2').select2();
    </script>
@endpush
