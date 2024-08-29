@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Modal Trigger (hidden by default) -->
    <button type="button" id="triggerPasswordModal" class="btn btn-primary" data-toggle="modal" data-target="#passwordModal" style="display: none;">
        View Generated Password
    </button>

    <!-- Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Generated Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Your account has been created with the following password:</p>
                    <pre>{{ Session::get('generated_password') }}</pre>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('password.choice') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" name="action" value="keep" class="btn btn-success">Keep Password</button>
                        <button type="submit" name="action" value="change" class="btn btn-warning">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap CSS and JS dependencies -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#passwordModal').modal('show');
    });
</script>
@endsection
