@extends('admin.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                value="{{ old('title') }}" placeholder="Title">
                                        </div>
                                        <span class="text-danger">
                                            @error('title')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug"
                                                class="form-control @error('slug') is-invalid @enderror"
                                                value="{{ old('slug') }}" placeholder="Slug">
                                        </div>
                                        <span class="text-danger">
                                            @error('slug')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote"
                                                placeholder="short_description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_returns">Shipping & Returns</label>
                                            <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote"
                                                placeholder="shipping_returns"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <input type="file" name="photo" id="photo"
                                        class="form-control mb-2 @error('photo') is-invalid @enderror"
                                        onchange="previewImage(event)">
                                <img id="imagePreview" src="#" alt="Uploaded Image" class="img-fluid img-thumbnail"
                                    style="width: 150px; height: 150px; border: 1px solid #ccc; padding: 5px; object-fit: cover; display: none;" />
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price"
                                                class="form-control @error('price') is-invalid @enderror"
                                                value="{{ old('price') }}" placeholder="Price">
                                        </div>
                                        <span class="text-danger">
                                            @error('price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at
                                                price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku"
                                                class="form-control @error('sku') is-invalid @enderror"
                                                value="{{ old('sku') }}" placeholder="sku">
                                        </div>
                                        <span class="text-danger">
                                            @error('sku')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" id="track_qty"
                                                    name="track_qty" value="Yes" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control @error('qty') is-invalid @enderror" placeholder="Qty">
                                        </div>
                                        <span class="text-danger">
                                            @error('qty')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Related product</h2>
                                <div class="mb-3">
                                    <select multiple class="related-product w-100" name="related_products[]"
                                        id="related_product">
                                    </select>
                                </div>
                                <span class="text-danger">
                                    @error('related_product')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category"
                                        class="form-control @error('category') is-invalid @enderror"">
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger">
                                    @error('category')
                                        {{ $message }}
                                    @enderror
                                </span>
                                <div class="mb-3">
                                    <label for="sub_category">Subcategory</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a Subcategory</option>
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="status" class="form-control">
                                        <option value="">Select a Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="status"
                                        class="form-control @error('is_featured') is-invalid @enderror">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                                <span class="text-danger">
                                    @error('is_featured')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('title').addEventListener('blur', function() {
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

        //for sub categories ajax

        $("#category").change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route('product-subcategories.index') }}', // Make sure this route is correct
                type: 'GET',
                data: {
                    category_id: category_id
                }, // Corrected data syntax
                dataType: 'json',
                success: function(response) {
                    // Clear existing options, except the first one
                    $("#sub_category").find("option").not(":first").remove();

                    // Append new options
                    $.each(response["subCategories"], function(key, item) {
                        $("#sub_category").append(`<option value ='${item.id}'> ${item.name}
                       </option>`);
                    });
                },
                error: function() {
                    console.log("Something went wrong");
                }
            });
        });

        //for preview image javascript logic
        function previewImage(event) {
            const input = event.target; // File input element
            const preview = document.getElementById('imagePreview'); // Preview image element

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Set preview image source
                    preview.style.display = 'block'; // Make the image visible
                };
                reader.readAsDataURL(input.files[0]); // Read file as data URL
            }
        }

        //relted product
        $('.related-product').select2({
            ajax: {
                url: '{{ route('products.getProducts') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });

    </script>
@endsection
