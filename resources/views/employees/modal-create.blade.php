<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-person-plus-fill"></i>&nbsp; New employee</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="alert alert-danger d-none" id="feedbackArea" role="alert">
        A simple danger alert—check it out!
    </div>
    <form method='POST' id='createEmployee'>
        @csrf

        @isset($employee->id)
            <input type="hidden" name="id" value="{{ $employee->id}}">
        @endisset

        <div class="row">
            <div class="mb-3 col-6">
                <label for="name" class="form-label">First Name</label>
                <input type="text" name="first_name" value="{{ $employee->first_name ?? '' }}" class="form-control text-uppercase" id="first_name" required
                       max="20" pattern="[A-Za-z]{1,20}">
            </div>
            <div class="mb-3 col-6">
                <label for="email" class="form-label">Other name</label>
                <input type="text" name="other_name" value="{{ $employee->first_name ?? '' }}" class="form-control text-uppercase" id="other_name" required
                       max="50" pattern="[A-Za-z]{1,50}">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-6">
                <label for="document" class="form-label">Middle name</label>
                <input type="text" name="middle_name" value="{{ $employee->middle_name ?? '' }}" class="form-control text-uppercase" id="middle_name" required
                       max="20" pattern="[A-Za-z]{1,20}">
            </div>
            <div class="mb-3 col-6">
                <label for="phone" class="form-label">Last name</label>
                <input type="tel" name="last_name" value="{{ $employee->last_name ?? '' }}" class="form-control text-uppercase" id="last_name" required max="20"
                       pattern="[A-Za-z]{1,20}">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-6">
                <label for="address" class="form-label">Document type</label>
                <select name="document_type" class="form-select" id="document_type" required>
                    <option value="Cédula de Ciudadanía" {{ (isset($employee->document_type) && $employee->document_type == 'Cédula de Ciudadanía') ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                    <option value="Cédula de Extranjería" {{ (isset($employee->document_type) && $employee->document_type == 'Cédula de Extranjería') ? 'selected' : '' }}>Cédula de Extranjería</option>
                    <option value="Pasaporte" {{ (isset($employee->document_type) && $employee->document_type == 'Pasaporte') ? 'selected' : '' }}>Pasaporte</option>
                    <option value="Permiso Especial" {{ (isset($employee->document_type) && $employee->document_type == 'Permiso Especial') ? 'selected' : '' }}>Permiso Especial</option>
                </select>
            </div>
            <div class="mb-3 col-6">
                <label for="address" class="form-label">Document number</label>
                <input type="text" name="document_number" value="{{ $employee->document_number ?? '' }}" class="form-control" id="document_number" required
                       pattern="[a-zA-Z0-9-]*">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-4">
                <label for="company" class="form-label">Work country</label>
                <select name="work_country" class="form-select" id="work_country" required>
                    <option value="Colombia" {{ (isset($employee->work_country) && $employee->work_country == 'Colombia') ? 'selected' : '' }}>Colombia</option>
                    <option value="Estados Unidos" {{ (isset($employee->work_country) && $employee->work_country == 'Estados Unidos') ? 'selected' : '' }}>Estados Unidos</option>
                </select>
            </div>
            <div class="mb-3 col-4">
                <label for="department" class="form-label">Department</label>
                <select name="department" class="form-select" id="department" required>
                    <option value="Administración" {{ (isset($employee->department) && $employee->department == 'Administración') ? 'selected' : '' }}>Administración</option>
                    <option value="Financiera" {{ (isset($employee->department) && $employee->department == 'Financiera') ? 'selected' : '' }}>Financiera</option>
                    <option value="Compras" {{ (isset($employee->department) && $employee->department == 'Compras') ? 'selected' : '' }}>Compras</option>
                    <option value="Infraestructura" {{ (isset($employee->department) && $employee->department == 'Infraestructura') ? 'selected' : '' }}>Infraestructura</option>
                    <option value="Talento Humano" {{ (isset($employee->department) && $employee->department == 'Talento Humano') ? 'selected' : '' }}>Talento Humano</option>
                    <option value="Servicios Varios" {{ (isset($employee->department) && $employee->department == 'Servicios Varios') ? 'selected' : '' }}>Servicios Varios</option>
                </select>
            </div>

            <div class="mb-3 col-4">
                <label for="start_date" class="form-label">Start date</label>
                <input type="date" id="start_date" class="form-control" name="start_date" value="{{ $employee->start_date ?? '' }}" {{ !isset($employee->start_date) ? 'disabled readonly' : ''}}
                       min="{!! oneMonthAgo() !!}" max="{!! getToday() !!}">
            </div>

        </div>
        <div class="modal-footer pb-0 mt-3 pe-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i>&nbsp; {{ __('general.close') }}
            </button>
            <button type="submit" class="btn btn-success" id="sendButton"><i
                    class="bi bi-sd-card-fill"></i>&nbsp; {{ __('general.save') }}</button>
        </div>
    </form>
</div>
<script>
    $("#createEmployee").on("submit", function (event) {
        event.preventDefault();
        event.stopPropagation();

        let sendButton = $("#sendButton");
        let sendButtonText = sendButton.text();
        let feedbackArea = $("#feedbackArea");

        if (this.checkValidity()) {
            const formValues = $(this).serialize();
            const route = "{!! isset($employee->id) ? route('employees.update', [$employee->id]) : route('employees.store') !!}"
            $.ajax({
                url: route,
                method: '{!! isset($employee->id) ? 'PUT' : 'POST' !!}',
                data: formValues,
                dataType: 'json',
                beforeSend: () => {
                    //Hide previously error message
                    feedbackArea.addClass("d-none");
                    $(".invalid-feedback").fadeOut();
                    $("input").removeClass("is-invalid");

                    // Prevent button from changing width
                    let sendButtonWidth = sendButton.outerWidth();
                    sendButton.css("min-width", sendButtonWidth + "px");

                    // Add spìnner
                    sendButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span class="visually-hidden">Loading...</span>');
                },
                success: (data, textStatus, xhr) => {
                    if (data.success == true && xhr.status == 200) {
                        sendButton.html('<i class="bi bi-check-lg"></i>&nbsp; Saved');
                        feedbackArea.removeClass("alert-danger");
                        feedbackArea.removeClass("d-none");
                        feedbackArea.addClass("alert-success");
                        feedbackArea.fadeIn();
                        feedbackArea.html('The data was correctly saved.');
                        $('#employeesTable').DataTable().ajax.reload();
                        setTimeout(function () {
                            $("#modalWrapper").delay(2500).modal('hide');
                        }, 1800);
                    } else {
                        sendButton.html(sendButtonText);
                        feedbackArea.removeClass("d-none");
                        feedbackArea.fadeIn();
                        feedbackArea.html('');
                    }
                },
                error: (data, textStatus, xhr) => {
                    sendButton.html(sendButtonText);
                    feedbackArea.removeClass("d-none");
                    let errorMessage = ""
                    if (data.status == 422) {
                        let errorList = data.responseJSON.errors;
                        for (const [key, value] of Object.entries(errorList)) {
                            let element = $("input[name="+ key +"]");
                            console.log(element);
                            element.addClass('is-invalid');
                            element.after('<div class="invalid-feedback">'+ value +'</div>');
                        }
                        errorMessage = "Invalid data. Review the submited data and try again.";
                    } else {
                        errorMessage = "An error has occurred. Please try again.";
                    }
                    feedbackArea.html(errorMessage);
                },
            })
        }
    });
</script>

