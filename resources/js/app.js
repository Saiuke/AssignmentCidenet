require('./bootstrap');
import swal from 'sweetalert';

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    function loadModalContent() {
        var myModalEl = document.getElementById('modalWrapper')
        myModalEl.addEventListener('show.bs.modal', function (event) {
            let clickedButton = event.relatedTarget;
            console.log($(clickedButton).attr('id'));
        })

    }

    /*
    ==============================================================================================
    MODALS
    ==============================================================================================
    */

    // Variables
    var modalWrapper = document.getElementById('modalWrapper')

    // Event handlers
    modalWrapper.addEventListener('hidden.bs.modal', function (event) {
        resetModalContent();
    });

    modalWrapper.addEventListener('shown.bs.modal', function (event) {
        let clickedButton = event.relatedTarget;
        let callURL = $(clickedButton).attr('data-content-source');
        $.get(callURL, function (data) {
            $('.spinner-border').fadeOut();
            $('#modalWrapper .modal-content').html(data);
        });
    });

    // Functions
    function resetModalContent() {
        let modalDefaultLoader = `
    <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="bi bi-hdd-network"></i>&nbsp; Loading</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body d-flex align-items-center justify-content-center" style="min-height: 75vh;">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading</span>
        </div>
    </div>`;
        $('#modalWrapper .modal-content').html(modalDefaultLoader);
    }
});
