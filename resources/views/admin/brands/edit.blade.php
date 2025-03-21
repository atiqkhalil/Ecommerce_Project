@extends('admin.dashboard')

@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Brand</h1>                
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('brand.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
 <form action="{{ route('brand.update',$branddetails->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $branddetails->name }}" placeholder="Name">	
                        </div>
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Description</label>
                            <input type="text" name="desc" id="name"
                                class="form-control @error('desc') is-invalid @enderror" value="{{ $branddetails->description }}"
                                placeholder="Description">
                        </div>
                        <span class="text-danger">
                            @error('desc')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" readonly name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ $branddetails->slug }}" placeholder="Slug">	
                        </div>
                        <span class="text-danger">
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>	
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Upload Category Image</label>
                            <input type="file" name="photo"  id="photo" onchange="document.querySelector('#output').src = window.URL.createObjectURL(this.files[0])">	
                        </div>
                        <img id = 'output' src="{{ asset('/storage/' . $branddetails->image) }}" alt="Uploaded Image" class="img-fluid img-thumbnail" style="width: 150px; height: 150px; border: 1px solid #ccc; padding: 5px; object-fit: cover;" />
                        <span class="text-danger">
                            @error('photo')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" >
                                <option {{ ($branddetails->status == 1) ? 'selected' : ''  }} value="1">Active</option>
                                <option {{ ($branddetails->status == 0) ? 'selected' : ''  }} value="0">Block</option>
                            </select>	
                        </div>
                    </div>								
                </div>
            </div>							
        </div>
    
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('brand.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
 </form>
    <!-- /.card -->
</section>
<!-- /.content -->
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('name').addEventListener('blur', function () {
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
