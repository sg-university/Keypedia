@extends('templates.managerLayout')

@section('content')

    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Detail Keyboard</h2>
    </div>

    <section id="keyboard-detail">
        <div class="container d-flex justify-content-center my-5 border p-5" style="background-color : 	white;">
            <div class="row my-2 mx-2 main">
                <div class="col-md-4 col-12 mycol mb-4">
                    <img src="{{ '/img/' . $keyboard->image_id }}" width="100%" height="100%">
                </div>
                <div class="col-md-8 col-12 xcol">
                    <h3>{{ $keyboard->name }}</h3>
                    <p class="mt-4">Price: $ {{ $keyboard->price }}</p>
                    <p>Description: {{ $keyboard->description }}</p>
                    <div class="col-md-8 col-12 xcol">
                        <div class="btn-toolbar justify-content-center">
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
                            <form method="post"
                                action="{{ route('manager.keyboard.detail.api.deleteOneKeyboardById', ['id' => $keyboard->id]) }}">
                                @method('DELETE')
                                <div class="btn-group">
                                    <button class="btn btn-danger me-3">Delete</button>
                                </div>
                            </form>

                            <form method="get"
                                action="{{ route('manager.keyboard.update.index', ['id' => $keyboard->id]) }}}">
                                <div class="btn-group">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Akhir konten --}}

@endsection
