@extends('templates.customerLayout')

@section('content')

    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Change Password</h2>
    </div>

    <div class="container d-flex justify-content-center my-5 border p-5" style="background-color : 	white;">
        <div class="col-md-6">
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
            <form class="form-horizontal"
                action="{{ route('customer.change-password.api.changeUserPasswordById', ['id' => $user->id]) }}"
                method="post">
                @method('PUT')
                <div class="form-group row mb-3">
                    <label for="password" class="col-md-4 col-form-label">Current Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>


                <div class="form-group row mb-3">
                    <label for="new_password" class="col-md-4 col-form-label">New Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                </div>


                <div class="form-group row mb-3">
                    <label for="new_password_confirmation" class="col-md-4 col-form-label">New Password Confirmation</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="new_password_confirmation"
                            name="new_password_confirmation">
                    </div>
                </div>


                <div class="form-group row mb-3">
                    <div class="col-md-4 col-form-label"></div>
                    <div class="col-md-8">
                        <button class="btn btn-success btn-primary mt-4 mb-5 " type="submit">Update Password</button>
                    </div>
                </div>

            </form>
        </div>

    </div>
    {{-- Akhir konten --}}
@endsection
