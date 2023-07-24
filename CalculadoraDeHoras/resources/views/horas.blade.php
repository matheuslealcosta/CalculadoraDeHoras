<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de horas</title>
</head>
<body class="matheus">
    <h1 class="matheus">Calculadora de Horas 🕒</h1>
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

                // Apply night theme
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
