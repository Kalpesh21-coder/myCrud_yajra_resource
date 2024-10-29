<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">


    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css
">
</head>

<body>


    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">Manage Your Data
                @if ($view_type != 'listing')
                    <a href="{{ route('hero.index') }}">Back</a>
                @else
                    <a href="{{ route('hero.create') }}">Create</a>
                @endif
            </div>


            <div class="card-body">

                @session('status')
                    <div class="alert alert-success p-2">{{ session('status') }}</div>
                @endsession
                @if ($view_type == 'add' || $view_type == 'edit')
                    <div class=" m-5 shadow-lg p-3 ">

                        <form
                            action="{{ $view_type == 'edit' ? route('hero.update', $hero->id) : route('hero.store') }}"
                            method="POST" enctype="multipart/form-data" name="frmDetail" id="frmDetail">
                            @csrf

                            @method($view_type == 'edit' ? 'PUT' : 'POST')
                            <div class="mb-3">
                                <label class="form-label">Name : </label>
                                <input name="name" value="{{ $view_type == 'edit' ? $hero->name : old('name') }} "
                                    type="text" class="form-control">

                                @error('name')
                                    <div class=" m-1 p-2 text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Photo : </label>
                                <input name="image" value="{{ $view_type == 'edit' ? $hero->image : old('image') }}"
                                    type="file" class="form-control">

                                @error('image')
                                    <div class=" m-1 p-2 text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price : </label>
                                <input name="price" value="{{ $view_type == 'edit' ? $hero->price : old('price') }}"
                                    type="text" class="form-control">

                                @error('price')
                                    <div class=" m-1 p-2 text-danger">{{ $message }}</div>
                                @enderror

                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>

                    </div>
                @elseif($view_type == 'listing')
                    <div class="table-responsive">
                        <form action="#" name="frmListing" id="frmListing" method="POST">
                            @csrf
@method('')
                            {{ $dataTable->table() }}
                        </form>
                    </div>
                @endif

                @if ($view_type == 'show')
                    <div>
                        <div>Name: {{ $hero->name }}</div>
                    </div>

                    <div>
                        <div>image: {{ $hero->image }}</div>
                    </div>

                    <div>
                        <div>Price: {{ $hero->price }}</div>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <script
        src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.min.js
                                                                                                                                                                                                                                                            ">
    </script>
    @if ($view_type == 'listing')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endif

    <script>
        function deleteData(url) {
            if(confirm('Are you sure you want to delete this record.')){
                var form = document.frmListing;
                console.log(form);
                form.action = url;
                form._method.value = 'DELETE';
                form.submit();
            }

        }
    </script>


</body>

</html>
