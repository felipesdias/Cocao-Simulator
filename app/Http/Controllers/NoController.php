<?php

namespace App\Http\Controllers;

use App\No;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoController extends Controller
{
    public function calcPer($valor) {
        return number_format(($valor*100)/270000, 2, '.', '');
    }

    public function relatorio() {
        $relatorio = [];
        $apelido = '';
        $porcent = [];

        $atual = [];
        $id = 1;
        while(true && $id != 0) {
            $no = No::find($id);
            $best = -1;
            $letra = '';
            $aux = '';
            for($c = 97; $c < 123; $c += 1) {
                $r = explode(";", $no[chr($c)]);
                $atual[chr($c)] = [intval($r[0]), intval($r[1])];
                
                $aux = $aux."   ".chr($c)." = ".$this->calcPer(intval($r[0]));
                if(intval($r[0]) > $best) {
                    $best = intval($r[0]);
                    $letra = chr($c);
                    $id = intval($r[1]);
                }
            }
            $apelido = $apelido.$letra;
            array_push($relatorio, $aux);
            array_push($porcent, $this->calcPer($best));

            if($letra == "{")
                break;
        }

        return response()->success(compact('relatorio', 'apelido', 'porcent'));
    }

    public function geraApelido() {
    	$id = 1;
    	$apelido = "";
    	$ids = [];
    	$aux = true;

    	while(strlen($apelido) < 7 && $aux) {
    		array_push($ids, $id);
    		$no = No::find($id);
    		$chute = rand(0,270000);
    		$total = 0;
    		$aux = false;

    		for($c = 97; $c < 123; $c += 1) {
    			$result = explode(";", $no[chr($c)]);
    			$qt = intval($result[0]);

    			$total += $qt;

    			if($chute < $total) {
    				$apelido = $apelido.chr($c);
    				if($result[1] != "")
	    				$id = intval($result[1]);
	    			else {
	    				$novo = No::create()->id;
	    				No::where("id", $id)->update([chr($c) => $qt.";".strval($novo)]);
	    				$id = $novo;
	    			}
	    			$aux = true;
	    			break;
	    		}
    		}
    	}
    	return response()->success(compact('apelido', 'ids'));
    }

    public function avalia(Request $request) {
        $apelido = $request->apelido;
        $ids = $request->ids;
        $tam = count($ids);
        $porcent = $request->valor/100;

        for($i = 0; $i < $tam; $i++) {
            if($i == $tam-1)
                $letra = "{";
            else
                $letra = $apelido[$i];


            $no = No::find($ids[$i]);
            $divideP = explode(";", $no[$letra]);
            
            if($porcent < 0)
                $total = floor((intval($divideP[0])*$porcent*3)/26)*-1;
            else
                $total = 0;


            for($c = 97; $c < 124; $c += 1) {
                if(chr($c) != $letra) {
                    $divide = explode(";", $no[chr($c)]);

                    if($porcent < 0){
                        $no[chr($c)] = (intval($divide[0])+$total).";".$divide[1];
                    } else {
                        $val = floor(intval($divide[0])*$porcent);
                        $total += abs($val);
                        $no[chr($c)] = (intval($divide[0])-$val).";".$divide[1];
                    }
                }
            }

            if($porcent < 0) {
                $no[$letra] = (intval($divideP[0])-$total*26).";".$divideP[1];
                $no->save();
            } else {
                $no[$letra] = (intval($divideP[0])+$total).";".$divideP[1];
                $no->save();
            }
        }


        return $this->geraApelido();
    }
}