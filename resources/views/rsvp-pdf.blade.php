<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lista de Convidados</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #374151;
            line-height: 1.4;
        }

        /* Cabeçalho */
        .header {
            text-align: center;
            margin-bottom: 24px;
        }

        .header h1 {
            color: #047857;
            font-size: 22px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 10px;
            color: #6b7280;
        }

        /* Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th {
            background-color: #f3f4f6;
            color: #374151;
            text-align: left;
            padding: 8px;
            font-size: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        /* Status */
        .status-confirmado {
            color: #059669;
            font-weight: bold;
        }

        .status-pendente {
            color: #d97706;
            font-weight: bold;
        }

        /* Resumo */
        .summary {
            background-color: #ecfdf5;
            border: 1px solid #d1fae5;
            border-radius: 6px;
            padding: 14px;
            page-break-inside: avoid;
        }

        .summary h3 {
            margin: 0 0 8px 0;
            color: #065f46;
            font-size: 14px;
        }

        .summary p {
            margin: 0;
            font-size: 12px;
        }

        .summary strong {
            color: #047857;
        }

        /* Rodapé */
        .footer {
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            margin-top: 24px;
        }
    </style>
</head>

<body>

    {{-- Cabeçalho --}}
    <div class="header">
        <h1>{{ $list->display_name }}</h1>
        <p>
            Relatório de Convidados • Gerado em {{ date('d/m/Y \à\s H:i') }}
        </p>
    </div>

    {{-- Tabela --}}
    <table>
        <thead>
            <tr>
                <th width="40%">Convidado</th>
                <th width="15%" class="text-center">Status</th>
                <th width="10%" class="text-center">Adultos</th>
                <th width="10%" class="text-center">Crianças</th>
                <th width="25%">Contato</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rsvps as $rsvp)
                <tr>
                    <td>{{ $rsvp->guest_name }}</td>
                    <td class="text-center">
                        <span class="{{ $rsvp->status === 'Confirmado' ? 'status-confirmado' : 'status-pendente' }}">
                            {{ $rsvp->status }}
                        </span>
                    </td>
                    <td class="text-center">{{ $rsvp->adults }}</td>
                    <td class="text-center">{{ $rsvp->children }}</td>
                    <td>{{ $rsvp->contact ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Resumo --}}
    <div class="summary">
        <h3>Resumo Geral</h3>
        <p>
            Convites (grupos): <strong>{{ $rsvps->count() }}</strong><br>
            Adultos: <strong>{{ $totalAdults }}</strong><br>
            Crianças: <strong>{{ $totalChildren }}</strong><br><br>
            <strong>Total de Pessoas: {{ $totalGuests }}</strong>
        </p>
    </div>

    {{-- Rodapé --}}
    <div class="footer">
        Pixlist • Relatório gerado automaticamente
    </div>

</body>
</html>
