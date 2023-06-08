<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    //Proteger la ruta, debe de estar autenticado para poder utilizar el controlador
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        //Hacer el Reto propuesto por el curso:
        // 1- Modificar el correo
        // 2- Modificar la contraseña con verificación

         $request->request->add(['username'=>Str::slug($request->username)]);


        $this->validate($request,[
            'username'=>['required','unique:users,username,'.auth()->user()->id,'min:3,','max:20','not_in:twitter,editar-perfil'],
        ]); 

         if($request->imagen){

            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid().".".$imagen->extension();
    
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);
    
            $imagenPath = public_path('perfiles').'/'.$nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar Cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index',$usuario->username);  
    }
}
