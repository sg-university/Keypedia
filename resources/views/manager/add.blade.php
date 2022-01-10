@extends('templates.managerLayout')

@section('content')
    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Add Keyboard</h2>
    </div>

    <div class="container d-flex justify-content-center my-5 border p-5" style="background-color : 	white;">
        <div class="col-md-6">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif

            @if (Session::exists('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ Session::get('message') }}</li>
                    </ul>
                </div><br />
            @endif
            <form enctype="multipart/form-data" class="form-horizontal"
                action="{{ route('manager.keyboard.add.api.createOneKeyboard') }}" method="post">
                @csrf

                <div class="form-group row mb-3">
                    <label class="col-md-4 col-form-label" for="price">Category</label>
                    <div class="col-md-8">
                        <select class="form-control custom-select" id="inlineFormCustomSelect" name="category_id">
                            <option disabled selected>Choose a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="keyboardname" class="col-md-4 col-form-label">Keyboard Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="formGroupExampleInput" name="name">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 col-form-label" for="price">Keyboard Price (USD)</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="price" name="price" min="1">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 col-form-label" for="price">Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            name="description"></textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-4 col-form-label" for="file">Image</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control" id="exampleFormControlFile1" name="image">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <div class="col-md-4 col-form-label"></div>
                    <div class="col-md-8">
                        <button class="btn btn-success btn-primary mt-4 mb-5 " type="submit">Add</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    {{-- Akhir konten --}}
@endsection
