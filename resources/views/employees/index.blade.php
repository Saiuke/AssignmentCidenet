@extends('layouts.app')
@section('content')
    <nav class="navbar">
        <form class="container-fluid justify-content-start px-0">
            <button class="btn btn-outline-success me-2"
                    data-bs-toggle="modal"
                    data-bs-target="#modalWrapper"
                    data-content-source="{!! route('employees.create') !!}"
                    type="button"><i class="bi bi-person-plus-fill"></i>&nbsp; {{ __('general.new') }}
            </button>
        </form>
    </nav>
    <div class="mt-3 ">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="employeesTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Middle name</th>
                            <th>Last name</th>
                            <th>Other name</th>
                            <th>Work country</th>
                            <th>Document type</th>
                            <th>Document number</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @csrf
    @php $route = 'employees.getData'; @endphp
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            $('#employeesTable').DataTable({
                "processing": true,
                "order": [[0, "desc"]],
                responsive: true,
                "serverSide": true,
                ajax: "{{route($route)}}",
                // "sAjaxDataProp": "",
                columns: [
                    {"data": "id"},
                    {"data": "first_name"},
                    {"data": "middle_name"},
                    {"data": "last_name"},
                    {"data": "other_name"},
                    {"data": "work_country"},
                    {"data": "document_type"},
                    {"data": "document_number"},
                    {"data": "email"},
                    {"data": "status"},
                    {
                        "data": "id",
                        title: '{{ __('general.options') }}',
                        wrap: true,
                        "render": function (data, type, row, meta) {
                            return `
                                <div class="btn-group me-2" role="group" id="action-buttons">
                                   <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalWrapper"
                                        data-content-source="/employees/${row['id']}/edit">
                                        <i class="fas fa-user-edit"></i>
                                   </button>
                                   <button class="btn btn-sm btn-danger delete-entry"
                                        data-action-route="/employees/${row['id']}"
                                        data-entry-id="${row['id']}">
                                        <i class="fas fa-trash-alt"></i>
                                   </button>
                               </div>
                            `;
                        }
                    }
                ],
            });

            /*
            * Delete elements
            * */

            $("body").on("click", ".delete-entry", (event) => {
                let clickedButton = event.currentTarget;
                let callURL = clickedButton.getAttribute('data-action-route');
                let entryId = clickedButton.getAttribute('data-entry-id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover the data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: callURL,
                            data: {
                                "_token": $("meta[name='csrf-token']").attr("content"),
                                id: entryId
                            },
                            method: 'DELETE',
                            success: () => {
                                swal("The data has been deleted!", {
                                    icon: "success",
                                });
                                $('#employeesTable').DataTable().ajax.reload();
                            },
                            error: () => {
                                swal("There was an error deleting the data. Please try again!", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
