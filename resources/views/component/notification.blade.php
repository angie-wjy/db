@if(session('succ'))
<div class="alert alert-success position-fixed bottom-0 end-0 m-3 alert-dismissible fade show" id="alert" role="alert">
    <strong>Success!</strong> {{ session('succ') }}
    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
</div>
@endif
@if(session('err'))
<div class="alert alert-danger position-fixed bottom-0 end-0 m-3 alert-dismissible fade show" id="alert" role="alert">
    <strong>{{ session('err') }}</strong>
    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
</div>
@endif

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(function(){
        setTimeout(function() {
            $('#alert').fadeOut(500,function(){
                $(this).remove();
            });
        }, 2000);
    })
</script>
