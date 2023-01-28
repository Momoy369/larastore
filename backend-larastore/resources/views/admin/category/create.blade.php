@extends('layouts.app', ['title' => 'Add Category'])

@section('content')

{{-- Begin Page Content --}}
<div class="container-fluid">

    {{-- Page Heading --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-folder"></i>
                        ADD CATEGORY
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    
                        @csrf

                        <div class="form-group">
                            <label>IMAGE</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                            @error('image')

                            <div class="invalid-feedback" style="display: block;">
                            
                                {{ $message }}

                            </div>
                                
                            @enderror

                        </div>

                        <div class="form-group">
                            <label>CATEGORY NAME</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter category name" class="form-control @error('name') is-invalid @enderror">

                            @error('name')

                            <div class="invalid-feedback" style="display: block;">
                            
                                {{ $message }}

                            </div>
                                
                            @enderror

                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit">
                            <i class="fa fa-paper-plane"></i>
                            SAVE
                        </button>
                        <button class="btn btn-warning btn-reset">
                            <i class="fa fa-redo"></i>
                            RESET
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
    
@endsection