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
            return $this->returnJson('contato',$obContato->errors(),201);
        }
        $obContato->fill($dados);
        $obContato->save();

        if($obContato->id){
            return $this->returnJson('contato',$obContato->id,200);
        }
        return $this->returnJson('contato',false,200);
    }

    public function atualizaContato(){
        $dados = Input::all();
        $obContato = new Contato();

        if(!$obContato->validate($dados)){
            return $this->returnJson('contato',$obContato->errors(),201);
        }

        if(isset($dados['id'])) {
            $obNewUser = $obContato->find($dados['id']);
            if ($obNewUser) {
                $obNewUser->fill($dados);
                $obNewUser->update($dados);
                return $this->returnJson('contato',true,200);
            }
        }

        return $this->returnJson('contato',false,200);
    }

    public function atualizaMensagem(){
        $dados = Input::all();
        $obMensagem = new Mensagem();

        if(!$obMensagem->validate($dados)){
            $response = response()->json(
                [
                    'response' => [
                        'mensagem' => $obMensagem->errors()
                    ]
                ], 201
            );
            return $response;
        }

        if(isset($dados['id'])) {
            $obNewMsg = $obMensagem->find($dados['id']);
            if ($obNewMsg) {
                $obNewMsg->fill($dados);
                $obNewMsg->update($dados);

                return $this->returnJson('mensagem',true,200);
            }
        }

        return $this->returnJson('mensagem',false,200);
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
            return $this->returnJson('contato',$return,201);

        }
        return $this->returnJson('contato',false,200);
    }

    public function listaMensagem($idContato){
        $contato = Contato::find($idContato);
        if(isset($contato->id)) {
            if (count($contato->mensagens)) {
                $return = array();
                foreach ($contato->mensagens as $mensagem) {
                    $return['mensagens'][] = $mensagem->mensagem;
                }
                return $this->returnJson('mensagem',$return,201);
            }
        }
        return $this->returnJson('mensagem',false,200);
    }

    public function novaMensagem(Request $req){
        $dados = Input::all();
        $obMensagem = new Mensagem();

        if(!$obMensagem->validate($dados)){
            return $this->returnJson('mensagem',$obMensagem->errors(),201);
        }
        $obMensagem->fill($dados);
        $obMensagem->save();
        if($obMensagem->id){
            return $this->returnJson('mensagem',$obMensagem->id,200);
        }
        return $this->returnJson('mensagem',false,200);
    }

    public function apagaContato($idContato){
        $delete = Contato::where('id', $idContato)->delete();

        if($delete){
            return $this->returnJson('contato',true,200);
        }
        return $this->returnJson('contato',false,200);
    }

    public function apagaMensagem($idMensagem){
        $delete = Mensagem::where('id', $idMensagem)->delete();

        if($delete) {
            return $this->returnJson('mensagem',true,200);
        }
        return $this->returnJson('mensagem',false,200);
    }

    public function returnJson($key, $value, $statuscode){
        return $response = response()->json(
            [
                'response' => [
                    $key => $value
                ]
            ], $statuscode
        );
    }


}
