<?php

namespace App\Http\Controllers;

use App\No;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoController extends Controller
{
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
    				if(count($result) > 1)
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
}