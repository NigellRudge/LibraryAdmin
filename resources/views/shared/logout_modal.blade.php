<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title" id="logoutModalLabel">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-light">&times;</span>
                </button>
            </div>
            <form method="post" action={{ route('logout') }}#" id="logout_form">
                @csrf
                <div class="modal-body">
                    <div class="d-flex flex-row align-baseline">
                        <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                            <i class="far fa-question-circle"></i>
                        </div>
                        <div class="pt-4 text-dark">
                            Are you sure you want to Logout<br>
                            <div class="d-inline text-teal font-weight-bold" id="confirm_book"></div> ?
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const OpenLogOutModal  = ($event)=>{
        $event.preventDefault()
        $('#logoutModal').modal('show')
    }
</script>
