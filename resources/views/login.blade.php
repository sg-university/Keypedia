@extends('templates.guestLayout')

@section('content')

    <div class="container d-flex justify-content-center my-5">
        <div class="col-md-4 border mt-5">
            <main class="form-sigin mt-5">
                <h1 class="h3 mb-3 fw-normal text-center mt-5 mb-3">Login</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form action="{{ route('authentication.login.api.login') }}" method="POST">
                    @csrf

                    <div class="form-floating mt-2">

                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email">

                    </div>
                    <div class="form-floating mt-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">

                    </div>


                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                        <label class="form-check-label" for="autoSizingCheck">
                            Remember me
                        </label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary mt-4 mb-5" type="submit">Login</button>

                </form>
            </main>
        </div>
    </div>

@endsection
