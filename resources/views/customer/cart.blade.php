@extends('templates.customerLayout')

@section('content')

    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">My Cart</h2>
    </div>

    <div class="container d-flex justify-content-center my-5 p-5" style="background-color : 	white;">
        <div>
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
            @forelse ($userCartKeyboards as $cartKeyboard)
                <div class="row my-2 mx-2 main">
                    <div class="col-md-4 col-12 mycol mb-4">
                        <img src="{{ '/img/' . $cartKeyboard->image_id }}" width="100%" height="100%">
                    </div>
                    <div class="col-md-8 col-12 xcol">
                        <h3>{{ $cartKeyboard->name }}</h3>
                        <p class="mt-4">Subtotal: $
                            {{ $cartKeyboard->pivot->quantity * $cartKeyboard->price }}
                        </p>
                        <div class="col-md-8 col-12 xcol">
                            <form class="form-horizontal"
                                action="{{ route('customer.cart.api.updateOneCartKeyboardById', ['id' => $cartKeyboard->pivot->id]) }}"
                                method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group row mb-3">
                                    <label class="col-md-3 col-form-label" for="quantity">Quantity</label>
                                    <div class="col-md-8">
                                        <input hidden type="text" class="form-control" id="keyboard_id" name="keyboard_id"
                                            value="{{ $cartKeyboard->id }}">
                                        <input type="number" class="form-control" id="quantity" name="quantity" min="1">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <div class="col-md-3 col-form-label"></div>
                                    <div class="col-md-8">
                                        <button class="btn btn-success mt-4 mb-5 " type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <h4>Empty</h4>
            @endforelse

            <div class="d-flex justify-content-center">
                <a href="{{ route('customer.cart.api.checkoutCartByUserId', ['id' => $user->id]) }}">
                    <button class="btn btn-success btn-primary mt-4 mb-5 " type="submit">Checkout</button>
                </a>
            </div>
        </div>

    </div>

    {{-- Akhir konten --}}

@endsection
