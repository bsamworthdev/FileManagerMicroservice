@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Files List<h4>
                            </div>
                            <div class="col-md-4">
                                <button id="addFile" class="btn btn-primary btn-sm float-right" 
                                    data-toggle="modal" 
                                    data-target="#addFileModal">
                                    + Add New
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (count($files))
                            <table id="filesTable" class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">File (&pound;)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($files as $file)
                                <tr>
                                    <td>
                                        {{ $file['name'] }}
                                    </td>
                                    <td>
                                        {{ $file['file'] }}
                                    </td>
                                    <td>
                                    <button onclick="deleteClicked({{ $file['id'] }}, '{{ $file['name'] }} ');" class="btn btn-danger btn-sm"
                                        data-toggle="modal" 
                                        data-target="#deleteFileModal"
                                        data-file-id="{{ $file['id'] }}">
                                        Delete
                                    </button>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        @else 
                            <i>Empty</i>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    
</div>
<div class="modal fade" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="/addfile" method="POST" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="number" min="0.00" max="10000.00" step="0.01" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete File</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="/deletefile" method="POST" class="form-horizontal">
        @csrf
        <div class="modal-body">
            <label>Delete <span id="fileName"></span>?</label>
            <input type="hidden" id="file_id" name="file_id"/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">
                Delete
            </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
