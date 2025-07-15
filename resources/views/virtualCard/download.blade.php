
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Votre Carte Virtuelle</title>
    <style>
        /* Importation d'une police (s'assurer que le fichier de police est accessible ) */
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap' );
        <div>
        <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
        </div>

        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #f0f2f5; /* Juste pour le contexte, ne sera pas dans le PDF final */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card-container {
            width: 350px;
            height: 220px;
            padding: 25px;
            border-radius: 20px;
            background: linear-gradient(45deg, #0f2027, #203a43, #2c5364);
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            position: relative;
            box-sizing: border-box;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .bank-name {
            font-size: 18px;
            font-weight: bold;
        }

        .chip-icon {
            width: 40px;
            height: 30px;
            background-color: #ffc46a;
            border-radius: 4px;
        }

        .card-number {
            font-size: 20px;
            letter-spacing: 2px;
            margin-bottom: 25px;
            text-align: center;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 12px;
            text-transform: uppercase;
        }

        .card-holder-name {
            font-size: 14px;
        }

        .label {
            font-size: 10px;
            color: #b8c1c6;
        }
    </style>
</head>
<body>

<div class="card-container">
    <div class="card-header">
        <div class="bank-name">{{ $bankName }}</div>
        <div class="chip-icon"></div>
    </div>

    <div class="card-number">
        {{ $cardNumber }}
    </div>

    <div class="card-footer">
        <div>
            <div class="label">Titulaire</div>
            <div class="card-holder-name">{{ $cardHolder }}</div>
        </div>
        <div>
            <div class="label">Expire fin</div>
            <div>{{ $expirationDate }}</div>
        </div>
        <div>
            <div class="label">CVV</div>
            <div>{{ $cvv }}</div>
        </div>
    </div>
</div>

</body>
</html>
