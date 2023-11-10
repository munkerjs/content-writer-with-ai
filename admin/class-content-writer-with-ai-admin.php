<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://erkadam.dev
 * @since      1.0.0
 *
 * @package    Content_Writer_With_Ai
 * @subpackage Content_Writer_With_Ai/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Content_Writer_With_Ai
 * @subpackage Content_Writer_With_Ai/admin
 * @author     Münker Erkadam <info@erkadam.dev>
 */
class Content_Writer_With_Ai_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_action('admin_init', array($this, 'register_and_build_fields'));
        add_action('admin_init', array($this, 'save_settings'));
		add_action('wp_ajax_generate_content', array($this, 'ajax_generate_content'));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/content-writer-with-ai-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/content-writer-with-ai-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {
		add_menu_page(
			'Content Writer AI', // Sayfa başlığı
			'Content Writer AI', // Menü başlığı
			'manage_options', // Yetki
			'content-writer-ai', // Menü slug
			array($this, 'display_plugin_setup_page'), // Fonksiyon
			'dashicons-admin-generic', // İkon
			26 // Pozisyon
		);
	
		add_submenu_page(
			'content-writer-ai', // Ana slug
			'Ayarlar', // Sayfa başlığı
			'Ayarlar', // Menü başlığı
			'manage_options', // Yetki
			'content-writer-ai-settings', // Menü slug
			array($this, 'display_settings_page') // Fonksiyon
		);

		add_submenu_page(
			'content-writer-ai', // Ana slug
			'İçerik Planlama', // Sayfa başlığı
			'İçerik Planlama', // Menü başlığı
			'manage_options', // Yetki
			'content-writer-ai-planning', // Menü slug
			array($this, 'display_content_planning_page') // Fonksiyon
		);

		add_submenu_page(
			'content-writer-ai', // Ana slug
			'İçerik Üretici', // Sayfa başlığı
			'İçerik Üretici', // Menü başlığı
			'manage_options', // Yetki
			'content-writer-ai-create-prort', // Menü slug
			array($this, 'display_content_create_page') // Fonksiyon
		);
	
		// Benzer şekilde diğer alt menüler eklenebilir
	}

	public function display_plugin_setup_page() {
		include_once plugin_dir_path(__FILE__) . 'partials/plugin-setup-page.php';
	}	

	
	public function display_settings_page() {
		include_once plugin_dir_path(__FILE__) . 'partials/settings-page.php';
	}

	public function display_content_planning_page() {
		// HTML form ve ayarlar burada
		include_once plugin_dir_path(__FILE__) . 'partials/content-planning-page.php';
	}
	
	public function display_content_create_page() {
		// HTML form ve ayarlar burada
		include_once plugin_dir_path(__FILE__) . 'partials/content-create-page.php';
	}
	
	public function register_and_build_fields() {
        // Ayarlar bölümünü kaydet
        add_settings_section(
            'content_writer_ai_settings_section',
            'OpenAI Ayarları',
            null,
            'content-writer-ai-settings'
        );

        // API Anahtarı alanını ekle ve kaydet
        add_settings_field(
            'content_writer_ai_api_key',
            'OpenAI API Anahtarı',
            array($this, 'api_key_field_callback'),
            'content-writer-ai-settings',
            'content_writer_ai_settings_section'
        );
        register_setting('content_writer_ai_settings', 'content_writer_ai_api_key');

        // Ek ayarlar (Model, Token Sayısı, Dil)
        // Bu ayarları API anahtarı doğrulandıktan sonra göstermek için şimdilik kaydetmiyoruz
    }

    public function api_key_field_callback() {
        $api_key = get_option('content_writer_ai_api_key');
        echo '<input type="text" id="content_writer_ai_api_key" name="content_writer_ai_api_key" value="' . esc_attr($api_key) . '"/>';
    }

	// OpenAI API anahtarını sorgulama
	public function is_api_key_valid($api_key) {
		// OpenAI API endpoint. Bu örnek için geçici bir URL kullanıyoruz.
		// Gerçek bir uygulamada, OpenAI'nin belirli bir endpoint'ini kullanıyoruz.
		$url = 'https://api.openai.com/v1/engines';
	
		$response = wp_remote_get($url, array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $api_key
			)
		));
	
		// HTTP isteğinin durumunu kontrol et
		if (is_wp_error($response)) {
			return false; // İstek hatası varsa, anahtar geçersizdir
		}
	
		$response_code = wp_remote_retrieve_response_code($response);
		return ($response_code === 200); 
	}

	public function save_settings() {
        // Nonce değerini kontrol et
        if (!isset($_POST['content_writer_ai_settings_nonce']) || 
            !wp_verify_nonce($_POST['content_writer_ai_settings_nonce'], 'content_writer_ai_settings_action')) {
            return; // Nonce geçersizse işlemi sonlandır
        }

        // API Anahtarı kontrolü
        if (isset($_POST['content_writer_ai_api_key'])) {
            $api_key = trim($_POST['content_writer_ai_api_key']);

            if (empty($api_key)) {
                // API Anahtarı boş ise hata mesajı ekle
                add_settings_error(
                    'content_writer_ai_settings',
                    'content_writer_ai_api_key_error',
                    'Lütfen geçerli bir OpenAI API Anahtarı giriniz.',
                    'error'
                );
            } else {
                // Anahtar boş değilse, kaydet
                update_option('content_writer_ai_api_key', sanitize_text_field($api_key));
                // Diğer ayarları kaydet
            }
        }

		if (!empty($api_key)) {
			// Model Seçimi
			if (isset($_POST['content_writer_ai_model'])) {
				update_option('content_writer_ai_model', sanitize_text_field($_POST['content_writer_ai_model']));
			}		
	
			// Maksimum Token Sayısı
			if (isset($_POST['content_writer_ai_max_tokens'])) {
				update_option('content_writer_ai_max_tokens', intval($_POST['content_writer_ai_max_tokens']));
			}
	
			// Dil Seçenekleri
			if (isset($_POST['content_writer_ai_language'])) {
				update_option('content_writer_ai_language', sanitize_text_field($_POST['content_writer_ai_language']));
			}
		}		
    }
	
	public function generate_content($topic) {
        $model = get_option('content_writer_ai_model', 'text-davinci-003'); // Varsayılan model
        $max_tokens = get_option('content_writer_ai_max_tokens', 150); // Varsayılan token sayısı
        $api_key = get_option('content_writer_ai_api_key'); // API Anahtarı

        if (empty($api_key)) {
            return 'API anahtarı bulunamadı. Lütfen ayarlarınızı kontrol edin.';
        }

        $url = 'https://api.openai.com/v1/engines/' . $model . '/completions';
        $body = json_encode(array(
            'prompt' => $topic,
            'max_tokens' => $max_tokens
        ));

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => $body,
            'method' => 'POST',
            'data_format' => 'body'
        ));

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return 'OpenAI API ile iletişimde bir hata oluştu: ' . wp_remote_retrieve_response_message($response);
        }

        $response_body = json_decode(wp_remote_retrieve_body($response), true);
		if (isset($response_body['error'])) {
			return 'Hata: ' . $response_body['error']['message'];
		}
		
        return isset($response_body['choices'][0]['text']) ? $response_body['choices'][0]['text'] : 'İçerik üretilemedi.';
    }

	public function ajax_generate_content() {
		if (isset($_POST['topic'])) {
			$topic = sanitize_text_field($_POST['topic']);
			$content = $this->generate_content($topic);
	
			if ($content !== null) {
				wp_send_json_success(array('content' => $content));
			} else {
				wp_send_json_error(array('message' => 'İçerik üretilirken bir hata oluştu.'));
			}
		} else {
			wp_send_json_error(array('message' => 'Konu sağlanmadı.'));
		}
	}




























			

}
