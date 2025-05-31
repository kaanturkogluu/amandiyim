<footer class="site-footer">
    <div class="container">
        <div class="footer-container">
            <div class="footer-column">
                <div class="footer-logo">
                    <i class="fas fa-tags"></i>
                    <span>AMANdiyim</span>
                </div>
                <p class="footer-desc">
                    Şehirdeki en iyi indirim ve kampanyaları sizlerle buluşturan platformunuz.
                    Her an her yerden en avantajlı fırsatlara erişim.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">Hızlı Bağlantılar</h3>
                <ul class="footer-links">
                    <li><a href="anasayfa.php"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                    <li><a href="magazalar.php"><i class="fas fa-store"></i> Mağazalar</a></li>
                    <li><a href="anasayfa.php#campaigns"><i class="fas fa-percent"></i> Kampanyalar</a></li>
                    <li><a href="hakkimizda.php"><i class="fas fa-info-circle"></i> Hakkımızda</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">Kategoriler</h3>
                <ul class="footer-links">
                    <li><a href="magazalar.php?category=1"><i class="fas fa-utensils"></i> Restoran</a></li>
                    <li><a href="magazalar.php?category=2"><i class="fas fa-tshirt"></i> Moda</a></li>
                    <li><a href="magazalar.php?category=3"><i class="fas fa-mobile-alt"></i> Elektronik</a></li>
                    <li><a href="magazalar.php?category=4"><i class="fas fa-hotel"></i> Konaklama</a></li>
                    <li><a href="magazalar.php?category=5"><i class="fas fa-calendar-alt"></i> Etkinlik</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3 class="footer-title">İletişim</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Dörtyol, Hatay</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p>info@amandiyim.com</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <p>7/24 Hizmet</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; 2025 AMANdiyim. Tüm hakları saklıdır.</p>
            </div>
            <div class="footer-bottom-links">
                <a href="gizlilik-politikasi.php">Gizlilik Politikası</a>
                <a href="kullanim-kosullari.php">Kullanım Koşulları</a>
                <a href="cerez-politikasi.php">Çerez Politikası</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
        color: #fff;
        padding: 60px 0 20px;
       
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    .footer-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
    }

    .footer-logo i {
        color: var(--primary);
        font-size: 2rem;
    }

    .footer-desc {
        color: #a0aec0;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--primary);
        transform: translateY(-3px);
    }

    .footer-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 2px;
        background: var(--primary);
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer-links a {
        color: #a0aec0;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: var(--primary);
        transform: translateX(5px);
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #a0aec0;
    }

    .contact-item i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .copyright {
        color: #a0aec0;
        font-size: 0.9rem;
    }

    .footer-bottom-links {
        display: flex;
        gap: 20px;
    }

    .footer-bottom-links a {
        color: #a0aec0;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .footer-bottom-links a:hover {
        color: var(--primary);
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }

        .footer-bottom-links {
            justify-content: center;
        }
    }
</style>

</body>
</html>