@include('shared.datatable_js')
@include('shared.sweet-alert-js')
@include('shared.validator')
@include('shared.select2-js')
@include('shared.date-ranger-picker-js')
@include('shared.toastrJS')
@include('shared.fullcalendar_js')

<script>
    const makeRequest = (url='',method='get',data={},complete)=> {
        $.ajax({
            url:url,
            method:method,
            data:data,
            complete
        })
    }
</script>
