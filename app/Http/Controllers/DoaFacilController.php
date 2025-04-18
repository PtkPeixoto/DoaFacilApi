<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donation;
use App\Models\DonationImage;
use App\Models\Rescue;
use App\Models\User;
use Illuminate\Http\Request;

class DoaFacilController extends Controller
{
    public function createUser(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'user_type' => 'required|string|in:user,company,admin',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'address' => 'required|string',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipCode' => 'required|string',
        ]);

        // Validação adicional para campos específicos do tipo "company"
        if ($request->user_type === 'company') {
            $validatedData += $request->validate([
                'CNPJ' => 'required|string',
                'fantasyName' => 'required|string',
                'companyName' => 'required|string',
            ]);
        }


        // Criação do usuário
        $user = new User();
        $user->user_type = $validatedData['user_type'];
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->phone = $validatedData['phone'];
        $user->address = $validatedData['address'];
        $user->neighborhood = $validatedData['neighborhood'];
        $user->city = $validatedData['city'];
        $user->state = $validatedData['state'];
        $user->zipCode = $validatedData['zipCode'];
        $user->cnpj = $validatedData['CNPJ'] ?? null;
        $user->fantasyName = $validatedData['fantasyName'] ?? null;
        $user->companyName = $validatedData['companyName'] ?? null;
        $user->save();

        return response()->json(['message' => 'Usuário registrado com sucesso!'], 201);
    }

    public function getUsers(Request $request)
    {
        $user = User::get();
        if ($user->isEmpty()) {
            return response()->json(['message' => 'Nenhum usuário encontrado!'], 201);
        }
        return response()->json($user);
    }

    public function getUserById($id)
    {
        // Recuperação do usuário por ID
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        }

        return response()->json($user);
    }

    public function getUserByType($type)
    {
        // Validação do tipo de usuário
        if (!in_array($type, ['user', 'company', 'admin'])) {
            return response()->json(['message' => 'Tipo de usuário inválido!'], 400);
        }

        // Recuperação do usuário por tipo
        $user = User::where('user_type', $type)->get();
        if ($user->isEmpty()) {
            return response()->json(['message' => 'Nenhum usuário encontrado!'], 201);
        }

        return response()->json($user);
    }

    public function validateUser(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Verificação do usuário
        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !password_verify($validatedData['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas!'], 401);
        }

        return response()->json(['message' => 'Usuário autenticado com sucesso!']);
    }

    public function updateUser(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email',
            'password' => 'string|min:8|confirmed',
            'phone' => 'string',
            'address' => 'string',
            'neighborhood' => 'string',
            'city' => 'string',
            'state' => 'string',
            'zipCode' => 'string',
            'CNPJ' => 'string',
            'fantasyName' => 'string',
            'companyName' => 'string',
        ]);

        // Atualização do usuário
        $user = User::find($request->user()->id);
        if ($user) {
            $user->update($validatedData);
        }

        return response()->json(['message' => 'Usuário atualizado com sucesso!']);
    }

    public function deleteUser(Request $request)
    {
        // Exclusão do usuário
        $user = User::find($request->user()->id);
        if ($user) {
            $user->delete();
        }

        return response()->json(['message' => 'Usuário excluído com sucesso!']);
    }

    public function donations(Request $request)
    {
        $donations = Donation::where('status', 'active')->get();
        if ($donations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma doação encontrada!'], 201);
        }
        return response()->json($donations);
    }

    public function getDonationById($id)
    {
        // Recuperação da doação por ID
        $donation = Donation::find($id);
        if (!$donation) {
            return response()->json(['message' => 'Doação não encontrada!'], 404);
        }

        return response()->json($donation);
    }

    public function createDonation(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'user_id' => 'required|numeric',
            'category_id' => 'numeric',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'numeric',
            'status' => 'string',
        ]);

        // Criação da doação
        $donation = new Donation();
        $donation->name = $validatedData['name'];
        $donation->description = $validatedData['description'];
        $donation->quantity = $validatedData['quantity'] ?? 1;
        $donation->status = $validatedData['status'];
        $donation->save();

        return response()->json(['message' => 'Doação criada com sucesso!'], 201);
    }

    public function updateDonation(Request $request, $id)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'quantity' => 'numeric',
            'status' => 'string',
        ]);

        // Atualização da doação
        $donation = Donation::find($id);
        if ($donation) {
            $donation->update($validatedData);
        }

        return response()->json(['message' => 'Doação atualizada com sucesso!']);
    }

    public function deleteDonation($id)
    {
        // Exclusão da doação
        $donation = Donation::find($id);
        if ($donation) {
            $donation->delete();
        }

        return response()->json(['message' => 'Doação excluída com sucesso!']);
    }

    public function getDonationsByFilter($userId = false, $categoryId = false, $status = false)
    {
        // Validação dos dados recebidos
        if ($userId && !is_numeric($userId)) {
            return response()->json(['message' => 'ID do usuário inválido!'], 400);
        }

        if ($categoryId && !is_numeric($categoryId)) {
            return response()->json(['message' => 'ID da categoria inválido!'], 400);
        }

        if ($status && !in_array($status, ['active', 'inactive'])) {
            return response()->json(['message' => 'Status inválido!'], 400);
        }

        // Recuperação das doações filtradas
        $donations = Donation::query();

        if ($userId) {
            $donations->where('user_id', $userId);
        }

        if ($categoryId) {
            $donations->where('category_id', $categoryId);
        }

        if ($status) {
            $donations->where('status', $status);
        }

        $donations = $donations->get();

        if ($donations->isEmpty()) {
            return response()->json(['message' => 'Nenhuma doação encontrada!'], 404);
        }

        return response()->json($donations);
    }

    public function getRescues(Request $request)
    {
        $rescue = Rescue::get();
        if ($rescue->isEmpty()) {
            return response()->json(['message' => 'Nenhum resgate encontrado!'], 201);
        }

        return response()->json($rescue);
    }

    public function getRescueByFilter($id = false, $donation_id = false)
    {
        if ($id && !is_numeric($id)) {
            return response()->json(['message' => 'ID do resgate inválido!'], 400);
        }

        if ($donation_id && !is_numeric($donation_id)) {
            return response()->json(['message' => 'ID da doação inválido!'], 400);
        }

        $rescue = Rescue::query();
        if ($id) {
            $rescue->where('id', $id);
        }

        if ($donation_id) {
            $rescue->where('donation_id', $donation_id);
        }

        $rescue = $rescue->get();
        if ($rescue->isEmpty()) {
            return response()->json(['message' => 'Nenhum resgate encontrado!'], 404);
        }

        return response()->json($rescue);
    }

    public function createRescue(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'donation_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'rescued_quantity' => 'numeric',
        ]);

        // Criação do resgate
        $rescue = new Rescue();
        $rescue->donation_id = $validatedData['donation_id'];
        $rescue->user_id = $validatedData['user_id'];
        $rescue->rescued_quantity = $validatedData['rescued_quantity'] ?? 1;
        $rescue->rescue_date = now();
        $rescue->save();

        return response()->json(['message' => 'Resgate feito com sucesso!'], 201);
    }

    public function updateRescue(Request $request, $id)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'donation_id' => 'numeric',
            'user_id' => 'numeric',
            'rescued_quantity' => 'numeric',
        ]);

        // Atualização do resgate
        $rescue = Rescue::find($id);
        if ($rescue) {
            $rescue->update($validatedData);
        }

        return response()->json(['message' => 'Resgate atualizado com sucesso!']);
    }

    public function deleteRescue($id)
    {
        // Exclusão do resgate
        $rescue = Rescue::find($id);
        if ($rescue) {
            $rescue->delete();
        }

        return response()->json(['message' => 'Resgate excluído com sucesso!']);
    }

    public function createCategory(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string',
        ]);

        // Criação da categoria
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'] ?? null;
        $category->save();

        return response()->json(['message' => 'Categoria criada com sucesso!'], 201);
    }

    public function getCategories(Request $request)
    {
        $categories = Category::get();
        if ($categories->isEmpty()) {
            return response()->json(['message' => 'Nenhuma categoria encontrada!'], 201);
        }
        return response()->json($categories);
    }

    public function getCategoryById($id)
    {
        // Recuperação da categoria por ID
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada!'], 404);
        }

        return response()->json($category);
    }

    public function updateCategory(Request $request, $id)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
        ]);

        // Atualização da categoria
        $category = Category::find($id);
        if ($category) {
            $category->update($validatedData);
        }

        return response()->json(['message' => 'Categoria atualizada com sucesso!']);
    }

    public function deleteCategory($id)
    {
        // Exclusão da categoria
        $category = Category::find($id);
        if ($category) {
            $category->delete();
        }

        return response()->json(['message' => 'Categoria excluída com sucesso!']);
    }

    public function createDonationImage(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'donation_id' => 'required|numeric',
            'image_base64' => 'required|string',
        ]);

        // Criação da imagem da doação
        $donationImage = new DonationImage();
        $donationImage->donation_id = $validatedData['donation_id'];
        $donationImage->image_base64 = $validatedData['image_base64'];
        $donationImage->save();

        return response()->json(['message' => 'Imagem da doação criada com sucesso!'], 201);
    }

    public function getDonationImages(Request $request)
    {
        $donationImages = DonationImage::get();
        if ($donationImages->isEmpty()) {
            return response()->json(['message' => 'Nenhuma imagem de doação encontrada!'], 201);
        }
        return response()->json($donationImages);
    }

    public function getDonationImageById($id)
    {
        // Recuperação da imagem da doação por ID
        $donationImage = DonationImage::find($id);
        if (!$donationImage) {
            return response()->json(['message' => 'Imagem da doação não encontrada!'], 404);
        }

        return response()->json($donationImage);
    }

    public function updateDonationImage(Request $request, $id)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'donation_id' => 'numeric',
            'image_base64' => 'string',
        ]);

        // Atualização da imagem da doação
        $donationImage = DonationImage::find($id);
        if ($donationImage) {
            $donationImage->update($validatedData);
        }

        return response()->json(['message' => 'Imagem da doação atualizada com sucesso!']);
    }

    public function deleteDonationImage($id)
    {
        // Exclusão da imagem da doação
        $donationImage = DonationImage::find($id);
        if ($donationImage) {
            $donationImage->delete();
        }

        return response()->json(['message' => 'Imagem da doação excluída com sucesso!']);
    }
}
