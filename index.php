<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>

    <link rel="stylesheet" href="styles.css">

    <!-- Boostrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    
    <script src="index.js"></script>
</head>

<body>
    <div class="weather-app-container">
        <div class="weather-login-btn-container">
            <?php 
                if (isset($_GET["auth"])) {
                    $authValue = $_GET["auth"];
                    if ($authValue == "1") {
                        echo '<h5 id="userText">Bienvenid@</h5>';
                        echo '
                            <button type="button" id="logInButton" style="display: none;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Iniciar sesión
                            </button>
                        ';
                        echo '
                            <button type="button" id="logOutButton" class="btn btn-danger" onclick="logOut()">
                                Cerrar sesión
                            </button>  
                        ';
                    } else {
                        echo '<h5 id="userText" style="visibility: hidden;"></h5>';
                        echo '
                            <button type="button" id="logInButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Iniciar sesión
                            </button>
                        ';
                        echo '
                            <button type="button" id="logOutButton" style="display: none;" class="btn btn-danger" onclick="logOut()">
                                Cerrar sesión
                            </button>  
                        ';
                    }
                } else {
                    echo '<h5 id="userText" style="visibility: hidden;"></h5>';
                    echo '
                        <button type="button" id="logInButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Iniciar sesión
                        </button>
                    ';
                    echo '
                        <button type="button" id="logOutButton" style="display: none;" class="btn btn-danger" onclick="logOut()">
                            Cerrar sesión
                        </button>  
                    ';
                }
            ?>            
        </div>
        <div class="weather-main-grid">
            <div>
                <form method="GET" action="index.php">
                    <h1 style="margin: 0;">Predictor de clima</h1>
                    <div class="p-3"></div>
                    <div class="mb-3">
                        <label class="form-label">Temperatura</label>
                        <input type="number" id="temp" name="temp" class="form-control" value="<?php echo $_GET["temp"]?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Humedad</label>
                        <input type="number" id="hudimity" name="humidity" class="form-control" value="<?php echo $_GET["humidity"]?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Presión</label>
                        <input type="number" id="pressure" name="pressure" class="form-control" value="<?php echo $_GET["pressure"]?>">
                    </div>
                    <?php
                        if (isset($_GET["auth"])) {
                            $authValue = $_GET["auth"];
                            echo '<input type="hidden" id="auth" name="auth" value="'.$authValue.'">';
                        } else {
                            echo '<input type="hidden" id="auth" name="auth" value="0">';
                        }
                    ?>
                    <button id="submit" type="submit" class="btn btn-primary">Generar</button>
                </form>
            </div>
            <div>
                <?php
                    if (isset($_GET["temp"]) && isset($_GET["humidity"]) && isset($_GET["pressure"])) {
                        include "libs/weather_api.php";
                        $api = new WeatherApi;
                        $predictions = $api->getPrediction();
                        $amount = count($predictions);

                        echo '
                            <div class="weather-predictions-title">
                                <h3 style="margin: 0;">'.$amount.' predicciones generadas</h3>
                            </div>
                        ';

                        echo '<div class="p-3"></div>';
                        echo '<div class="weather-predictions-grid">';
                        foreach ($predictions as $element) {
                            $icon = $element->icon;
                            $imageUrl = "http://openweathermap.org/img/wn/$icon@2x.png";
                            echo '
                                <div class="card text-dark">
                                    <div class="card-body">
                                        <div class="weather-prediction-card-header">
                                            <h5 class="card-title">'.$element->description.'</h5>
                                            <img src="'.$imageUrl.'">
                                        </div>
                                        <p class="card-text">Temperatura: '.$element->temp.'</p>
                                        <p class="card-text">Humedad: '.$element->humidity.'</p>
                                        <p class="card-text">Presión: '.$element->pressure.'</p>
                                    </div>
                                </div>
                            ';
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Login -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                         <label class="form-label">Usuario</label>
                        <input type="text" id="user" class="form-control">
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="loginButton" type="button" class="btn btn-primary" onclick="logIn()">Iniciar sesión</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>