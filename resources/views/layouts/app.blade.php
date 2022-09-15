<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TO DO APP</title>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    @vite(['resources/js/app.js'])
</head>

<body>

    <header class="py-3 bg-secondary">
        <div class="container mt-4 text-light d-flex flex-wrap justify-content-center">
            <h1>TO DO APP</h1>
        </div>
    </header>
    <main>
        <div class="container text-light mt-4 d-flex flex-wrap justify-content-center"">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#NewTask">
                Nueva Tarea
            </button>
        </div>

        <div class="container mt-4 d-flex flex-wrap justify-content-center">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="text-align:center;width: 25%">Tarea</th>
                        <th style="text-align:center;width: 25%">Estado</th>
                        <th style="text-align:center;width: 25%">Fecha</th>
                        <th style="text-align:center;width: 25%">Acciones</th>
                    </tr>
                </thead>
                <tbody style="text-align: left;">
                    @if (count($tasks) > 0)
                        @foreach ($tasks as $task)
                            <tr>
                                <td style="width: 25%">{{ $task->task }}</td>
                                <td style="width: 25%">{{ $task->status }}</td>
                                <td style="width: 25%">{{ $task->created_at }} </td>
                                <td style="text-align:center;width: 25%">
                                    <div class="container d-flex flex-wrap justify-content-center"">
                                        <button type="button" class="btn btn-primary editTaskb"
                                            style="width: 80px; margin-right:20px" data-bs-toggle="modal"
                                            data-bs-target="#editTask" data-ide="<?php echo $task->id; ?>"
                                            data-task="<?php echo $task->task; ?>" data-status="<?php echo $task->status; ?>">
                                            Editar
                                        </button>
                                        <form method="post" id="{{ $task->id }}"
                                            action="{{ route('deleteTask', ['id' => $task->id]) }}" id="deleteForm">
                                            @csrf
                                            {{ method_field('DELETE') }}

                                            <button type="button" class="btn btn-danger delete-button openDeleteModal"
                                                style="width: 80px" data-bs-toggle="modal" data-bs-target="#deleteTask"
                                                id='openDeleteModal' data-id="<?php echo $task->id; ?>">
                                                Eliminar
                                            </button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>


        <!-- NEW TASK -->
        <div class="modal fade" id="NewTask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Crar nueva Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('newTask') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="task" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="task" id="task" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select name="status" id="status" class="form-select form-select-ms"
                                    aria-label=".form-select-sm example">
                                    <option value="Pendiente" selected>Pendiente</option>
                                    <option value="En progreso">En progreso</option>
                                    <option value="Realizada">Realizada</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- EDIT TASK -->
        @if (count($tasks) > 0)
            <div class="modal fade" id="editTask" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Editar Tarea</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="taskeditt" action="{{ route('editTask') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input id="taskid" name="taskid" type="hidden">
                                <div class="mb-3">
                                    <label for="editTaskName" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="editTaskName" id="editTaskName"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Estado</label>
                                    <select name="editStatus" id="editStatus" class="form-select form-select-ms"
                                        aria-label=".form-select-sm example">
                                        <option value="Pendiente" selected>Pendiente</option>
                                        <option value="En progreso">En progreso</option>
                                        <option value="Realizada">Realizada</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <!-- DELETE TASK -->
        @if (count($tasks) > 0)
            <div class="modal fade " id="deleteTask" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Eliminar Tarea</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Esta seguro de eliminar la tarea?
                            <div class="container mt-4 d-flex flex-wrap justify-content-center">
                                <button type="button" data-id="" class="btn btn-danger m-4 confirm-delete"
                                    style="width: 60px">
                                    SI
                                </button>
                                <button type="button" class="btn btn-primary m-4" style="width: 60px"
                                    data-bs-dismiss="modal">NO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <footer class="footer fixed-bottom text-light mt-auto py-2 bg-secondary text-center">
        TO DO APP - Todos los derechos reservados
        {{ now()->year }} - By Marcos Schlusselblum
    </footer>

    <script>
        $('.delete-button').on('click', function(e) {
            var id = $(this).attr('data-id');
            $('.confirm-delete').attr('data-id', id);

        });
        $(".confirm-delete").on('click', function(e) {
            var id = $(this).attr('data-id');
            let form = document.getElementById(id);
            form.submit();
        });
    </script>

    <script>
        $('.editTaskb').on('click', function(e) {


            var datastatus = $(this).attr('data-status');
            var status_options = document.getElementById("editStatus").options;
            for (i = 0; i < status_options.length; i++) {
                var option_id = -1;
                if (status_options[i].value == datastatus) {
                    status_options[i].selected = true;
                }
            }
            $('#editStatus').attr('value', datastatus);
            var datatask = $(this).attr('data-task');
            $('#editTaskName').attr('value', datatask);
            var dataid = $(this).attr('data-ide');
            $('#taskid').attr('value', dataid);
        });
    </script>
</body>

</html>
