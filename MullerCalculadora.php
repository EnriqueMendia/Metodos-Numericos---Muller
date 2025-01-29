<?php

class ImpMuller {

    public function calculateMuller($x0, $x1, $x2, $maxIter, $tol) {
        try {
            // Extract input values from text fields
            $x0 = floatval($_POST["x0"]);
            $x1 = floatval($_POST["x1"]);
            $x2 = floatval($_POST["x2"]);
            $maxIter = intval($_POST["maxIter"]);
            $tol = floatval($_POST["tol"]);

            // Initialize a string to store results
            $results = "Resuldados del Metodo de Muller:<br>----------------------<br>";

            // Perform Muller's method iterations
            $h1 = $x1 - $x0;
            $h2 = $x2 - $x1;

             //Add a check for division by zero
            if ($h1 == 0 || $h2 == 0) {
                throw new DivisionByZeroError("Error: Division por cero.");
            }

            $d1 = ($this->f($x1) - $this->f($x0)) / $h1;
            $d2 = ($this->f($x2) - $this->f($x1)) / $h2;
            $d = ($d2 - $d1) / ($h2 + $h1);

            $i = 3;
            while ($i <= $maxIter) {
                $b = $d2 + $h2 * $d;
                $D = sqrt($b * $b - 4 * $this->f($x2) * $d);
                $E = abs($b - $D) < abs($b + $D) ? $b + $D : $b - $D;
                $h = -2 * $this->f($x2) / $E;
                $p = $x2 + $h;

                $results .= "ITERACION #" . ($i - 2) . ": raiz = " . $p . "<br>";

                if (abs($h) < $tol) {
                    $results .= "¡ Eureka ! Raiz encontrada con la precisión requerida. :)<br>";
                    break;
                }

                $x0 = $x1;
                $x1 = $x2;
                $x2 = $p;
                $h1 = $x1 - $x0;
                $h2 = $x2 - $x1;

                // Add a check for division by zero
                if ($h1 == 0 || $h2 == 0) {
                    throw new DivisionByZeroError("Errorrr: Division por cero.");
                }

                $d1 = ($this->f($x1) - $this->f($x0)) / $h1;
                $d2 = ($this->f($x2) - $this->f($x1)) / $h2;
                $d = ($d2 - $d1) / ($h2 + $h1);
                $i++;
            }

            if ($i > $maxIter) {
                $results .= "Numero Maximo de iteraciones realizadas!\n";
            }

            return $results;
        } catch (DivisionByZeroError $ex) {
            return $ex->getMessage();
        }
    }

    private function f($x) {
        // Define your function here
        return $x * $x * $x - $x * $x - $x - 1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Muller Method</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1, h2 {
            text-align: center;
        }

        form {
            width: 300px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #results-container {
            width: 400px;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .result {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>Metodo de Muller - Muller Method</h1>
<h2>CREADO POR: ENRIQUE MENDIA PARADA</h2>

<form action="index.php" method="post">
    <div class="form-group">
        <label for="x0">x0:</label>
        <input type="text" class="form-control" name="x0" id="x0">
    </div>
    <div class="form-group">
        <label for="x1">x1:</label>
        <input type="text" class="form-control" name="x1" id="x1">
    </div>
    <div class="form-group">
        <label for="x2">x2:</label>
        <input type="text" class="form-control" name="x2" id="x2">
    </div>
    <div class="form-group">
        <label for="maxIter">Numero de iteraciones:</label>
        <input type="text" class="form-control" name="maxIter" id="maxIter">
    </div>
    <div class="form-group">
        <label for="tol">Tolerancia:</label>
        <input type="text" class="form-control" name="tol" id="tol">
    </div>
    <button type="submit" class="btn btn-primary">Calcular</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $x0 = isset($_POST["x0"]) ? floatval($_POST["x0"]) : null;
    $x1 = isset($_POST["x1"]) ? floatval($_POST["x1"]) : null;
    $x2 = isset($_POST["x2"]) ? floatval($_POST["x2"]) : null;
    $maxIter = isset($_POST["maxIter"]) ? intval($_POST["maxIter"]) : null;
    $tol = isset($_POST["tol"]) ? floatval($_POST["tol"]) : null;

    // Check if all values are set
    if ($x0 !== null && $x1 !== null && $x2 !== null && $maxIter !== null && $tol !== null) {
       
        // Create an instance of ImpMuller
        $muller = new ImpMuller();

        // Calculate Muller's method
        $result = $muller->calculateMuller($x0, $x1, $x2, $maxIter, $tol);

        // Display result in a container
        echo '<div id="results-container">';
        echo '<div class="result">' . $result . '</div>';
        echo '</div>';
    } else {
        echo "¡Ingresa valores válidos para todos los campos!";
    }
}
?>
</body>
</html>
