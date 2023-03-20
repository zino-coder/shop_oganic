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
                            <form action="{{ route('categories.store') }}" method="post">
                                @csrf
                                <div class="card-header">
                                    <h3 class="card-title">Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Category Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Parent Category</label>
                                        <select class="form-control select2" style="width: 100%;" name="parent_id">
                                            <option value="0">-----</option>
                                            @foreach($parentCategory as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active">
                                        <label class="form-check-label" for="is_active">Is Active Category</label>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <button type="submit" class="btn btn-primary">Save Category</button>
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
