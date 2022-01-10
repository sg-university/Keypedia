@extends('templates.customerLayout')

@section('content')


    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Your Transaction At {{ $transaction->updated_at }}</h2>
    </div>

    <div class="container d-flex justify-content-center my-5">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaction->keyboards as $keyboard)
                            <tr>
                                <td>
                                    <img src="{{ '/img/' . $keyboard->image_id }}" alt="keyboard-image" width="300px"
                                        height="200px">
                                </td>
                                <td>
                                    <p>{{ $keyboard->name }}</p>
                                </td>
                                <td>
                                    <p>{{ $keyboard->pivot->quantity * $keyboard->price }}</p>
                                </td>
                                <td>
                                    <p>{{ $keyboard->pivot->quantity }}</p>
                                </td>
                            </tr>

                        @empty
                            <h4>Empty</h4>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- Akhir konten --}}
@endsection
