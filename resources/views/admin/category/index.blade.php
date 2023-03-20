@extends('admin.layout.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category list</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                            <h3 class="card-title">Category</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(isset($categories))
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 10px">Status</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Parent</th>
                                    <th class="text-center" style="width: 120px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td><input type="checkbox" class="toggle-active" data-url="{{ route('categories.update', $category->id) }}" name="is_active" {{ $category->is_active ? 'checked' : '' }}></td>
                                        <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->parentCategory->name ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a class="btn btn-outline-danger delete-button" data-title="{{ $category->name }}" data-link="{{ route('categories.destroy', $category->id) }}" data-toggle="modal" data-target="#deleteForm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                            <h4>No data found</h4>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix d-flex justify-content-end">
                            {{ $categories->links() }}
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
        $(document).ready(function () {
            $('.delete-button').on('click', (e) => {
                const title = $(e.target).data('title')
                const link = $(e.target).data('link')

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
    </script>
@endpush
