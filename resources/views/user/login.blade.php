<x-layout>
    <div class="flex flex-col md:flex-row gap-4 min-h-[80vh] justify-center items-center p-4">
        <div class="text-center basis-1/2">
            <h1 class="text-4xl font-bold text-center ">Aplikasi Todolist laravel </h1>
            <p>By Arisandi Kader</p>

        </div>
        <div class="card bg-base-100 w-full mx-auto max-w-sm shrink-0 shadow-2xl">
            <form class="card-body" method="post" action="/login">
                @csrf

                {{-- success register message --}}

                @if(session('message'))
                   <div role="alert" class="inline-block alert alert-info rounded-xl text-center">{{ session('message') }}</div> 
                @else
                    
                @endif

                @error('message')
                    <div role="alert" class=" inline-block alert p-2 alert-error rounded-xl text-center">{{ $message }}</div>
                @enderror



                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" placeholder="email" class="input input-bordered" name="email"
                        value="{{ old('email') }}" />
                </div>
                {{-- error --}}
                @error('email')
                    <div role="alert" class=" inline-block alert p-2 alert-error rounded-xl text-center">{{ $message }}</div>
                @enderror



                {{-- enderror --}}



                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" placeholder="password" class="input input-bordered" name="password" value="{{old('password')}}"/>
                </div>

                {{-- error --}}

                @error('password')
                    <div role="alert" class=" inline-block alert p-2 alert-error rounded-xl text-center">{{ $message }}</div>
                    
                @enderror


                {{-- enderror --}}


                <div class="form-control mt-6">
                    <button class="btn btn-primary">Login</button>
                </div>
                <a href="/register" class="link link-hover label-text text-center">Belum punya Akun ? Daftar Disini</a>
            </form>
        </div>
    </div>
</x-layout>
