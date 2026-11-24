@extends('layouts.app')

@section('title', 'Masuk')
@section('body-class', 'bg-[#EFF6FF]')

@section('content')
    <div class="mx-auto max-w-md px-4 py-10 sm:px-6 sm:py-16">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 sm:p-8">
            <div class="mb-7 text-center">
                <img src="{{ asset('images/owl-logo.svg') }}" alt="" aria-hidden="true" width="48" height="48" class="mx-auto size-12 rounded-2xl bg-amber-50 p-1 shadow-lg shadow-amber-900/10">
                <h1 class="mt-5 text-2xl font-bold tracking-tight text-slate-950">Selamat datang kembali</h1>
                <p class="mt-2 text-sm text-slate-600">Masuk Untuk Mengakses Manajemen Barang</p>
            </div>

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus autocomplete="email"
                           class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Kata sandi</label>
                    <input id="password" type="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="current-password"
                           class="h-11 w-full rounded-lg border border-slate-300 px-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>
                <flux:button type="submit" variant="primary" class="w-full">Masuk</flux:button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-700 hover:text-indigo-900">Daftar sekarang</a>
            </p>
        </div>
    </div>
@endsection
