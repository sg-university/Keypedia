@extends('templates.guestLayout')

@section('content')
    {{-- Konten --}}
    <h2 class="text-center">Welcome to Keypedia</h2>
    <h6 class="text-center mb-4">Best Keyboard and Keycaps Shop</h6>
    <div class="row d-flex justify-content-center text-center mb-3">
        <h2>Categories</h2>
    </div>

    <div class="container d-flex justify-content-center my-5">
        <div class="row justify-content-center">
            @forelse ($categories as $category)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('guest.keyboard.index', ['category_id' => $category->id]) }}">
                        <div class="card">
                            <img src="{{ '/img/' . $category->image_id }}" class="card-img-top" alt="" />
                            <div class="card-body">
                                <h5 class="card-text">{{ $category->name }}</h5>
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
