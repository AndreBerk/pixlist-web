<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lista de Convidados</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #047857; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; font-size: 10px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f3f4f6; text-align: left; padding: 8px; border-bottom: 2px solid #ddd; font-weight: bold; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #eee; }

        .text-center { text-align: center; }

        .status-confirmado { color: #059669; font-weight: bold; }
        .status-pendente { color: #d97706; }

        .summary-box { background-color: #ecfdf5; border: 1px solid #d1fae5; padding: 10px; border-radius: 5px; margin-top: 20px; page-break-inside: avoid; }
        .summary-title { font-weight: bold; color: #065f46; margin-bottom: 5px; font-size: 14px; }
    </style>
</head>
<body>

    <h1>{{ $list->display_name }}</h1>
    <p class="subtitle">Relatório de Lista de Convidados - Gerado em {{ date('d/m/Y \à\s H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="40%">Nome do Convidado</th>
                <th width="15%" class="text-center">Status</th>
                <th width="10%" class="text-center">Adultos</th>
                <th width="10%" class="text-center">Crianças</th>
                <th width="25%">Contato</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rsvps as $rsvp)
                <tr>
                    <td>{{ $rsvp->guest_name }}</td>
                    <td class="text-center">
                        <span class="{{ $rsvp->status == 'Confirmado' ? 'status-confirmado' : 'status-pendente' }}">
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

    <div class="summary-box">
        <div class="summary-title">Resumo Total</div>
        <p>
            Convites (Grupos): <strong>{{ $rsvps->count() }}</strong><br>
            Adultos: <strong>{{ $totalAdults }}</strong><br>
            Crianças: <strong>{{ $totalChildren }}</strong><br>
            <span style="font-size: 14px; color: #047857;">Total de Pessoas: <strong>{{ $totalGuests }}</strong></span>
        </p>
    </div>

</body>
</html>
