@extends('layouts.app')

@section('content')

    @include('components.body')
    @include('components.modal-login', ['mostrarModal' => $mostrarModal ?? false])

@endsection