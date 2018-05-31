<?php

namespace App\Http\Controllers;

use App\Contato;
use App\Mensagem;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
    }

    public function novoContato(Request $req){
        $error = $req->validate([
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

        $contato = Contato::create($req->all());
        if($contato->id){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $contato->id
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
            ], 201
        );
    }

    public function listaMensagem($idContato){
        $contato = Contato::find($idContato);
        if($contato->id) {
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
        $error = $req->validate([
            'contato_id' => 'required',
            'mensagem' => 'required'
        ]);

        if($error){
            $response = response()->json(
                [
                    'response' => [
                        'mensagem' => $error
                    ]
                ], 201
            );

            return $response;
        }

        $mensagem = Mensagem::create($req->all());
        if($mensagem->id){
            $response = response()->json(
                [
                    'response' => [
                        'contato' => $mensagem->id
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
