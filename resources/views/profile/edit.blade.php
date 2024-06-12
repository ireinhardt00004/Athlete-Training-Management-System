@extends('layouts.coach')
@section('content')
<style>
      .edit {
        font-size: 20px;
        font-family:   sans-serif;
        color: black;
    }
    .edit input {
        color: black;
    }
     .edit label {
        color: black;
        font-weight: bold;
    }
     .edit button {
       width: 180px;
    }
</style>
    <div class="edit">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('title','Settings')
