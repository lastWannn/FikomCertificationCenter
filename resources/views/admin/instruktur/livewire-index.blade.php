@extends('layouts.admin')
@section('title','Manajemen Instruktur')
@section('page-title','Manajemen Instruktur')
@section('page-content')
{{-- Livewire InstrukturManager diembed di sini (bukan full-page component) --}}
<livewire:admin.instruktur-manager />
@endsection
