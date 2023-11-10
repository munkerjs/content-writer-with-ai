<?php if ( ! defined( 'ABSPATH' ) ) exit; // Doğrudan erişimi engelle ?>

<?php if ( current_user_can( 'manage_options' ) ): ?>
    <div class="card wrap">
        <h1>Content Writer AI</h1>
        <p>Bu eklenti, OpenAI servislerini kullanarak WordPress sitenizde otomatik içerik oluşturmanızı sağlar.</p>
        <h2>Kullanım Talimatları</h2>
        <ol>
            <li>Öncelikle, Ayarlar sayfasından OpenAI API Anahtarınızı girin.</li>
            <li>Şablonlar sayfasını kullanarak içerik oluşturmak için şablonlar oluşturun.</li>
            <li>İçerik Planlaması sayfasından otomatik içerik oluşturmayı planlayın.</li>
        </ol>
    </div>
<?php else: ?>
    <p>Erişim izniniz yok.</p>
<?php endif; ?>
