@extends('templates.guestLayout')

@section('content')


    <div class="container d-flex justify-content-center my-5">
        <div class="col-md-4 border mt-5">
            <main class="form-sigin mt-5">
                <h1 class="h3 mb-3 fw-normal text-center mt-5 mb-3">Register</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form action="{{ route('authentication.register.api.register') }}" method="post">
                    @csrf
                    <div class="form-floating mt-2">
                        <label for="name">Name</label>
                        <input type="name" name="name" class="form-control" id="name">
                    </div>

                    <div class="form-floating mt-2">
                        <label for="username">Username</label>
                        <input type="username" name="username" class="form-control" id="username">
                    </div>

                    <div class="form-floating mt-2">
                        <label for="email">E-Mail Address</label>
                        <input type="email" name="email" class="form-control" id="email">

                    </div>

                    <div class="form-floating mt-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password">

                    </div>

                    <div class="form-floating mt-2">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            id="password_confirmation">
                    </div>

                    <div class="form-floating mt-2">
                        <label for="address">Address</label>
                        <input type="address" name="address" class="form-control" id="address">
                    </div>

                    <label class="mt-2">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender_id" id="exampleRadios1" value="1" checked>
                        <label class="form-check-label mr-5" for="exampleRadios">
                            Male
                        </label>
                        <input class="form-check-input" type="radio" name="gender_id" id="exampleRadios2" value="2">
                        <label class="form-check-label mr-5" for="exampleRadios2">
                            Female
                        </label><input class="form-check-input" type="radio" name="gender_id" id="exampleRadios3" value="3">
                        <label class="form-check-label" for="exampleRadios3">
                            Other
                        </label>
                    </div>

                    <div class="form-floating mt-2">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" id="dob">

                    </div>

                    <button class="w-100 btn btn-lg btn-primary mt-4 mb-5" type="submit">Register</button>
                </form>
            </main>
        </div>
    </div>


@endsection
