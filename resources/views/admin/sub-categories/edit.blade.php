@extends('admin.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="subcategory.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('sub-categories.update',$subcategories->id) }}" method="post">
            @csrf
            @method('PUT')
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Sub Category</label>
                                <select name="category_id" id="category" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="">Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($subcategories->category_id == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>                                
                            </div>
                            <span class="text-danger">
                                @error('category')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ $subcategories->name }}"
                                    placeholder="Name">
                            </div>
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Slug</label>
                                <input type="text" readonly name="slug" id="slug"
                                    class="form-control @error('slug') is-invalid @enderror" value="{{ $subcategories->slug }}"
                                    placeholder="Slug">
                            </div>
                            <span class="text-danger">
                                @error('slug')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($subcategories->status == 1) ? 'selected' : ''  }} value="1">Active</option>
                                    <option {{ ($subcategories->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Show on Home Page</label>
                                <select name="showonhome" id="showonhome" class="form-control" >
                                    <option {{ ($subcategories->showonhome == 'No') ? 'selected' : ''  }} value="No">No</option>
                                    <option {{ ($subcategories->showonhome == 'Yes') ? 'selected' : ''  }} value="Yes">Yes</option>
                                </select>	
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('sub-categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('name').addEventListener('blur', function() {
            var title = this.value;

            var slug = title
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            document.getElementById('slug').value = slug;
        });
    });
</script>
