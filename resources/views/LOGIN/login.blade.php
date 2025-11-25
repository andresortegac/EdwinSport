<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--styles end-->

    <title>Login</title>

  </head>
  <body>
    <div id="wrapper">
      <div id="left">
        <div id="signin">
          <div class="logo">
            <h2>
              Ingresar al Sistema
            </h2>
          </div>
          <form action="http://localhost/projects/servientrega/public/" method="POST">

            @csrf
            
            <div>
              <label>
                Usuario
              </label>
              <input type="text" class="text-input" name="username"/>
            </div>

            <div>
              <label>
                Password
              </label>
              <input type="password" class="text-input" name="password"/>
            </div>

            <a href="home">
              <button type="submit" class="primary-btn" >
                Ingresar
              </button>
            </a>
                       
          </form>

          <div class="links">
            <a href="register/show">  <!---Redirecci�na a LA RUTA Register/Show--->
              Crear Cuenta
            </a>
          </div>
          <div class="links">
            <a href="#">
              Forgot Password
            </a>
          </div>
          <div class="or">
            <hr class="bar" />
            <hr class="bar" />
          </div>
        </div>
        <footer id="main-footer">
            <p>
              Copyright &copy; 2023 - All Rights Reserved
            </p>
            <div>
              <a href="#">terms of use</a> | <a href="#">Privacy Policy</a>
            </div>
        </footer>
      </div>
      <div id="right">
        <div id="showcase">
          <div class="showcase-content">
            <h1 class="showcase-text">              
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

@section('js')


@endsection