@extends('layouts.main')
@section('contents')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Review</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('adminHome')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('review.list')}}">List Review</a></li>
                            <li class="breadcrumb-item active">Detail Review</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @if(\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{\Illuminate\Support\Facades\Session::get('success')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                                <div class="form-group required">
                                    <label for="inputName">Product</label>
                                    <input type="text"  id="input-name" name="name" value="{{$review->product->name}}" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="inputDescription">Comment</label>
                                    <textarea id="input-description" name="description"  class="form-control" rows="4" readonly>{{$review->comment}}</textarea>
                                </div>
                                <div class="form-group required">
                                    <label for="inputName">Rated By</label>
                                    <input type="text"  id="input-name" name="name" value="{{$review->username}}" class="form-control" disabled>
                                </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <form action="" method="post" name="changeOrderStatus" id="changeOrderStatus">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Review Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option {{($review->status === 1) ? 'selected' : ''}} value="1">Active</option>
                                        <option {{($review->status === 0) ? 'selected' : ''}} value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("#changeOrderStatus").submit(function (event){
            event.preventDefault();
            $.ajax({
                url: '{{route('review.changeOrderStatus', $review->id)}}',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response){
                    if (response.status == true){
                        window.location.href = '{{route('review.detail', $review->id)}}'
                    }
                }
            })
        });
    </script>
@endpush
