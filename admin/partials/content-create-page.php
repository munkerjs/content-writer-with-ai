<?php if ( ! defined( 'ABSPATH' ) ) exit; // Doğrudan erişimi engelle ?>

<?php if ( current_user_can( 'manage_options' ) ): ?>
    <div class="card wrap">
        <h1>Özel İçerik Üretici</h1>
        <form id="content-form">
            <label for="topic">Konu:</label>
            <input type="text" name="topic" id="topic">
            <input type="submit" value="İçerik Üret">
        </form>

        <div id="icerik"></div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#content-form').submit(function(event) {
                event.preventDefault();
                var topic = $('#topic').val();

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        'action': 'generate_content',
                        'topic': topic
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#icerik').html('<p>' + response.data.content + '</p>');
                        } else {
                            $('#icerik').html('<p>Hata: ' + response.data.message + '</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hata durumunda bu blok çalışacak
                        console.error("Hata oluştu: " + error);
                    }
                });
            });
        });
    </script>

<?php else: ?>
    <p>Erişim izniniz yok.</p>
<?php endif; ?>

