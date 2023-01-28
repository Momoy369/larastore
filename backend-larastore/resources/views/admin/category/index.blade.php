@extends('layouts.app', ['title' => 'Categories'])

@section('content')

{{-- Begin Page Content --}}
<div class="container-fluid mb-5">

    {{-- Page Heading --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-folder">Category</i>
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.category.index') }}" method="GET">
                        
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm" style="padding-top: 10px;">
                                    
                                        <i class="fa fa-plus-circle">ADD</i>

                                    </a>
                                </div>

                                <input type="text" name="q" class="form-control" placeholder="Search by category">

                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search">SEARCH</i>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%;">NO.</th>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">CATEGORY NAME</th>
                                    <th scope="col" style="width: 15%;text-align: center;">ACTION</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($categories as $no => $category)

                                <tr>
                                    <th scope="row" style="text-align: center;">{{ ++$no + ($categories->currentPage()-1) * $categories->perPage() }}</th>
                                    <td class="text-center"><img src="{{ $category->image }}" style="width:50px;"></td>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-center"><a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>

                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $category->id }}"><i class="fa fa-trash"></i></button>

                                    </td>
                                </tr>
                                    
                                @empty

                                <div class="alert alert-danger">
                                    No data available!
                                </div>
                                    
                                @endforelse

                            </tbody>

                        </table>

                        <div style="text-align: center;">
                        
                            {{ $categories->links("vendor.pagination.bootstrap-4") }}

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<script>
    // AJAX DELETE
    function Delete(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "ARE YOU SURE?",
            text: "DELETE THIS DATA?",
            icon: "warning",
            buttons: [
                'NO',
                'YES',
            ],

            dangerMode: true,
        }).then(function (isConfirm) {
            if(isConfirm) {
            // AJAX DELETE
            jQuery.ajax({
                url: "/admin/category/" + id,
                data: {
                    "id": id,
                    "_token": token
                },
                type: 'DELETE',
                success: function(response) {
                    if (response.status == "success") {
                        swal({
                            title: 'SUCCESS!',
                            text: 'DELETE SUCCESSFULLY!',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                            showCancelButton: false,
                            buttons: false,
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        swal({
                            title: 'FAILED!',
                            text: 'DELETE FAILED!',
                            icon: 'error',
                            timer: 1000,
                            showConfirmButton: false,
                            showCancelButton: false,
                            buttons: false,
                        }).then(function () {
                            location.reload();
                        });
                    }
                }
            });

            } else {
                return true;
            }
        });

    }
</script>

@endsection