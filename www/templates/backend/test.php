<div id="id">
    aaaaa
</div>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $('#id').click(function (event) {
            console.log(event);
            alert(1);
        });

    });
</script>