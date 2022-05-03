@extends('layout.base')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>

<div style="width: auto">
    <table id="mytable" class="display expandable-table" style="width: 100%; text-align: center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Project</th>
                <th>Leader</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Process</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@stop
@push('js')
<script>
    $(function() {
        var table = $('#mytable').DataTable({
            processing: true,
            select: false,
            searching: true,
            lengthChange: true,
            lengthMenu: [5, 10, 15],
            paging: true,
            serverSide: true,
            // scrollX: true,
            // scrollY: true,
            ajax: {
                url: "{{ route('project.api') }}",
            },
            columns: [
                { data: 'id', name: 'id'},
                { data: 'project', name: 'project' },
                { data: 'name', name: 'users.name' },
                { data: 'description', name: 'description' },
                { data: 'deadline', name: 'deadline' },
                { data: 'process', name: 'process', 
                    render: function (data, type, row, meta) {
                        return data + '%';
                    }
                },
                { 
                    data: 'Action',
                    targets: 6,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        let id = data['delete'].slice(-1);
                        return `
                        <div class="dropdown">
                        @if(auth()->user()->role->role != 'user')
                            <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdownMenuIconButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-settings"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                <a class="dropdown-item" href=" ${data['edit']}">
                                    Edit
                                </a>
                                    <form onsubmit="return false;" action="${data['delete']}" method="delete" id="${id}">
                                        @csrf
                                        <button id="${data['delete']}" type="submit" class="dropdown-item" onclick="formDelete(this.id)">
                                            Delete
                                        </button>
                                    </form>
                            </div>
                            @endif
                        </div>
                        `;
                    } 
                },
            ],
        });

        formDelete = function(click_id) {
            let id = click_id.slice(-1); // get value id column
            var frm = document.getElementById(id); // get form on button delete
            var rowDeleted = table.row({'id': id}).select(); // get row prepared to delete
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonColor: '#ff4081',
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, delete it! ",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                }
            }).then(function (isConfirm) {
                if(isConfirm) {
                    $.ajax({
                        type: frm.getAttribute('method'),
                        url: frm.getAttribute('action'),
                        success: function (data, status) {
                            rowDeleted.remove().draw(false);
                            alert('success-message', id);
                        },
                        error: function (data, status) {
                            alert('title-and-text', id);
                        },
                    });
                }
            })        
        };
    })
</script>
@endpush