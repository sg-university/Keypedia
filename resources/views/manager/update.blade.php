<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Hello, world!</title>
</head>

<body style="background-color: skyblue">
    {{-- Navbar --}}
    <div class="container bg-white">
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="">KeyPedia</a>

                    </div>
                </div>
                <form class="form-inline">
                    <div class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Categories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <li><a class="dropdown-item" href="/manager/view">87 Key Keyboard</a></li>
                              <li><a class="dropdown-item" href="/manager/view">61 Key Keyboard</a></li>
                              <li><a class="dropdown-item" href="/manager/view">XDA Profile</a></li>
                              <li><a class="dropdown-item" href="/manager/view">Cherry Profile</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            MANAGER
                        </a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="/manager/add">Add Keyboard</a></li>
                            <li><a class="dropdown-item" href="/manager/manage">Manage Categories</a></li>
                            <li><a class="dropdown-item" href="/manager/password">Change Password</a></li>
                            <li><a class="dropdown-item" href="/login">Logout</a></li>
                          </ul>
                        </li>
                        <p class="nav-link"><?= date("D, j-F-Y"); ?></p>
                    </div>
                </form>
            </div>

        </nav>
    </div>
    {{-- Akhir Navbar --}}

    {{-- Konten --}}
    <div class="row text-center mb-3">
        <h2 class="my-4">Update Keyboard</h2>
    </div>

    <div class="container d-flex justify-content-center my-5 border p-5" style="background-color : 	violet;">
        <div class="row my-2 mx-2 main">
            <div class="col-md-4 col-12 mycol mb-4">
                <img src="/img/1.jpg" width="100%" height="100%"> </div>
            <div class="col-md-8 col-12 xcol">
               
                    @csrf

                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label" for="price">Category</label>
                        <div class="col-md-8">
                            <select class="form-control" id="inlineFormCustomSelect">
                                <option selected>Choose a category</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="keyboardname" class="col-md-3 col-form-label">Keyboard Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="formGroupExampleInput">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label" for="price">Keyboard Price(USD)</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="price" name="price" min="1">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label" for="price">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label" for="file">Example file input</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" id="exampleFormControlFile1">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-md-3 col-form-label"></div>
                        <div class="col-md-8">
                            <form action="/manager/manage">
                            <button class="btn btn-success btn-primary mt-4 mb-5 " type="submit">Update</button>

                            </form>
                            
                            </div>
                    </div>
            </div>
        </div>
    </div>

    {{-- Akhir konten --}}


    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Made by aaaaaaaaaaaaaaaaaa</span>
            </div>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>
</body>

</html>
