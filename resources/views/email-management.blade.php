@extends('layouts.app')
@section('content')
<div class="container col-md-12">
    <div id="loader" class="text-center" style="display: none;">
        <div class="spinner-grow text-danger" role="status">

        </div>
    </div>
    <h2>Event List</h2>
    <!-- Filter for Mail Status -->
    <div class="mb-3">
        <label for="statusFilter" class="form-label">Filter by Mail Status:</label>
        <select id="statusFilter" class="form-select">
            <option value="">All</option>
            <option value="Sent">Sent</option>
            <option value="Failed">Failed</option>
        </select>
    </div>
    <table id="eventsTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Mail Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/yajra/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<script>
var table;
$(document).ready(function() {
    table = $('#eventsTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: {
            url: "{{ route('events.data') }}",
            data: function(d) {
                d.status = $('#statusFilter').val();
            }
        },
        columns: [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'mail_status',
                name: 'mail_status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        "initComplete": function(settings, json) {
            $('#statusFilter').on('change', function() {
                table.ajax.reload();
            });
        }
    });
});
$(document).on('click', '.resend-mail', function() {
    var eventId = $(this).data('id');

    if (confirm("Are you sure you want to resend the mail for this event?")) {
        $('#loader').show();
        $.ajax({
            url: "/events/resend-mail/" + eventId,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    alert('Mail resent successfully.');
                    table.ajax.reload()
                } else {
                    alert('Failed to resend the mail: ' + response.message);
                }
            },
            error: function() {
                $('#loader').hide();
                alert('An error occurred while trying to resend the mail.');
            }
        });
    }
});
</script>
@endsection