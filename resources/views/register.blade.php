@extends('templates.menulogin')

@section('page-content')


<div class="row justify-content-center">
    <div class="col-md-4 border mt-5">
        <main class="form-sigin mt-5">
            <h1 class="h3 mb-3 fw-normal text-center mt-5 mb-3">Register</h1>

            <form action="/" method="post">
                @csrf
                <div class="form-floating mt-2">
                    <label for="username">Username</label>
                    <input type="username" name="username" class="form-control" id="username">

                </div>

                <div class="form-floating mt-2">
                    <label for="password">E-Mail Address</label>
                    <input type="password" name="password" class="form-control" id="password">

                </div>

                <div class="form-floating mt-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">

                </div>

                <div class="form-floating mt-2">
                    <label for="password2">Confirm Password</label>
                    <input type="password2" name="password2" class="form-control" id="password2">
                </div>

                <div class="form-floating mt-2">
                    <label for="address">Address</label>
                    <input type="address" name="address" class="form-control" id="address">
                </div>

                <label class="mt-2">Gender</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                        value="option1" checked>
                    <label class="form-check-label mr-5" for="exampleRadios1">
                        Male
                    </label>
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                        value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        Female
                    </label>
                </div>

                <div class="form-floating mt-2">
                    <label for="email">Date of Birth</label>
                    <input type="date" name="email" class="form-control" id="email">

                </div>

                <button class="w-100 btn btn-lg btn-primary mt-4 mb-5" type="submit">Login</button>

            </form>
        </main>
    </div>
</div>


@endsection
