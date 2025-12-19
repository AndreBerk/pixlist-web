<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - Impressão</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px;
            font-family: 'Lato', sans-serif;
            display: flex;
            justify-content: center;
        }
        .card {
            background: white;
            width: 148mm; /* A5 */
            min-height: 210mm;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            position: relative;
            border: 1px solid #e5e7eb;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 20px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 28px;
            color: #111827;
            margin: 0;
        }
        .date {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #9ca3af;
            margin-top: 10px;
        }
        .content {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            line-height: 2;
            color: #374151;
            white-space: pre-wrap; /* Mantém quebras de linha */
            text-align: justify;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #d1d5db;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media print {
            body { background: none; padding: 0; }
            .card { box-shadow: none; border: none; width: 100%; height: 100%; margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="position: fixed; top: 20px; right: 20px;">
        <button onclick="window.print()" style="background: #000; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; font-weight: bold;">
            IMPRIMIR
        </button>
    </div>

    <div class="card">
        <div class="header">
            <h1>{{ $title }}</h1>
            <div class="date">{{ $list->event_date ? $list->event_date->format('d.m.Y') : 'Data Especial' }}</div>
        </div>

        <div class="content">
            {{ $content ?? 'Nenhum voto escrito ainda.' }}
        </div>

        <div class="footer">
            {{ $list->display_name }}
        </div>
    </div>

</body>
</html>
