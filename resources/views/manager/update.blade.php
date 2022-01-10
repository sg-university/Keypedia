@extends('templates.managerLayout')

@section('content')
    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Update Keyboard</h2>
    </div>

    <div class="container d-flex justify-content-center my-5 border p-5" style="background-color : 	white;">
        <div class="row my-2 mx-2 main">
            <div class="col-md-4 col-12 mycol mb-4">
                <img src="{{ '/img/' . $keyboard->image_id }}" width="100%" height="50%">
            </div>
            <div class="col-md-8 col-12 xcol">
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
                    action="{{ route('manager.keyboard.update.api.updateOneKeyboardById', ['id' => $keyboard->id]) }}"
                    method="post">
                    @method("PUT")

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label" for="price">Category</label>
                        <div class="col-md-8">
                            <select class="form-control custom-select" id="inlineFormCustomSelect" name="category_id"
                                value="{{ $keyboard->category_id }}">
                                <option disabled>Choose a category</option>
                                @foreach ($categories as $category)
                                    @if ($category->id == $keyboard->category_id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="keyboardname" class="col-md-4 col-form-label">Keyboard Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="formGroupExampleInput" name="name"
                                value="{{ $keyboard->name }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label" for="price">Keyboard Price (USD)</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="price" name="price" min="1"
                                value="{{ $keyboard->price }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label" for="price">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"
                                value="{{ $keyboard->description }}">{{ $keyboard->description }} </textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label" for="file">Image</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" id="exampleFormControlFile1" name="image">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-md-3 col-form-label"></div>
                        <div class="col-md-8">
                            <form action="/manager/manage">
                                <button class="btn btn-success btn-primary mt-4 mb-5 " type="submit">Update</button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    {{-- Akhir konten --}}
@endsection
