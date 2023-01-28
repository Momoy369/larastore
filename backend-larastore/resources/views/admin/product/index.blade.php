@extends('layouts.app', ['title' => 'Products'])

@section('content')

{{-- Begin Page Content --}}
<div class="container-fluid mb-5">

    {{-- Page Heading --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fa fa-shopping-bag"></i>
                        PRODUCTS
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.product.index') }}" method="GET">
                    
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm" style="padding-top: 10px;">
                                    
                                        <i class="fa fa-plus-circle"></i>
                                        ADD

                                    </a>
                                </div>

                                <input type="text" class="form-control" name="q" placeholder="Search by product name">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        SEARCH
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col">PRODUCT NAME</th>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col" style="width: 15%;text-align:center">ACTION</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($products as $no => $product)
                                <tr>
                                    <th scope="row" style="text-align: center">
                                    
                                        {{ ++$no + ($products->currentPage()-1) * $products->perPage() }}

                                    </th>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td class="text-center">

                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                        
                                            <i class="fa fa-pencil-alt"></i>

                                        </a>

                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $product->id }}">
                                        
                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </td>
                                </tr>
                                    
                                @empty

                                <div class="alert alert-danger">
                                    No data available!
                                </div>
                                    
                                @endforelse
                            </tbody>

                        </table>

                        <div style="text-align: center">
                        
                            {{ $products->links("vendor.pagination.bootstrap-4") }}

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
            text: "WANT TO DELETE THIS?",
            icon: "warning",
            buttons: [
                'NO',
                'YES'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                // AJAX DELETE
                jQuery.ajax({
                    url: "/admin/product/" + id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status == "success") {
                            swal({
                                title: 'SUCCESS',
                                text: 'DELETE SUCCESSFULLY!',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
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