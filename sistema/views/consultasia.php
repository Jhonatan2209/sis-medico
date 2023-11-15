<?php
include '../includes/header.php';
include '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $apiKey = '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'; // Reemplaza con tu clave API de ChatGPT
    $url = 'https://api.openai.com';

    $data = array(
        "context" => $_POST['query'],
        "model" => "gpt-3.5-turbo",
        "num_completions" => 1,
        "length" => 50,
        "temperature" => 0.7
    );

    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ));

    $result = curl_exec($ch);
    
    // Mostrar errores de cURL
    if(curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
    }

    curl_close($ch);

    // Imprimir la respuesta de la API para verificar si hay datos
    echo 'Respuesta de la API: <pre>' . print_r($result, true) . '</pre>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConsultasGPT</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>CONSULTA GPT</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="query">Escribe tu consulta:</label>
                <input type="text" class="form-control" id="query" name="query" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Consulta</button>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])): ?>
            <div class="mt-3">
                <h3>Respuesta:</h3>
                <p><?php echo $result; ?></p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../package/jquery-3.6.0.min.js"></script>
    <script src="../package/dist/sweetalert2.all.js"></script>
    <script src="../package/dist/sweetalert2.all.min.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
