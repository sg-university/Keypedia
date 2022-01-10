@extends('templates.managerLayout')

@section('content')

    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Manage Categories</h2>
    </div>

    <section id="categories">
        <div class="container d-flex justify-content-center my-5">

            <div class="row justify-content-center">
                @forelse ($categories as $category)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ '/img/' . $category->image_id }}" class="card-img-top" alt="" />
                            <div class="card-body">
                                <h5 class="card-text">{{ $category->name }}</h5>
                                <div class="btn-toolbar justify-content-center">
                                    <form method="post"
                                        action="{{ route('manager.category.api.deleteOneCategoryById', ['id' => $category->id]) }}">
                                        @method('DELETE')
                                        <div class="btn-group">
                                            <button class="btn btn-primary me-3">Delete</button>
                                        </div>
                                    </form>

                                    <form method="get"
                                        action="{{ route('manager.category.update.index', ['id' => $category->id]) }}}">
                                        <div class="btn-group">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h4>Empty</h4>
                @endforelse


            </div>
        </div>
    </section>

    {{-- Akhir konten --}}


@endsection
