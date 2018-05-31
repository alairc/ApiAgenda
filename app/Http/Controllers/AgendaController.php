<?php

namespace App\Http\Controllers;

use App\Contato;
use App\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    public function novoContato(){
        $dados = Input::all();
        $obContato = new Contato();

        if(!$obContato->validate($dados)){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $obContato->errors()
                    ]
                ], 201
            );
            return $response;
        }
        $obContato->fill($dados);
        $obContato->save();

        if($obContato->id){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $obContato->id
                    ]
                ], 201
            );

            return $response;
        }
        return $response = response()->json(
            [
                'response' => [
                    'contato' => false
                ]
            ], 201
        );
    }

    public function atualizaContato(Request $req){
        $error = $req->validate([
            'id' => 'required',
            'nome' => 'required|min:3|max:30',
            'sobrenome' => 'required|min:2|max:100',
            'email' => 'required|min:5|max:100|unique:contatos,email',
            'telefone' => 'required'
        ]);

        if($error){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $error
                    ]
                ], 201
            );

            return $response;
        }

        $contato = Contato::updated($req->all());
        if($contato->id){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => true
                    ]
                ], 201
            );

            return $response;
        }
        return $response = response()->json(
            [
                'response' => [
                    'contato' => false
                ]
            ], 201
        );
    }

    public function listaContato(){
        header('Access-Control-Allow-Origin: *');
        $contatos = Contato::all();

        if($contatos->count()){
            $return = array();
            $c=0;
            foreach ($contatos as $contato){
                $return[$c]['id'] = $contato->id;
                $return[$c]['nome'] = $contato->nome;
                $return[$c]['sobrenome'] = $contato->sobrenome;
                $return[$c]['email'] = $contato->email;
                $return[$c]['telefone'] = $contato->teleofne;
                $c++;
            }

            $response = response()->json(
                [
                    'response' => [
                        'contatos' => $return
                    ]
                ], 201
            );

            return $response;
        }
        return $response = response()->json(
            [
                'response' => [
                    'contatos' => false
                ]
            ], 200
        );
    }

    public function listaMensagem($idContato){
        $contato = Contato::find($idContato);
        if(isset($contato->id)) {
            if (count($contato->mensagens)) {
                $return = array();
                foreach ($contato->mensagens as $mensagem) {
                    $return['mensagens'][] = $mensagem->mensagem;
                }
                $response = response()->json(
                    [
                        'response' => [
                            'contato' => $return
                        ]
                    ], 201
                );

                return $response;
            }
        }
        return $response = response()->json(
            [
                'response' => [
                    'contato' => false
                ]
            ], 201
        );
    }

    public function novaMensagem(Request $req){
        $dados = Input::all();
        $obMensagem = new Mensagem();

        if(!$obMensagem->validate($dados)){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $obMensagem->errors()
                    ]
                ], 201
            );
            return $response;
        }
        $obMensagem->fill($dados);
        $obMensagem->save();
        if($obMensagem->id){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $obMensagem->id
                    ]
                ], 201
            );

            return $response;
        }
        return $response = response()->json(
            [
                'response' => [
                    'contato' => false
                ]
            ], 201
        );
    }

    public function apagaContato($idContato){
        $delete = Contato::where('id', $idContato)->delete();

        if($delete){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => true
                    ]
                ], 201
            );

            return $response;
        }
    }

    public function apagaMensagem($idMensagem){
        $delete = Mensagem::where('id', $idMensagem)->delete();

        if($delete) {
            $response = response()->json(
                [
                    'response' => [
                        'mensagem' => true
                    ]
                ], 201
            );

            return $response;
        }
        return $response = response()->json(
            [
                'response' => [
                    'contato' => false
                ]
            ], 201
        );
    }

}
