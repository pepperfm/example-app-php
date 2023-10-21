<script type="text/javascript" src="<?php echo '/public/assets/js/jquery.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo '/public/assets/js/jquery.validate.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo '/public/assets/js/moment.min.js' ?>"></script>

<script>
    $(document).ready(function() {
        $('form').validate()

        $('.view-state').on('click', function (e) {
            e.preventDefault()

            var type = $(this).data('type')

            $('.box-view').hide()
            $('.box-' + type).show()
        })

        //remove alert
        setTimeout(function () {
            if (typeof $('.alert') !== 'undefined') {
                $('.alert').remove()
            }
        }, 3000)

        //confirm delete work
        $('.delete-task').on('click', function (e) {
            e.preventDefault()

            var href = $(this).attr('href')

            if (confirm('Are you sure to delete?') == true){
                window.location.href = href
            }
        })
    })
</script>

</body>
</html>
