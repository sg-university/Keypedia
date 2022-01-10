@extends('templates.managerLayout')

@section('content')
    {{-- Konten --}}
    <h2 class="text-center m-5 py-2" style="background-color: lightblue">{{ $category->name }}</h2>

    <nav class="navbar ms-5 mb-4">
        <div class="container-fluid">
            <form class="d-flex" method="POST"
                action="{{ route('manager.keyboard.api.searchAllKeyboardByKeywords', ['category_id' => $category->id]) }}">
                <input class="form-control me-2" name="keywords" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container d-flex justify-content-center my-5">
        <div class="row justify-content-center">

            @forelse ($keyboards as $keyboard)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('manager.keyboard.detail.index', ['id' => $keyboard->id]) }}">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ '/img/' . $keyboard->image_id }}" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $keyboard->name }}</h5>
                                <p class="card-text">{{ $keyboard->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <h4>Empty</h4>
            @endforelse

        </div>
    </div>

    {{-- Akhir konten --}}

@endsection
