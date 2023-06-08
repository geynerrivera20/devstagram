@extends('layouts.app')

@section('titulo')
    Pagina principal
@endsection

@section('contenido')

<x-listar-post :posts="$posts" />


    {{--     @forelse ($posts as $post)
        <h1>Si hay publicaciones</h1>
    @empty
        <h1>No hay publicaciones</h1>
    @endforelse --}}

@endsection
