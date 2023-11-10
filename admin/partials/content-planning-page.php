<?php if ( ! defined( 'ABSPATH' ) ) exit; // Doğrudan erişimi engelle ?>

<?php if ( current_user_can( 'manage_options' ) ): ?>
    <div class="card wrap">
        <?php settings_errors(); ?>
        <p>Selam!</p>
        
    </div>
<?php else: ?>
    <p>Erişim izniniz yok.</p>
<?php endif; ?>
