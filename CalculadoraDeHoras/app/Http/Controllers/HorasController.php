<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HorasController extends Controller
{
    public function calculaHoras(Request $request)
    {
        $inicio = $request->input('inicio');
        $final = $request->input('final');

        $inicioStamp = strtotime($inicio);
        $finalStamp = strtotime($final);

        if ($finalStamp < $inicioStamp) {
            $finalStamp += 86400;
        }

        $horasDiurnas = 0;
        $horasNoturnas = 0;

        $horaAtual = $inicioStamp;

        while ($horaAtual < $finalStamp) {
            $horaAtualMais1Minuto = $horaAtual + 60;

            if (date('H:i', $horaAtual) >= '22:00' || date('H:i', $horaAtualMais1Minuto) <= '05:00') {
                if ($horaAtualMais1Minuto <= $finalStamp) {
                    $horasNoturnas += 1;
                } else {
                    $horasNoturnas += (int) (($finalStamp - $horaAtual) / 60);
                }
            } else {
                if ($horaAtualMais1Minuto <= $finalStamp) {
                    $horasDiurnas += 1;
                } else {
                    $horasDiurnas += (int) (($finalStamp - $horaAtual) / 60);
                }
            }

            $horaAtual = $horaAtualMais1Minuto;
        }

        $horasDiurnas = date('H:i', mktime(0, $horasDiurnas));
        $horasNoturnas = date('H:i', mktime(0, $horasNoturnas));

        return response()->json([
            'horas_diurnas' => $horasDiurnas,
            'horas_noturnas' => $horasNoturnas,
        ]);
    }
}
