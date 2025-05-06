<?php

  


require_once __DIR__.'/../includes/navbar.php';
?>

 

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page">
                <h1 class="display-1 text-primary">404</h1>
                <h2 class="mb-4">Sayfa Bulunamadı</h2>
                <p class="lead mb-4">Aradığınız sayfa bulunamadı veya taşınmış olabilir.</p>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="/" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Ana Sayfaya Dön
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Geri Dön
                    </a>
                </div>

                <div class="mt-5">
                    <h3 class="h5 mb-3">Yardımcı olabilecek sayfalar:</h3>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="/pages/campaigns.php" class="text-decoration-none">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-percentage fa-2x text-primary mb-2"></i>
                                        <h4 class="h6">Kampanyalar</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/pages/stores.php" class="text-decoration-none">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-store fa-2x text-primary mb-2"></i>
                                        <h4 class="h6">Mağazalar</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="/pages/contact.php" class="text-decoration-none">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                        <h4 class="h6">İletişim</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 3rem 0;
}

.error-page h1 {
    font-size: 8rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 1rem;
}

.error-page .card {
    transition: transform 0.2s;
}

.error-page .card:hover {
    transform: translateY(-5px);
}
</style>


<?php 
require_once __DIR__.'/../includes/footer.php';
?>