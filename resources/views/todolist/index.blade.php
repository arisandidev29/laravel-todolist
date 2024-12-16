<x-layout>
    <div class="p-4 max-w-6xl mx-auto">

        <div class="flex justify-between items-center gap-4">
            <a href="/logout">
                <button class="btn btn-error text-white">Logout</button>
            </a>
            <p class="text-bold">hello {{ auth()->user()->name }}</p>
        </div>
        <div class="flex flex-col sm:flex-row items-center  my-4">


            <div class="text-center basis-1/2 my-8">
                <h1 class="text-5xl text-bold">Todolist App</h1>
                <p>By Arisandi kader</p>
            </div>
            <form action="/todolist" method="post" class="max-w-sm bg-base-200 p-4">
                @csrf
                <h2 class="text-center text-bold">Create New Todo</h2>
                <label class="input input-bordered flex items-center gap-2 my-3">
                    Todo
                    <input name="todo" type="text" class="grow" placeholder="Todo" />
                </label>
                @error('todo')
                    <div class="alert alert-error p-2 my-4">{{ $message }}</div>
                @enderror

                <div class="form-control">
                    <button class="btn btn-primary">Add Todo</button>
                </div>
            </form>
            <div>
            </div>

            {{-- toast --}}
            @if (session('message'))
                <div class="toast toast-end toast-top">
                    <div class="alert alert-info ">
                        <span>{{ session('message') }}</span>
                    </div>
                </div>
            @endif

        </div>
        <div class="mt-12">
            <div class="overflow-x-auto">
                <table class="table table-auto">
                    <!-- head -->
                    <thead>
                        <tr class="bg-red-500 text-white">
                            <th>no</th>
                            <th>title</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($todolist as $todo)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $todo['todo'] }}</td>
                                <td class="flex justify-center gap-2">
                                    <button class="btn btn-info btn-sm sm:btn-md text-white"
                                        onclick="modal_edit_{{ $todo['id'] }}.showModal()">Edit</button>
                                    <button class="btn btn-error btn-sm md:btn-md text-white"
                                        onclick="my_modal_{{ $todo['id'] }}.showModal()">delete</button>
                                </td>
                            </tr>

                            {{-- modal delete --}}
                            <dialog id="my_modal_{{ $todo['id'] }}" class="modal">
                                <div class="modal-box bg-red-500 text-white">
                                    <h3 class="text-lg font-bold">Warning !!</h3>
                                    <p class="py-4">Are you sure delete this todo ?</p>
                                    <div class="modal-action">
                                        <form method="post" action="/todolist/{{ $todo['id'] }}/delete">
                                            @csrf
                                            <input type="submit" class="btn  btn-warning" value="Yes">
                                            <button type="button" class="btn btn-info" onclick="my_modal_{{$todo['id']}}.close()">Close</button>

                                        </form>
                                    </div>
                                </div>
                            </dialog>

                            {{-- modal edit --}}

                            <!-- Open the modal using ID.showModal() method -->
                            {{-- <button class="btn" onclick="modal_edit_{{$todo['id']}}.showModal()">open modal</button> --}}
                            <dialog id="modal_edit_{{$todo['id']}}" class="modal">
                                <div class="modal-box">
                                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="modal_edit_{{$todo['id']}}.close()">✕</button>
                                        <h1 class="text-xl text-bold my-2">Edit todo</h1>
                                        <form action="/todolist/{{$todo['id']}}/edit" method="post">
                                            @csrf
                                            <input name="todo" type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" value="{{$todo['todo']}}" />
                                            <input type="submit" value="change" class="btn btn-primary">
                                        </form>
                                </div>
                            </dialog>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const toast = document.querySelector('.toast') ?? null;

        if (toast) {
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    </script>
</x-layout>
