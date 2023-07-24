<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de horas</title>
    <style>
        body {
            background-color: #f0f0f0;
            color: #333;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin-top: 30px;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-size: 20px;
            margin-right: 5px;
        }

        input[type="time"] {
            font-size: 18px;
            padding: 5px;
        }

        #calcularBtn {
            font-size: 18px;
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        #resultado {
            margin-top: 30px;
            font-size: 20px;
        }

        #resultado p {
            margin-bottom: 10px;
        }

        #resultado button {
            font-size: 18px;
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .night-theme {
            background-color: #333;
            color: #fff;
        }

        .night-theme button {
            background-color: #3a3a3a;
        }
    </style>
</head>
<body>
    <h1>Calculadora de Horas 🕒</h1>
    <form id="calcularForm">
        @csrf
        <label for="inicio">Hora de Início:</label>
        <input type="time" id="inicio" name="inicio"><br>

        <label for="final">Hora Final:</label>
        <input type="time" id="final" name="final"><br>

        <button type="button" id="calcularBtn">Calcular Horas</button>
    </form>
    <div id="resultado"></div>

    <script>
        document.getElementById('calcularBtn').addEventListener('click', function() {
            var inicio = document.getElementById('inicio').value;
            var final = document.getElementById('final').value;

            var formData = new FormData();
            formData.append('inicio', inicio);
            formData.append('final', final);

            fetch('/horas', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Display the result without refreshing the page
                document.getElementById('resultado').innerHTML = `
                    <h1>Resultado de Horas 🕒</h1>
                    <p>Horas Diurnas: ${data.horas_diurnas}</p>
                    <p>Horas Noturnas: ${data.horas_noturnas}</p>
                    <button onclick="goBack()">Voltar</button>
                `;
                document.body.classList.add('night-theme');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
