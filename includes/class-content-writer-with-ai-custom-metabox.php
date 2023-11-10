<?php
// Eğer bu dosya doğrudan erişilerek çağrılırsa, WordPress çekirdeğinden çık
if (!defined('ABSPATH')) {
    exit;
}

class Content_Writer_With_AI_Custom_Metabox {

    public function __construct() {
        add_action('category_edit_form_fields', array($this, 'add_category_custom_field'));
        add_action('edited_category', array($this, 'save_category_custom_field'));
    }

    public function add_category_custom_field($term) {
        $prompt = get_term_meta($term->term_id, 'content_writer_ai_prompt', true);

        ?>
        <tr class="form-field">
        <th scope="row" valign="top"><label for="content_writer_ai_prompt"><?php _e('Kategori Proptu'); ?></label></th>
        <td>
            <textarea name="content_writer_ai_prompt" id="content_writer_ai_prompt" rows="5" cols="50" class="large-text"><?php echo esc_textarea($prompt); ?></textarea>
            <p class="description"><?php _e('Bu kategori için yapay zeka tarafından oluşturulacak yazılar için bir propt belirleyin ve bu kurallara göre yazılar oluşsun.'); ?></p>
        </td>
        </tr>
        <?php
    }

    public function save_category_custom_field($term_id) {
        if (isset($_POST['content_writer_ai_prompt'])) {
            update_term_meta(
                $term_id,
                'content_writer_ai_prompt',
                sanitize_textarea_field($_POST['content_writer_ai_prompt'])
            );
        }
    }
}

// Sınıfı başlat
$content_writer_ai_custom_metabox = new Content_Writer_With_AI_Custom_Metabox();
