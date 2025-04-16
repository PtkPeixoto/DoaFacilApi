<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use App\Models\Users;
use Illuminate\Http\Request;

class DoaFacilController extends Controller
{
    public function register(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'address' => 'required|string',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipCode' => 'required|string',
            'CNPJ' => 'string',
            'fantasyName' => 'string',
            'companyName' => 'string',
        ]);

        // Criação do usuário
        $user = new Users();
        $user->name = $validatedData['nome'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->phone = $validatedData['phone'];
        $user->address = $validatedData['address'];
        $user->neighborhood = $validatedData['neighborhood'];
        $user->city = $validatedData['city'];
        $user->state = $validatedData['state'];
        $user->zipCode = $validatedData['zipCode'];
        $user->CNPJ = $validatedData['CNPJ'] ?? null;
        $user->fantasyName = $validatedData['fantasyName'] ?? null;
        $user->companyName = $validatedData['companyName'] ?? null;
        $user->save();

        return response()->json(['message' => 'Usuário registrado com sucesso!'], 201);
    }

    public function donations(Request $request)
    {
        $donations = Donations::where('status', 'active')->get();

        return response()->json($donations);
    }
}
