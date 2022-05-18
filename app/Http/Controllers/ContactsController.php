<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\ContactEmails;
use App\Models\ContactPhones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contatos.index')->with('contatos', Contacts::all());
    }

    public function search(Request $request)
    {
        $contatos = Contacts::where('nome', 'like', '%' . $request->busca . '%')->orWhere('email', 'like', '%' . $request->busca . '%')->get();
        $busca = 'Exibindo resultados para ' . $request->busca;
        return view('contatos.index')->with(['contatos' => $contatos, 'busca' => $busca]);
    }

    public function create()
    {
        return view('contatos.new');
    }

    public function store(Request $request)
    {
        //dd($request);
        $cpf = '';
        $request->telefone = str_replace("(", "", $request->telefone);
        $request->telefone = str_replace(")", "", $request->telefone);
        $request->telefone = str_replace("-", "", $request->telefone);
        $request->telefone = str_replace(" ", "", $request->telefone);

        if ($request->cpf !== null) {
            $cpf = $this->validar_cpf($request->cpf);
            $request->cpf = str_replace(".", "", $request->cpf);
            $request->cpf = str_replace("-", "", $request->cpf);
        }

        if (strlen($request->nome) > 1 && strlen($request->sobrenome) > 3 && strlen($request->telefone) <= 11) {
            try {
                $contato = new Contacts();
                $contato->nome = $request->nome;
                $contato->sobrenome = $request->sobrenome;
                if ($request->cpf !== null) {
                    if ($cpf == true) {
                        $contato->cpf = $request->cpf;
                    } else {
                        session()->flash('error', 'O cpf informado é inválido');
                        return redirect()->back();
                    }
                } else {
                    $contato->cpf = '';
                }
                $contato->email = $request->email !== null ? $request->email : '';
                $contato->phone = $request->telefone;
                $contato->save();
                session()->flash('success', 'O contato foi cadastrado com sucesso!');
                return redirect(route('contacts.index'));
            } catch (\Exception $e) {
                session()->flash('error', 'Erro ao inserir contato. Por favor, tente novamente');
                return redirect(route('contacts.index'));
            }
        } else {
            session()->flash('error', 'Revise os dados informados');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $contact = Contacts::find($id);
        $emails = ContactEmails::where('contact_id', $id)->get();
        $phones = ContactPhones::where('contact_id', $id)->get();
        return view('contatos.show')->with(['contato' => $contact, 'emails' => $emails, 'phones' => $phones]);
    }

    public function edit($id)
    {
        $contact = Contacts::find($id);
        $telefone = ContactPhones::where('id', $contact->id)->get();
        return view('contatos.edit')->with(['contact' => $contact, 'telefone' => $telefone]);
    }

    public function update(Request $request)
    {
        $contato = Contacts::find($request->id);

        $request->telefone = str_replace("(", "", $request->telefone);
        $request->telefone = str_replace(")", "", $request->telefone);
        $request->telefone = str_replace("-", "", $request->telefone);
        $request->telefone = str_replace(" ", "", $request->telefone);

        $cpf = '';
        if ($request->cpf !== null) {
            $cpf = $this->validar_cpf($request->cpf);
            $request->cpf = str_replace(".", "", $request->cpf);
            $request->cpf = str_replace("-", "", $request->cpf);
        }

        if (strlen($request->nome) > 1 && strlen($request->sobrenome) > 3 && strlen($request->telefone) <= 11) {
            try {
                $contato->nome = $request->nome;
                $contato->sobrenome = $request->sobrenome;
                if ($request->cpf !== null) {
                    if ($cpf == true) {
                        $contato->cpf = $request->cpf;
                    } else {
                        session()->flash('error', 'O cpf informado é inválido');
                        return redirect()->back();
                    }
                } else {
                    $contato->cpf = '';
                }
                $contato->email = $request->email !== null ? $request->email : '';
                $contato->phone = $request->telefone;
                $contato->save();
                session()->flash('success', 'O contato foi editado com sucesso!');
                return redirect(route('contacts.index'));
            } catch (\Exception $e) {
                session()->flash('error', 'Erro ao inserir contato. Por favor, tente novamente' . $e);
                return redirect(route('contacts.index'));
            }
        } else {
            session()->flash('error', 'Revise os dados informados');
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        $contact = Contacts::find($request->id_contato);
        $contact->delete();
        session()->flash('success', 'O contato foi apagado com sucesso!');
        return redirect(route('contacts.index'));
    }

    public function validar_cpf($cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function add_phone(Request $request)
    {
        $request->telefone = str_replace("(", "", $request->telefone);
        $request->telefone = str_replace(")", "", $request->telefone);
        $request->telefone = str_replace("-", "", $request->telefone);
        $telefone = ContactPhones::create([
            'contact_id' => $request->id,
            'phone' => $request->telefone
        ]);
        session()->flash('success', 'Telefone adicionado com sucesso!');
        return redirect()->back();
    }

    public function add_email(Request $request)
    {
        $telefone = ContactEmails::create([
            'contact_id' => $request->id,
            'email' => $request->email
        ]);
        session()->flash('success', 'Email adicionado com sucesso!');
        return redirect()->back();
    }

    public function delete_phone(Request $request)
    {
        $phone = ContactPhones::find($request->id_contato);
        $phone->delete();
        session()->flash('success', 'O telefone foi apagado com sucesso!');
        return redirect(route('contacts.index'));
    }

    public function delete_email(Request $request)
    {
        $email = ContactEmails::find($request->id_contato);
        $email->delete();
        session()->flash('success', 'O email foi apagado com sucesso!');
        return redirect(route('contacts.index'));
    }
}
