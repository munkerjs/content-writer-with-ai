<?php if ( ! defined( 'ABSPATH' ) ) exit; // Doğrudan erişimi engelle ?>

<?php if ( current_user_can( 'manage_options' ) ): ?>
    <div class="card wrap">
        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
                settings_fields( 'content_writer_ai_settings' );
                do_settings_sections( 'content-writer-ai-settings' );
                wp_nonce_field('content_writer_ai_settings_action', 'content_writer_ai_settings_nonce');

                // API Anahtarını kontrol et
                $api_key = get_option('content_writer_ai_api_key');
                // API Anahtarını doğrula
                if ( ! empty( $api_key ) && $this->is_api_key_valid($api_key) ) {

                    $model = get_option('content_writer_ai_model');
                    $language = get_option('content_writer_ai_language');
                    $max_tokens = get_option('content_writer_ai_max_tokens');

                    ?>
                    <hr>
                    <h2>Model Seçimi</h2>
                    <select name="content_writer_ai_model">
                        <option value="davinci" <?php selected($model, 'davinci'); ?>>Davinci</option>
                        <option value="curie" <?php selected($model, 'curie'); ?>>Curie</option>
                        <option value="babbage" <?php selected($model, 'babbage'); ?>>Babbage</option>
                        <option value="ada" <?php selected($model, 'ada'); ?>>Ada</option>
                        <option value="dall-e" <?php selected($model, 'dall-e'); ?>>DALL-E (Görsel İçerik)</option>
                    </select>

                    <h2>Maksimum Token Sayısı</h2>
                    <input type="number" name="content_writer_ai_max_tokens" value="<?php echo esc_attr($max_tokens); ?>" />

                    <h2>Dil Seçenekleri</h2>
                    <select name="content_writer_ai_language">
                        <option value="en" <?php selected($language, 'en'); ?>>İngilizce</option>
                        <option value="de" <?php selected($language, 'de'); ?>>Almanca</option>
                        <option value="fr" <?php selected($language, 'fr'); ?>>Fransızca</option>
                        <option value="tr" <?php selected($language, 'tr'); ?>>Türkçe</option>
                        <!-- Diğer dil seçenekleri -->
                    </select>
                    <?php
                } 

                submit_button( 'Ayarları Kaydet' );
            ?>
        </form>
    </div>
<?php else: ?>
    <p>Erişim izniniz yok.</p>
<?php endif; ?>
